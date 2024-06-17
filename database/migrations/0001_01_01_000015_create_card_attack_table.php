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
        Schema::create('card_attack', function (Blueprint $table) {
            $table->foreignId('card_id')->constrained('card')->onDelete('cascade');
            $table->foreignId('attack_id')->constrained('attack')->onDelete('cascade');
            $table->json('cost')->nullable();

            $table->index('card_id');
            $table->index('attack_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_attack');
    }
};
