<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        DB::table('contacts')
            ->select('id', 'contact_type')
            ->whereNotNull('contact_type')
            ->orderBy('id')
            ->chunk(500, function ($contacts) {
                $rows = [];

                foreach ($contacts as $c) {
                    $rows[] = [
                        'contact_id'   => $c->id,
                        'contact_type' => $c->contact_type,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }

                DB::table('contact_contact_types')->insertOrIgnore($rows);
            });
    }

    public function down(): void
    {
        DB::table('contact_contact_types')->truncate();
    }
};
