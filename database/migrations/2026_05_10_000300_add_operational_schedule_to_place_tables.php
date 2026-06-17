<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['destinations', 'culinaries', 'stays'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->json('operational_schedule')->nullable()->after('operational_hours');
            });
        }
    }

    public function down(): void
    {
        foreach (['destinations', 'culinaries', 'stays'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('operational_schedule');
            });
        }
    }
};
