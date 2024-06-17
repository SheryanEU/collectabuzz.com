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
        Schema::create('card', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('set_id');

            $table->string('card_id');

            $table->unsignedBigInteger('pokemon_id');

            $table->string('variant');
            $table->string('supertype');
            $table->string('hp')->nullable();

            $table->string('rarity')->nullable();
            $table->string('artist')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('set_id')->references('id')->on('set')->onDelete('cascade');
            $table->foreign('pokemon_id')->references('id')->on('pokemon')->onDelete('cascade');

            $table->unique(['card_id', 'variant', 'set_id']);

            $table->index('set_id');
            $table->index('pokemon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card');
    }
};
