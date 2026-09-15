@extends('layouts.admin')
@section('title', 'Nova reserva — Olive Properties')
@section('admin_content')
<header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Nova reserva</h1><p>Escolha o cliente, a propriedade e as datas da estadia.</p></div></header>
@include('Vendas._steps', ['step' => 1])
<div class="simulation-notice"><strong>Reserva com pagamento simulado.</strong> No passo seguinte poderá testar um pagamento, sem cobrança real. A reserva só será criada após uma simulação aprovada.</div>
@include('layouts.management-feedback')
@if($apartamentos->isEmpty())
    <div class="alert alert--danger">Não existem propriedades disponíveis para reservar. <a href="{{ route('admin.apartamentos.index') }}">Consultar propriedades</a></div>
@endif
<form class="checkout-panel booking-form" method="POST" action="{{ route('vendas.store') }}" data-reservation-form>
    @csrf
    <div class="form-grid">
        <div class="field form-grid__full">
            <label for="cliente_pesquisa">Pesquisar cliente</label>
            <input id="cliente_pesquisa" type="search" placeholder="Nome, telefone ou NIF" autocomplete="off" aria-controls="cliente_lista" aria-describedby="cliente_resultados">
            <p id="cliente_resultados" class="field-help" role="status" aria-live="polite">Pesquise e selecione o cliente na lista abaixo.</p>
            <p class="booking-client-label" data-client-list-label hidden>Reservar em nome de *</p>
            <ul id="cliente_lista" class="booking-client-list" aria-label="Clientes encontrados" hidden></ul>
            <p id="cliente_escolhido" class="booking-client-selected" hidden></p>
            <label for="cliente_id" data-client-select-label>Reservar em nome de *</label>
            <select id="cliente_id" name="cliente_id" required>
                <option value="">Selecione um cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" data-name="{{ $cliente->nome }}" data-phone="{{ $cliente->telefone }}" data-nif="{{ $cliente->nif }}" @selected((string) old('cliente_id', $draft['cliente_id'] ?? ($clienteSelecionado === $cliente->nome ? $cliente->id : '')) === (string) $cliente->id)>{{ $cliente->nome }} · {{ $cliente->telefone }} · NIF {{ $cliente->nif }} · {{ $cliente->email }}</option>
                @endforeach
            </select>
            <a class="booking-add-client" href="{{ route('clientes.create', ['origem' => 'reserva']) }}">+ Criar novo cliente</a>
        </div>
        <div class="field form-grid__full">
            <label for="apartamento_id">Propriedade *</label>
            <select id="apartamento_id" name="apartamento_id" required>
                <option value="">Selecione uma propriedade disponível</option>
                @foreach($apartamentos as $apartamento)
                    <option value="{{ $apartamento->id }}" data-preco="{{ $apartamento->preco }}" @selected((string) old('apartamento_id', $draft['apartamento_id'] ?? $apartamentoSelecionado) === (string) $apartamento->id)>{{ $apartamento->referencia }} · {{ $apartamento->morada }} · {{ number_format((float) $apartamento->preco, 2, ',', '.') }} €/semana</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="data_entrada">Data de entrada *</label>
            <input id="data_entrada" type="date" name="data_entrada" min="{{ now()->toDateString() }}" value="{{ old('data_entrada', $draft['data_entrada'] ?? '') }}" required>
        </div>
        <div class="field">
            <label for="data_saida">Data de saída *</label>
            <input id="data_saida" type="date" name="data_saida" value="{{ old('data_saida', $draft['data_saida'] ?? '') }}" required>
        </div>
    </div>
    <div class="booking-estimate" aria-live="polite"><span id="reservation-nights">Escolha a propriedade e as datas para ver a estimativa.</span><strong id="reservation-estimate">—</strong></div>
    <p class="field-help">Preço proporcional: preço semanal × número de noites ÷ 7. O total será confirmado no próximo passo. * Campos obrigatórios.</p>
    <div class="form-actions">
        <button type="submit" class="button button--primary" @disabled($apartamentos->isEmpty() || $clientes->isEmpty())>Continuar para pagamento</button>
        <a class="button button--outline" href="{{ route('vendas.index') }}">Cancelar</a>
    </div>
</form>
@endsection
