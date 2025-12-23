<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('cargo_jobs')
                ->cascadeOnDelete();

            $table->string('payment_method');
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3);

            $table->string('external_reference')->nullable();
            $table->string('status')->default('pending');

            $table->timestamp('received_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['payment_method', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_payments');
    }
};
