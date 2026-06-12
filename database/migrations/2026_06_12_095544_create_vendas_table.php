<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('vendas', function (Blueprint $table) {
        $table->id();
        $table->string('cliente'); //nome do cliente
        $table->string('apartamento'); //ref do apartamento
        $table->date('data_entrada');  
        $table->date('data_saida');
        $table->decimal('valor_total', 10, 2); // valor da reserva
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
