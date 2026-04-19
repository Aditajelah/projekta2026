<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('latitude_south', 10, 7)->nullable()->after('location');
            $table->decimal('latitude_north', 10, 7)->nullable()->after('latitude_south');
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->decimal('latitude_south', 10, 7)->nullable()->after('location');
            $table->decimal('latitude_north', 10, 7)->nullable()->after('latitude_south');
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->decimal('latitude_south', 10, 7)->nullable()->after('location');
            $table->decimal('latitude_north', 10, 7)->nullable()->after('latitude_south');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['latitude_south', 'latitude_north']);
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->dropColumn(['latitude_south', 'latitude_north']);
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['latitude_south', 'latitude_north']);
        });
    }
};
