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
        Schema::table('ratings', function (Blueprint $table) {
            // On MySQL, this unique index may be used by the user_id FK.
            // Drop FK first so index can be safely removed.
            $table->dropForeign(['user_id']);
            $table->dropUnique('user_rateable_unique');
            $table->unsignedTinyInteger('rating')->nullable()->change();
            $table->foreignId('parent_id')->nullable()->after('rateable_id')->constrained('ratings')->nullOnDelete();
            $table->index(['rateable_type', 'rateable_id', 'created_at'], 'rateable_created_at_index');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex('rateable_created_at_index');
            $table->dropConstrainedForeignId('parent_id');
            $table->unsignedTinyInteger('rating')->nullable(false)->change();
            $table->unique(['user_id', 'rateable_type', 'rateable_id'], 'user_rateable_unique');
        });
    }
};
