<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagamentoSimulado extends Model
{
    public function venda(): BelongsTo
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $table = 'pagamentos_simulados';

    protected $fillable = ['venda_id', 'user_id', 'token', 'metodo', 'detalhes', 'email_estado', 'email_enviado_em'];

    protected function casts(): array
    {
        return ['detalhes' => 'array', 'email_enviado_em' => 'datetime'];
    }
}
