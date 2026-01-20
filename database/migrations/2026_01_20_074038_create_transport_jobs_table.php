<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('transport_jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('contacts')
                ->nullOnDelete();

            $table->string('account_number')->nullable()->index();
            $table->string('customer')->nullable();
            $table->string('quote_ref')->nullable()->index();

            $table->string('job_number')->unique();
            $table->date('job_date')->nullable();

            $table->string('mode_of_transport')->index(); // air, sea, road, rail
            $table->string('job_type')->index();          // import, export, domestic, cross_trade

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_jobs');
    }
};
