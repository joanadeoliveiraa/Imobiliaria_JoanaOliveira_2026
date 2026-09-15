<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartamento extends Model
{
    public function reservas(): HasMany
    {
        return $this->hasMany(Venda::class, 'apartamento', 'referencia');
    }

    public function scopeComEstadoAtual(Builder $query, string $day): Builder
    {
        return $query->withCount(['reservas as reservas_atuais' => fn ($q) => $q->emCurso($day)])
            ->withMax(['reservas as ocupado_ate' => fn ($q) => $q->emCurso($day)], 'data_saida')
            ->withMin(['reservas as proxima_entrada' => fn ($q) => $q->futuras($day)], 'data_entrada');
    }

    public function getEstadoAtualAttribute(): string
    {
        if ($this->reservas_atuais > 0) {
            return 'Ocupada';
        }
        if ($this->estado !== self::ESTADO_DISPONIVEL) {
            return 'Indisponível';
        }
        return $this->proxima_entrada ? 'Próxima entrada' : 'Disponível';
    }

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
