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
        Schema::create('attack_type', function (Blueprint $table) {
            $table->foreignId('attack_id')->constrained('attack')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('type')->onDelete('cascade');
            $table->integer('cost');

            $table->primary(['attack_id', 'type_id']);

            $table->index('attack_id');
            $table->index('type_id');
            $table->index('cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attack_type');
    }
};
