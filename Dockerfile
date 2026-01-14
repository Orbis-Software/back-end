# ---- Build stage: install composer deps (no scripts because artisan isn't copied yet) ----
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts


# ---- Runtime stage: PHP + Apache ----
FROM php:8.2-apache

# System deps + PHP extensions commonly needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libzip-dev libicu-dev libpq-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip intl \
  && a2enmod rewrite \
  && rm -rf /var/lib/apt/lists/*

# Apache: point DocumentRoot to /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy app source first (so artisan exists)
COPY . .

# Copy vendor from build stage
COPY --from=vendor /app/vendor ./vendor

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

# Run Laravel safe boot steps at container start, then start Apache
CMD php artisan package:discover --ansi || true \
 && php artisan config:cache || true \
 && php artisan route:cache || true \
 && apache2-foreground
