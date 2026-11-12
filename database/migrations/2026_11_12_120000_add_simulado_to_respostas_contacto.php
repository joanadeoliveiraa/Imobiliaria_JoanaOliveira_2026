<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('respostas_contacto', function (Blueprint $table) {
            $table->boolean('simulado')->default(false)->after('mensagem');
        });
    }

    public function down(): void
    {
        Schema::table('respostas_contacto', function (Blueprint $table) {
            $table->dropColumn('simulado');
        });
    }
};
