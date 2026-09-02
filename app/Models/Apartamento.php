<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    public const ESTADO_DISPONIVEL = 'Disponivel';

    public const ESTADO_INDISPONIVEL = 'Nao Disponivel';

    protected $fillable = [
        'referencia',
        'tipologia',
        'morada',
        'area',
        'preco',
        'fotografia',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'area' => 'decimal:2',
            'preco' => 'decimal:2',
        ];
    }
}
