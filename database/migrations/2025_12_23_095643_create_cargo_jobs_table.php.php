<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('cargo_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('job_reference')->unique();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status')->default('draft');
            $table->string('payment_status')->default('unpaid');

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'payment_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargo_jobs');
    }
};
