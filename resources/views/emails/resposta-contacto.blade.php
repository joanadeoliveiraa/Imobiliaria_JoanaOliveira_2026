<!doctype html>
<html lang="pt-PT"><head><meta charset="utf-8"></head><body style="font-family:Arial,sans-serif;color:#22352c;line-height:1.6">
    <h1 style="font-size:20px">Olive Properties</h1>
    <p>Olá {{ $pedido->nome }},</p>
    <p>Assunto do pedido: {{ $pedido->assunto }}</p>
    @if($pedido->venda_id)<p>Reserva: RES-{{ str_pad($pedido->venda_id, 6, '0', STR_PAD_LEFT) }}</p>@endif
    <p style="white-space:pre-line">{{ $texto }}</p>
    <p>Com os melhores cumprimentos,<br>Equipa Olive Properties</p>
</body></html>
