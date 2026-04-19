<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['destinations', 'culinaries', 'stays'];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE {$table} ADD COLUMN status_lokasi ENUM('terkenal','hidden gem') NOT NULL DEFAULT 'terkenal' AFTER image_url");
            DB::statement("UPDATE {$table} SET status_lokasi = CASE WHEN hiddengem = 'hiddengem' THEN 'hidden gem' ELSE 'terkenal' END");
            DB::statement("ALTER TABLE {$table} DROP COLUMN hiddengem");
        }
    }

    public function down(): void
    {
        $tables = ['destinations', 'culinaries', 'stays'];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE {$table} ADD COLUMN hiddengem ENUM('hiddengem','bukanhiddengem') NOT NULL DEFAULT 'bukanhiddengem' AFTER image_url");
            DB::statement("UPDATE {$table} SET hiddengem = CASE WHEN status_lokasi = 'hidden gem' THEN 'hiddengem' ELSE 'bukanhiddengem' END");
            DB::statement("ALTER TABLE {$table} DROP COLUMN status_lokasi");
        }
    }
};
