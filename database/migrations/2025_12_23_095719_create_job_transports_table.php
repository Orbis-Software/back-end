<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('job_transports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('cargo_jobs')
                ->cascadeOnDelete();

            $table->string('transport_mode');
            $table->unsignedInteger('sequence')->default(1);

            $table->string('origin')->nullable();
            $table->string('destination')->nullable();

            $table->string('status')->default('planned');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_transports');
    }
};
