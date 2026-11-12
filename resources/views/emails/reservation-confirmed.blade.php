<!DOCTYPE html><html lang="pt-PT"><head><meta charset="utf-8"></head><body style="font-family:Arial,sans-serif;color:#223c30;line-height:1.6;max-width:640px;margin:auto;padding:24px">
<h1 style="font-size:28px">Olive Properties</h1><p>Olá, {{ $reserva->clienteRegistado?->nome ?? $reserva->cliente }},</p><p>A sua reserva na Olive Properties foi confirmada.</p>
<h2>Reserva RES-{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}</h2>
<p><strong>Propriedade:</strong> {{ $reserva->propriedade?->tipologia ?? $reserva->apartamento }} · {{ $reserva->apartamento }}<br>{{ $reserva->propriedade?->morada }}</p>
<p><strong>Check-in:</strong> {{ $reserva->data_entrada->format('d/m/Y') }}<br><strong>Check-out:</strong> {{ $reserva->data_saida->format('d/m/Y') }}<br><strong>Duração:</strong> {{ $reserva->data_entrada->diffInDays($reserva->data_saida) }} noites</p>
<p><strong>Método simulado:</strong> {{ \App\Http\Controllers\ReservaCheckoutController::METHODS[$reserva->pagamentoSimulado->metodo] ?? $reserva->pagamentoSimulado->metodo }}<br><strong>Valor:</strong> {{ number_format((float) $reserva->valor_total, 2, ',', '.') }} €</p>
<p>Esta operação utiliza o sistema demonstrativo da plataforma e não corresponde a uma cobrança bancária real.</p>
@if($reserva->clienteRegistado?->user_id)<p><a href="{{ route('client.reservations.show', $reserva) }}" style="display:inline-block;padding:12px 20px;background:#334f3b;color:#fff;text-decoration:none">Consultar reserva</a></p>@endif
@if(\App\Support\ReservationCalendar::isAvailable($reserva))<p><a href="{{ \App\Support\ReservationCalendar::googleUrl($reserva) }}" style="display:inline-block;padding:12px 20px;border:1px solid #334f3b;color:#334f3b;text-decoration:none">Adicionar ao Google Calendar</a></p>@endif
<p>Olive Properties<br>Rua das Oliveiras, 25<br>8200-000 Albufeira<br>Portugal<br>+351 289 000 000<br>info@oliveproperties.pt</p>
</body></html>
