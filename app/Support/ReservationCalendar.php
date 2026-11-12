<?php

namespace App\Support;

use App\Models\Venda;

class ReservationCalendar
{
    public static function googleUrl(Venda $reserva): string
    {
        $reserva->loadMissing('propriedade');
        $nome = $reserva->propriedade?->tipologia ?? $reserva->apartamento;
        $referencia = sprintf('RES-%06d', $reserva->id);
        $detalhe = $reserva->clienteRegistado?->user_id
            ? route('client.reservations.show', $reserva)
            : null;

        $descricao = implode("\n", array_filter([
            'Reserva Olive Properties',
            '',
            'Propriedade: '.$nome,
            'Referência: '.$referencia,
            'Check-in: '.$reserva->data_entrada->format('d/m/Y'),
            'Check-out: '.$reserva->data_saida->format('d/m/Y'),
            'Duração: '.$reserva->data_entrada->diffInDays($reserva->data_saida).' noites',
            '',
            'Consulte os detalhes da sua reserva na sua Área de Cliente.',
            $detalhe,
        ], fn ($linha) => $linha !== null));

        return 'https://calendar.google.com/calendar/render?'.http_build_query([
            'action' => 'TEMPLATE',
            'text' => 'Estadia — Olive Properties | '.$nome,
            // Nos eventos de dia inteiro, o Google Calendar trata a data final como exclusiva.
            'dates' => $reserva->data_entrada->format('Ymd').'/'.$reserva->data_saida->format('Ymd'),
            'location' => $reserva->propriedade?->morada ?? '',
            'details' => $descricao,
        ], '', '&', PHP_QUERY_RFC3986);
    }

    public static function isAvailable(Venda $reserva): bool
    {
        return $reserva->pagamentoSimulado !== null
            && $reserva->data_entrada->isAfter(today());
    }
}
