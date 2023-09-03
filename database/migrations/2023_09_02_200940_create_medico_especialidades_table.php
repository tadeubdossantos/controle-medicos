<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicos_especialidades', function (Blueprint $table) {
            $table->foreignId('medico_id');
            $table->foreignId('especialidade_id');
            $table->timestamps();

            // Criação de um índice único composto
            $table->unique(['medico_id', 'especialidade_id']);

            // Definição das chaves estrangeiras
            $table
                ->foreign('medico_id')
                ->references('id')
                ->on('medicos');
            $table
                ->foreign('especialidade_id')
                ->references('id')
                ->on('especialidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicos_especialidades');
    }
};
