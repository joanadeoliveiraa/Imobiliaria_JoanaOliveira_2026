<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos_contacto', function (Blueprint $table) {
            $table->foreignId('venda_id')->nullable()->constrained('vendas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pedidos_contacto', fn (Blueprint $table) => $table->dropConstrainedForeignId('venda_id'));
    }
};
