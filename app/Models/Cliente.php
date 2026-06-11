<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    // Campos que podem ser preenchidos através de formulários
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'morada',
        'nif'
    ];
}