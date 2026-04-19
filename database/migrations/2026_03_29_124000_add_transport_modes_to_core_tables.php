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
            $table->json('transport_modes')->nullable()->after('latitude_north');
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->json('transport_modes')->nullable()->after('latitude_north');
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->json('transport_modes')->nullable()->after('latitude_north');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('transport_modes');
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->dropColumn('transport_modes');
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn('transport_modes');
        });
    }
};
