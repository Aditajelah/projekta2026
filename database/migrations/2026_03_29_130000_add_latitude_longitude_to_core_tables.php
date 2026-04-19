<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('province');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('province');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('province');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });

        // Best-effort migration from legacy ambiguous columns.
        DB::table('destinations')->update([
            'latitude' => DB::raw('COALESCE(latitude, latitude_north)'),
            'longitude' => DB::raw('COALESCE(longitude, latitude_south)'),
        ]);

        DB::table('culinaries')->update([
            'latitude' => DB::raw('COALESCE(latitude, latitude_north)'),
            'longitude' => DB::raw('COALESCE(longitude, latitude_south)'),
        ]);

        DB::table('stays')->update([
            'latitude' => DB::raw('COALESCE(latitude, latitude_north)'),
            'longitude' => DB::raw('COALESCE(longitude, latitude_south)'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
