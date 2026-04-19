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
            $table->string('place_address')->nullable()->after('location');
            $table->string('city')->nullable()->after('place_address');
            $table->string('province')->nullable()->after('city');
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->string('place_address')->nullable()->after('location');
            $table->string('city')->nullable()->after('place_address');
            $table->string('province')->nullable()->after('city');
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->string('place_address')->nullable()->after('location');
            $table->string('city')->nullable()->after('place_address');
            $table->string('province')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['place_address', 'city', 'province']);
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->dropColumn(['place_address', 'city', 'province']);
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['place_address', 'city', 'province']);
        });
    }
};
