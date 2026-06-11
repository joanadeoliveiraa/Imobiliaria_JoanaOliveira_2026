<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    protected $fillable = [
        'referencia',
        'tipologia',
        'morada',
        'area',
        'preco',
        'fotografia',
        'estado'
    ];
}