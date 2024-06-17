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
        Schema::create('card_weakness', function (Blueprint $table) {
            $table->foreignId('card_id')->constrained('card')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('type')->onDelete('cascade');
            $table->integer('value');

            $table->primary(['card_id', 'type_id']);

            $table->index('card_id');
            $table->index('type_id');
            $table->index('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_weakness');
    }
};
