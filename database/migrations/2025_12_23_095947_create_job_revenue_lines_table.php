<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('job_revenue_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('cargo_jobs')
                ->cascadeOnDelete();

            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_revenue_lines');
    }
};
