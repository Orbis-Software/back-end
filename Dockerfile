# ---- Build stage: install composer deps ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# ---- Runtime stage: PHP + Apache ----
FROM php:8.2-apache

# System deps + PHP extensions commonly needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libzip-dev libicu-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip intl \
  && a2enmod rewrite \
  && rm -rf /var/lib/apt/lists/*

# Apache: point DocumentRoot to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy app source
COPY . .

# Copy vendor from build stage
COPY --from=vendor /app/vendor ./vendor

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Render provides PORT; Apache listens on 80 internally, Render maps it.
EXPOSE 80

# Simple entrypoint: cache config/routes and run apache
CMD php artisan config:cache || true && php artisan route:cache || true && apache2-foreground
