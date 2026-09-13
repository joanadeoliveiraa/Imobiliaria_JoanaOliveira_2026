@extends('layouts.admin')
@section('title', 'Pagamento simulado — Olive Properties')
@section('admin_content')
<header class="admin-page-heading"><div><p class="eyebrow">Nova reserva</p><h1>Pagamento simulado</h1><p>Reveja a estadia e conclua a demonstração.</p></div></header>
@include('Vendas._steps', ['step' => 2])
<div class="simulation-notice"><strong>Apenas simulação.</strong> Não existe qualquer cobrança nem são solicitados dados bancários reais. A propriedade só fica reservada depois de aprovar esta simulação.</div>
@include('layouts.management-feedback')
<div class="checkout-grid">
    <section class="checkout-panel">
        <h2>Resumo da estadia</h2>
        <dl class="booking-details">
            <div><dt>Cliente</dt><dd>{{ $cliente->nome }}<small>{{ $cliente->email }}</small></dd></div>
            <div><dt>Propriedade</dt><dd>{{ $apartamento->referencia }} · {{ $apartamento->tipologia }}<small>{{ $apartamento->morada }}</small></dd></div>
            <div><dt>Entrada</dt><dd>{{ \Carbon\Carbon::parse($draft['data_entrada'])->format('d/m/Y') }}</dd></div>
            <div><dt>Saída</dt><dd>{{ \Carbon\Carbon::parse($draft['data_saida'])->format('d/m/Y') }}</dd></div>
            <div><dt>Duração</dt><dd>{{ $draft['quote']['noites'] }} noites</dd></div>
            <div><dt>Preço semanal</dt><dd>{{ number_format((float) $draft['quote']['preco_semanal'], 2, ',', '.') }} €</dd></div>
        </dl>
        <div class="booking-total"><span>Total da simulação</span><strong>{{ number_format((float) $draft['quote']['total'], 2, ',', '.') }} €</strong></div>
        <p class="field-help">Preço semanal × noites ÷ 7, arredondado a cêntimos. Esta proposta é válida por 30 minutos desde a sua criação, sujeita a nova verificação de disponibilidade.</p>
    </section>
    <form class="checkout-panel" action="{{ route('vendas.pagar', $token) }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf
        <fieldset class="payment-methods">
            <legend>Método de demonstração</legend>
            @foreach($methods as $value => $label)
                <label><input type="radio" name="metodo" value="{{ $value }}" @checked(old('metodo', 'cartao') === $value) required><span>{{ $label }}</span></label>
            @endforeach
        </fieldset>
        <p class="field-help">Cartão fictício terminado em 4242. MB WAY e transferência não enviam pedidos nem movimentam dinheiro.</p>
        <div class="field payment-outcome">
            <label for="resultado">Resultado a simular</label>
            <select id="resultado" name="resultado" required>
                <option value="aprovado" @selected(old('resultado', 'aprovado') === 'aprovado')>Pagamento aprovado</option>
                <option value="recusado" @selected(old('resultado') === 'recusado')>Pagamento recusado — testar nova tentativa</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="button button--primary" :disabled="submitting" x-text="submitting ? 'A processar simulação…' : 'Simular pagamento'">Simular pagamento</button>
            <a class="button button--outline" href="{{ route('vendas.create', ['rascunho' => $token]) }}">Voltar e editar</a>
            <a class="button button--ghost" href="{{ route('vendas.index') }}">Sair da simulação</a>
        </div>
    </form>
</div>
@endsection
