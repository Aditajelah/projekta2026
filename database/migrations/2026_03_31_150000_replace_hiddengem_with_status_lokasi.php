<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['destinations', 'culinaries', 'stays'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'status_lokasi')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->enum('status_lokasi', ['terkenal', 'hidden gem'])->default('terkenal');
                });
            }

            if (Schema::hasColumn($table, 'hiddengem')) {
                DB::table($table)
                    ->where('hiddengem', 'hiddengem')
                    ->update(['status_lokasi' => 'hidden gem']);

                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('hiddengem');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['destinations', 'culinaries', 'stays'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'hiddengem')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->enum('hiddengem', ['hiddengem', 'bukanhiddengem'])->default('bukanhiddengem');
                });
            }

            if (Schema::hasColumn($table, 'status_lokasi')) {
                DB::table($table)
                    ->where('status_lokasi', 'hidden gem')
                    ->update(['hiddengem' => 'hiddengem']);

                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('status_lokasi');
                });
            }
        }
    }
};
