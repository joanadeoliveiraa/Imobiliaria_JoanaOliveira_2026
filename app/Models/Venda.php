<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
    'cliente',
    'apartamento',
    'data_entrada',
    'data_saida',
    'valor_total'];
}
