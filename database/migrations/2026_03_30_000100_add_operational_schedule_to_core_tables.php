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
            $table->string('operational_days')->nullable();
            $table->string('operational_hours')->nullable();
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->string('operational_days')->nullable();
            $table->string('operational_hours')->nullable();
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->string('operational_days')->nullable();
            $table->string('operational_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['operational_days', 'operational_hours']);
        });

        Schema::table('culinaries', function (Blueprint $table) {
            $table->dropColumn(['operational_days', 'operational_hours']);
        });

        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['operational_days', 'operational_hours']);
        });
    }
};