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
        Schema::create('card_subtype', function (Blueprint $table) {
            $table->foreignId('card_id')->constrained('card')->onDelete('cascade');
            $table->foreignId('subtype_id')->constrained('subtype')->onDelete('cascade');

            $table->index('card_id');
            $table->index('subtype_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_subtype');
    }
};
