<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoContacto extends Model
{
    protected $table = 'eventos_contacto';

    protected $fillable = ['pedido_contacto_id', 'user_id', 'tipo', 'descricao'];
}
