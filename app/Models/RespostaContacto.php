<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespostaContacto extends Model
{
    protected $table = 'respostas_contacto';

    protected $fillable = ['pedido_contacto_id', 'user_id', 'assunto', 'mensagem', 'enviado_em'];

    protected function casts(): array
    {
        return ['enviado_em' => 'datetime'];
    }

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
