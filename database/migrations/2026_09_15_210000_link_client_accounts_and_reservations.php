<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefone')->nullable()->change();
            $table->string('morada')->nullable()->change();
            $table->string('nif')->nullable()->change();
        });
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
        });
        Schema::table('vendas', function (Blueprint $table) {
            $table->foreignId('cliente_id')->nullable()->index()->constrained('clientes')->nullOnDelete();
        });
        Schema::table('pedidos_contacto', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->index()->constrained()->nullOnDelete();
        });
        Schema::table('pagamentos_simulados', function (Blueprint $table) {
            $table->string('email_estado', 20)->default('not_sent');
            $table->timestamp('email_enviado_em')->nullable();
        });
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        DB::table('vendas')->orderBy('id')->chunkById(100, function ($vendas) {
            foreach ($vendas as $venda) {
                $ids = DB::table('clientes')->where('nome', $venda->cliente)->limit(2)->pluck('id');
                if ($ids->count() === 1) {
                    DB::table('vendas')->where('id', $venda->id)->update(['cliente_id' => $ids[0]]);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::table('pagamentos_simulados', fn (Blueprint $table) => $table->dropColumn(['email_estado', 'email_enviado_em']));
        Schema::table('pedidos_contacto', fn (Blueprint $table) => $table->dropConstrainedForeignId('user_id'));
        Schema::table('vendas', fn (Blueprint $table) => $table->dropConstrainedForeignId('cliente_id'));
        Schema::table('clientes', fn (Blueprint $table) => $table->dropConstrainedForeignId('user_id'));
    }
};
