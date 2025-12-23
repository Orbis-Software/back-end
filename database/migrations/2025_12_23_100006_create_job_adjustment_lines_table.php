<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_adjustment_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('cargo_jobs')
                ->cascadeOnDelete();

            $table->string('type');
            $table->string('description')->nullable();

            $table->decimal('amount_delta', 12, 2);
            $table->char('currency', 3);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_adjustment_lines');
    }
};
