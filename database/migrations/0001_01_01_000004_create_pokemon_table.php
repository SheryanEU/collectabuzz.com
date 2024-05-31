<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $status = ['normal','sub legendary','legendary','mythical'];
        $type = ['grass','fire','water','bug','poison','flying','dragon','normal','dark','electric','psychic','steel','ground','ice','fairy','rock','fighting','ghost'];

        Schema::create('pokemon', static function (Blueprint $table) use ($type, $status) {
            $table->id();
            $table->integer('number');
            $table->string('name');
            $table->integer('generation');

            $table->enum('status', $status);
            $table->string('species');

            $table->enum('primary_type', $type);
            $table->enum('secondary_type', $type)->nullable();

            $table->integer('height');
            $table->integer('weight');

            $table->string('primary_ability')->nullable();
            $table->string('secondary_ability')->nullable();
            $table->string('hidden_ability')->nullable();

            $table->integer('health_points');
            $table->integer('attack');
            $table->integer('defence');
            $table->integer('sp_attack');
            $table->integer('sp_defense');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};
