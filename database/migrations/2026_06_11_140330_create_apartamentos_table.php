<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartamentos', function (Blueprint $table) {

            $table->id();
            $table->string('referencia');
            $table->string('tipologia');
            $table->string('morada');
            $table->decimal('area', 8, 2);
            $table->decimal('preco', 10, 2);
            $table->string('fotografia')->nullable();
            $table->string('estado')->default('Disponivel');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartamentos');
    }
};
