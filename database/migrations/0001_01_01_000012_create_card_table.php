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
            $table->foreignId('set_id')->constrained()->onDelete('cascade');
            $table->string('card_id');
            $table->string('variant');
            $table->foreignId('pokemon_id')->nullable()->constrained();
            $table->string('name');
            $table->string('supertype');
            $table->string('subtype');
            $table->string('hp')->nullable();
            $table->string('rarity');
            $table->string('artist')->nullable();
            $table->text('flavor_text')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['card_id', 'variant']);
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
