<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->index(['apartamento', 'data_entrada', 'data_saida'], 'vendas_estadia_index');
            $table->index(['cliente', 'apartamento', 'data_entrada', 'data_saida', 'valor_total'], 'vendas_duplicados_index');
            $table->index('data_entrada');
        });
        Schema::table('apartamentos', fn (Blueprint $table) => $table->index('referencia'));
        Schema::table('clientes', fn (Blueprint $table) => $table->index('nome'));
    }

    public function down(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropIndex('vendas_estadia_index');
            $table->dropIndex('vendas_duplicados_index');
            $table->dropIndex(['data_entrada']);
        });
        Schema::table('apartamentos', fn (Blueprint $table) => $table->dropIndex(['referencia']));
        Schema::table('clientes', fn (Blueprint $table) => $table->dropIndex(['nome']));
    }
};
