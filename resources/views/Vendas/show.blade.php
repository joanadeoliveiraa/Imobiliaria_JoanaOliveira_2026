@extends('layouts.admin')
@section('title', 'Detalhes da reserva — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Detalhes da reserva</h1></div></header>
    @include('layouts.management-feedback')

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-4">
                Reserva #{{ $venda->id }}
            </h5>
            <p>
                <strong>Cliente:</strong>
                {{ $venda->cliente }}
            </p>

            <hr>

            <p>
                <strong>Referência:</strong>
                {{ $apartamento->referencia }}
            </p>

            <p>
                <strong>Tipologia:</strong>
                {{ $apartamento->tipologia }}
            </p>

            <p>
                <strong>Morada:</strong>
                {{ $apartamento->morada }}
            </p>

            <p>
                <strong>Área:</strong>
                {{ $apartamento->area }} m²
            </p>

            <p>
                <strong>Preço por Semana:</strong>
                {{ $apartamento->preco }} €
            </p>

            <hr>
            <p>
                <strong>Data de Entrada:</strong>
                {{ $venda->data_entrada }}
            </p>
            <p>
                <strong>Data de Saída:</strong>
                {{ $venda->data_saida }}
            </p>
            <p>
                <strong>Valor Total:</strong>
                {{ $venda->valor_total }} €
            </p>

            <hr>

            @if($venda->pagamentoSimulado)
                <h2>Pagamento simulado</h2>
                <p><strong>Estado:</strong> Aprovado (simulação)</p>
                <p><strong>Método:</strong> {{ \App\Http\Controllers\ReservaCheckoutController::METHODS[$venda->pagamentoSimulado->metodo] ?? $venda->pagamentoSimulado->metodo }}</p>
                <p><strong>Valor:</strong> {{ number_format((float) $venda->valor_total, 2, ',', '.') }} €</p>
                <p><strong>Data:</strong> {{ $venda->pagamentoSimulado->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</p>
                <p><strong>Referência interna:</strong> {{ $venda->pagamentoSimulado->token }}</p>
                <p><strong>Confirmação por email:</strong> {{ match($venda->pagamentoSimulado->email_estado) { 'sent' => 'Enviada', 'failed' => 'Falhou', default => 'Não enviada' } }}</p>
                <p class="simulation-notice">Este pagamento é exclusivamente demonstrativo e não corresponde a cobrança real.</p>
                <a class="button button--outline" href="{{ route('vendas.confirmacao', $venda) }}">Ver / imprimir comprovativo</a>
                <hr>
            @endif
            <div class="d-flex gap-2">
                @if($venda->pagamentoSimulado)
                    <a class="btn btn-outline-dark" href="{{ route('vendas.confirmacao', $venda) }}">Confirmação / Imprimir</a>
                @endif
                <a href="{{ route('vendas.edit', $venda->id) }}"
                    class="btn btn-olive">
                    Editar Reserva
                </a>
                <a href="{{ route('clientes.reservas', $venda->cliente) }}"
                    class="btn btn-outline-secondary">
                    Histórico do Cliente
                </a>
                <a href="{{ route('vendas.index') }}"
                    class="btn btn-outline-dark">
                    Voltar
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
