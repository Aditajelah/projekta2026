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
        $this->dropDestinationReference('culinaries');
        $this->dropDestinationReference('stays');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->restoreDestinationReference('culinaries');
        $this->restoreDestinationReference('stays');
    }

    private function dropDestinationReference(string $table): void
    {
        if (! Schema::hasColumn($table, 'id_destinations')) {
            return;
        }

        try {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropForeign(['id_destinations']);
            });
        } catch (\Throwable $e) {
            // Ignore when FK does not exist.
        }

        Schema::table($table, function (Blueprint $blueprint) {
            $blueprint->dropColumn('id_destinations');
        });
    }

    private function restoreDestinationReference(string $table): void
    {
        if (Schema::hasColumn($table, 'id_destinations')) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) {
            $blueprint->unsignedBigInteger('id_destinations')->nullable()->after('id_' . $table);
        });
    }
};
