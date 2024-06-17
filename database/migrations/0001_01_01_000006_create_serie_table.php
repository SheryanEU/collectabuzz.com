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
        Schema::create('serie', function (Blueprint $table) {
            $table->id();
            $table->string('serie_id')->unique();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('hexadecimalcolor', 7)->nullable();
            $table->string('logo_src')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serie');
    }
};
