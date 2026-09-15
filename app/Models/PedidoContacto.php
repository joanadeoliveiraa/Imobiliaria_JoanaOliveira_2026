<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoContacto extends Model
{
    protected $table = 'pedidos_contacto';

    public const ESTADOS = [
        'new' => 'Novo', 'in_progress' => 'Em análise', 'replied' => 'Respondido',
        'completed' => 'Concluído', 'archived' => 'Arquivado',
    ];

    protected $fillable = ['nome', 'email', 'telefone', 'assunto', 'mensagem', 'estado', 'notas_internas', 'lido_em', 'respondido_em'];

    protected function casts(): array
    {
        return ['lido_em' => 'datetime', 'respondido_em' => 'datetime'];
    }

    public function respostas(): HasMany
    {
        return $this->hasMany(RespostaContacto::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(EventoContacto::class);
    }

    public function getEstadoTextoAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? 'Desconhecido';
    }
}
