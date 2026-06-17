<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('deactivation_reason_code', 60)->nullable()->after('is_active');
            $table->text('deactivation_reason_detail')->nullable()->after('deactivation_reason_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['deactivation_reason_code', 'deactivation_reason_detail']);
        });
    }
};
