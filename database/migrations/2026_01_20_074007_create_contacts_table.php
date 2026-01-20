<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->string('contact_type')->index(); // customer, supplier, agent
            $table->string('address')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('eori')->nullable();

            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->string('currency_preference', 3)->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
