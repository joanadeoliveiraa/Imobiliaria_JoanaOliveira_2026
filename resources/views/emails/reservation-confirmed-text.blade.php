Olá, {{ $reserva->clienteRegistado?->nome ?? $reserva->cliente }},

A sua reserva na Olive Properties foi confirmada.
Referência: RES-{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}
Propriedade: {{ $reserva->propriedade?->tipologia ?? $reserva->apartamento }} · {{ $reserva->apartamento }}
Localização: {{ $reserva->propriedade?->morada }}
Check-in: {{ $reserva->data_entrada->format('d/m/Y') }}
Check-out: {{ $reserva->data_saida->format('d/m/Y') }}
Duração: {{ $reserva->data_entrada->diffInDays($reserva->data_saida) }} noites
Método simulado: {{ \App\Http\Controllers\ReservaCheckoutController::METHODS[$reserva->pagamentoSimulado->metodo] ?? $reserva->pagamentoSimulado->metodo }}
Valor: {{ number_format((float) $reserva->valor_total, 2, ',', '.') }} €

Esta operação utiliza o sistema demonstrativo da plataforma e não corresponde a uma cobrança bancária real.
@if($reserva->clienteRegistado?->user_id)
Consultar reserva: {{ route('client.reservations.show', $reserva) }}
@endif
Olive Properties
Rua das Oliveiras, 25
8200-000 Albufeira
Portugal
+351 289 000 000
info@oliveproperties.pt
