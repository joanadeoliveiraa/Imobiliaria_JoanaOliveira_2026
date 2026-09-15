@extends('layouts.admin')
@section('title', 'Confirmação da reserva — Olive Properties')
@section('admin_content')
<div class="booking-confirmation">
    <header class="admin-page-heading no-print"><div><p class="eyebrow">Pagamento simulado aprovado</p><h1>Reserva confirmada</h1><p>A reserva #{{ $venda->id }} foi registada. Pode imprimir os detalhes abaixo.</p></div></header>
    @include('Vendas._steps', ['step' => 3])
    <article class="booking-receipt">
        <x-document-header :title="'Confirmação de reserva #'.$venda->id" :reference="sprintf('RES-%06d', $venda->id)" :print-only="false" />
        <p class="receipt-footnote">Registada em {{ $payment->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }} (Lisboa) por {{ $details['criado_por'] ?? $payment->creator?->name ?? 'Administrador não identificado' }}.</p>
        <p class="simulation-notice"><strong>SEM COBRANÇA REAL.</strong> O pagamento foi simulado; este documento confirma apenas a reserva registada e não tem valor fiscal.</p>
        <div class="receipt-grid">
            <section><h3>Cliente</h3><dl class="booking-details">
                <div><dt>Nome</dt><dd>{{ $details['cliente']['nome'] }}</dd></div>
                <div><dt>Email</dt><dd>{{ $details['cliente']['email'] }}</dd></div>
                <div><dt>Telefone</dt><dd>{{ $details['cliente']['telefone'] }}</dd></div>
            </dl></section>
            <section><h3>Propriedade</h3><dl class="booking-details">
                <div><dt>Referência</dt><dd>{{ $details['apartamento']['referencia'] }}</dd></div>
                <div><dt>Localização</dt><dd>{{ $details['apartamento']['morada'] }}</dd></div>
                <div><dt>Tipologia / área</dt><dd>{{ $details['apartamento']['tipologia'] }} · {{ $details['apartamento']['area'] }} m²</dd></div>
            </dl></section>
            <section><h3>Estadia</h3><dl class="booking-details">
                <div><dt>Entrada</dt><dd>{{ \Carbon\Carbon::parse($details['data_entrada'])->format('d/m/Y') }}</dd></div>
                <div><dt>Saída</dt><dd>{{ \Carbon\Carbon::parse($details['data_saida'])->format('d/m/Y') }}</dd></div>
                <div><dt>Duração</dt><dd>{{ $details['quote']['noites'] }} noites</dd></div>
            </dl></section>
        </div>
        <div class="booking-total"><span>Valor da reserva</span><strong>{{ number_format((float) $details['quote']['total'], 2, ',', '.') }} €</strong></div>
    </article>
    <div class="form-actions no-print">
        <button type="button" class="button button--primary" onclick="window.print()">Imprimir / Guardar PDF</button>
        <a class="button button--outline" href="{{ route('vendas.show', $venda) }}">Ver reserva atual</a>
        <a class="button button--outline" href="{{ route('vendas.create') }}">Nova reserva</a>
        <a class="button button--ghost" href="{{ route('vendas.index') }}">Lista de reservas</a>
    </div>
</div>
@endsection
