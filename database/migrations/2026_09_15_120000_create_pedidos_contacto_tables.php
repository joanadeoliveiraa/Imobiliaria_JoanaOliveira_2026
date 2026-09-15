<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120);
            $table->string('email');
            $table->string('telefone', 30)->nullable();
            $table->string('assunto', 160);
            $table->text('mensagem');
            $table->string('estado', 20)->default('new')->index();
            $table->text('notas_internas')->nullable();
            $table->timestamp('lido_em')->nullable();
            $table->timestamp('respondido_em')->nullable();
            $table->timestamps();
        });

        Schema::create('respostas_contacto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_contacto_id')->constrained('pedidos_contacto')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('assunto', 160);
            $table->text('mensagem');
            $table->timestamp('enviado_em');
            $table->timestamps();
        });

        Schema::create('eventos_contacto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_contacto_id')->constrained('pedidos_contacto')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tipo', 30);
            $table->string('descricao', 200);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_contacto');
        Schema::dropIfExists('respostas_contacto');
        Schema::dropIfExists('pedidos_contacto');
    }
};
