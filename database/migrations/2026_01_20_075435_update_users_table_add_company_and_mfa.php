<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Multi-tenant link
            $table->foreignId('company_id')
                ->nullable()
                ->after('id')
                ->constrained('companies')
                ->nullOnDelete();

            // Security / audit
            $table->boolean('mfa_enabled')->default(false)->after('remember_token');
            $table->timestamp('mfa_confirmed_at')->nullable();
            $table->timestamp('mfa_last_used_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn([
                'company_id',
                'mfa_enabled',
                'mfa_confirmed_at',
                'mfa_last_used_at',
                'last_login_at',
            ]);
        });
    }
};
