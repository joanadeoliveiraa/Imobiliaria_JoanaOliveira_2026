<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

class ReservationPricing
{
    public static function quote(string $weeklyPrice, string $arrival, string $departure): array
    {
        $nights = (int) CarbonImmutable::parse($arrival)->diffInDays(CarbonImmutable::parse($departure));
        if ($nights < 1) {
            throw ValidationException::withMessages(['data_saida' => 'A saída deve ser posterior à entrada.']);
        }
        $cents = (int) round((float) $weeklyPrice * 100);
        $total = (int) round($cents * $nights / 7);
        if ($total > 9999999999) {
            throw ValidationException::withMessages(['data_saida' => 'O valor da estadia ultrapassa o limite permitido.']);
        }

        return ['noites' => $nights, 'preco_semanal' => $weeklyPrice, 'total' => number_format($total / 100, 2, '.', '')];
    }
}
