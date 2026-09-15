<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Venda extends Model
{
    public function propriedade(): BelongsTo
    {
        return $this->belongsTo(Apartamento::class, 'apartamento', 'referencia');
    }

    // Cancelamentos são eliminados; rascunhos de pagamento não entram nesta tabela.
    public function scopeValidas(Builder $query): Builder
    {
        return $query->whereColumn('vendas.data_saida', '>', 'vendas.data_entrada')
            ->where('vendas.valor_total', '>=', 0)
            ->whereHas('propriedade')
            ->whereExists(fn ($q) => $q->selectRaw('1')->from('clientes')
                ->whereColumn('clientes.nome', 'vendas.cliente'));
    }

    public function scopeSemDuplicados(Builder $query): Builder
    {
        return $query->whereNotExists(function ($q) {
            $q->selectRaw('1')->from('vendas as anterior')->whereColumn('anterior.id', '<', 'vendas.id');
            foreach (['cliente', 'apartamento', 'data_entrada', 'data_saida', 'valor_total'] as $column) {
                $q->whereColumn('anterior.'.$column, 'vendas.'.$column);
            }
        });
    }

    public function scopeDeGestao(Builder $query): Builder
    {
        return $query->validas()->semDuplicados();
    }

    public function scopeEmCurso(Builder $query, string $day): Builder
    {
        return $query->deGestao()->where('data_entrada', '<=', $day)->where('data_saida', '>', $day);
    }

    public function scopeFuturas(Builder $query, string $day): Builder
    {
        return $query->deGestao()->where('data_entrada', '>', $day);
    }

    public function scopeReceitaEntre(Builder $query, string $start, string $end): Builder
    {
        return $query->deGestao()->whereBetween('data_entrada', [$start, $end]);
    }

    public function scopeSobrepostas(Builder $query, string $arrival, string $departure): Builder
    {
        return $query->validas()->where('data_entrada', '<', $departure)->where('data_saida', '>', $arrival);
    }

    public function estadoNaData(string $day): string
    {
        if ($this->data_saida <= $this->data_entrada || $this->valor_total < 0) {
            return 'Rever dados';
        }
        if ($this->data_entrada->toDateString() > $day) {
            return 'Confirmada';
        }
        return $this->data_saida->toDateString() > $day ? 'Em curso' : 'Concluída';
    }

    public function pagamentoSimulado(): HasOne
    {
        return $this->hasOne(PagamentoSimulado::class);
    }

    protected $fillable = [
        'cliente',
        'apartamento',
        'data_entrada',
        'data_saida',
        'valor_total'];

    protected function casts(): array
    {
        return [
            'data_entrada' => 'date',
            'data_saida' => 'date',
            'valor_total' => 'decimal:2',
        ];
    }
}
