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
        $this->dropLegacyCoordinateColumns('destinations');
        $this->dropLegacyCoordinateColumns('culinaries');
        $this->dropLegacyCoordinateColumns('stays');

        $this->addDestinationForeignKeyIfDataValid('culinaries');
        $this->addDestinationForeignKeyIfDataValid('stays');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropDestinationForeignKeyIfExists('culinaries');
        $this->dropDestinationForeignKeyIfExists('stays');

        $this->restoreLegacyCoordinateColumns('destinations');
        $this->restoreLegacyCoordinateColumns('culinaries');
        $this->restoreLegacyCoordinateColumns('stays');
    }

    private function dropLegacyCoordinateColumns(string $table): void
    {
        $hasSouth = Schema::hasColumn($table, 'latitude_south');
        $hasNorth = Schema::hasColumn($table, 'latitude_north');

        if (! $hasSouth && ! $hasNorth) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($hasSouth, $hasNorth) {
            $columns = [];

            if ($hasSouth) {
                $columns[] = 'latitude_south';
            }

            if ($hasNorth) {
                $columns[] = 'latitude_north';
            }

            $blueprint->dropColumn($columns);
        });
    }

    private function restoreLegacyCoordinateColumns(string $table): void
    {
        $hasSouth = Schema::hasColumn($table, 'latitude_south');
        $hasNorth = Schema::hasColumn($table, 'latitude_north');

        if ($hasSouth && $hasNorth) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($hasSouth, $hasNorth) {
            if (! $hasSouth) {
                $blueprint->decimal('latitude_south', 10, 7)->nullable();
            }

            if (! $hasNorth) {
                $blueprint->decimal('latitude_north', 10, 7)->nullable();
            }
        });
    }

    private function addDestinationForeignKeyIfDataValid(string $table): void
    {
        $orphanCount = DB::table($table)
            ->leftJoin('destinations', 'destinations.id_destinations', '=', $table . '.id_destinations')
            ->whereNull('destinations.id_destinations')
            ->count();

        if ($orphanCount > 0) {
            return;
        }

        try {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreign('id_destinations')
                    ->references('id_destinations')
                    ->on('destinations')
                    ->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
            // Skip when FK already exists or the DB engine cannot alter FK safely.
        }
    }

    private function dropDestinationForeignKeyIfExists(string $table): void
    {
        try {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropForeign(['id_destinations']);
            });
        } catch (\Throwable $e) {
            // Skip when FK does not exist.
        }
    }
};
