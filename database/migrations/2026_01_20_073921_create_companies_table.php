<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Core identity
            $table->string('legal_name');
            $table->string('trading_name')->nullable();
            $table->string('registration_number')->nullable();

            // Addresses
            $table->text('registered_address')->nullable();
            $table->text('operational_address')->nullable();

            // Preferences
            $table->string('default_currency', 3)->default('USD');
            $table->string('language', 5)->default('en');
            $table->string('time_zone')->default('UTC');

            // Branding
            $table->string('logo')->nullable(); // path or URL

            // Status
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
