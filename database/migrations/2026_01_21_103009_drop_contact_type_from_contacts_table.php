<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // If your index name differs, change to $table->dropIndex('contacts_contact_type_index');
            try {
                $table->dropIndex(['contact_type']);
            } catch (\Throwable $e) {
                // ignore if index name is different or already removed
            }

            if (Schema::hasColumn('contacts', 'contact_type')) {
                $table->dropColumn('contact_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'contact_type')) {
                $table->string('contact_type')->index();
            }
        });
    }
};
