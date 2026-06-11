<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('apartamentos', function (Blueprint $table) {

        $table->id(); // ID
        $table->string('referencia'); // Referência do apartamento
        $table->string('tipologia'); // T0, T1, T2, T3...
        $table->string('morada'); // Morada
        $table->decimal('area', 8, 2); // Área em m²
        $table->decimal('preco', 10, 2); // Preço
        $table->string('fotografia')->nullable(); // Fotografia
        $table->string('estado')->default('Disponivel'); // Disponível ou Vendido. Quando o apartamento é criado fica disponível automaticamente
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartamentos');
    }
};
