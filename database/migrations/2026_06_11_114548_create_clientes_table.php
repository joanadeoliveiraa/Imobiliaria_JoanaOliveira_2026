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
        Schema::create('clientes', function (Blueprint $table) {

            // Chave primária
            $table->id();

            // Nome do cliente
            $table->string('nome');

            // Email do cliente
            $table->string('email');

            // Telefone
            $table->string('telefone');

            // Morada
            $table->string('morada');

            // Número de contribuinte
            $table->string('nif');

            // Data de criação e atualização
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
