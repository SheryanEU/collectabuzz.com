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
        Schema::create('attack', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('cost')->nullable();
            $table->integer('converted_energy_cost')->nullable();
            $table->string('damage')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attack');
    }
};
