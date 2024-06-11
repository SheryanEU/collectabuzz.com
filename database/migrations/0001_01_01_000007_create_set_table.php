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
        Schema::create('set', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('serie_id');

            $table->string('set_id');
            $table->string('name');
            $table->string('slug');
            $table->string('set_code')->nullable();
            $table->string('set_number');
            $table->string('set_total');
            $table->string('set_master_total')->nullable();
            $table->string('logo_src')->nullable();
            $table->string('symbol_src')->nullable();
            $table->date('release_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('serie_id')->references('id')->on('serie')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set');
    }
};
