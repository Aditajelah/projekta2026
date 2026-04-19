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
        Schema::create('culinaries', function (Blueprint $table) {
            $table->id('id_culinaries');
            $table->unsignedBigInteger('id_destinations');
          # $table->foreign('id_destinations')->references('id_destinations')->on('destinations')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->decimal('price', 10, 2); // contoh: Rp 25.000,00
            $table->decimal('rating', 3, 2);
            $table->string('cuisine_type');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->enum('hiddengem', ['hiddengem', 'bukanhiddengem'])->default('bukanhiddengem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culinaries');
    }
};
