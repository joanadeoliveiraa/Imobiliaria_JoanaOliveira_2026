@extends('layouts.admin')
@section('title', 'Resumo da reserva — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Resumo da reserva</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container py-5" >
        <div class="cabecalho-relatorio apenas-impressao mb-5">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('images/folhas_brancas.png') }}"
                        alt="Olive Properties"
                        width="185">
                </div>

                <div class="col-md-9">
                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>
                    <p class="mb-0">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="titulo-principal mb-0">
                    Reserva Confirmada
                </h3>
                <small class="text-muted">
                    Documento emitido em {{ date('d/m/Y H:i') }}
                </small>
            </div>
            <div class="no-print">
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    Relatório PDF
                </button>
            </div>
        </div>

        <div class="row mb-4">

            <div class="col-md-6">

                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <strong>Cliente</strong>
                    </div>
                    <div class="card-body">

                        <p class="mb-2">
                            <strong>Nome:</strong>
                            {{ $venda->cliente }}
                        </p>
                        <p class="mb-0">
                            <strong>Apartamento:</strong>
                            {{ $venda->apartamento }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <strong>Reserva</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Entrada:</strong>
                            {{ date('d/m/Y', strtotime($venda->data_entrada)) }}
                        </p>
                        <p class="mb-2">
                            <strong>Saída:</strong>
                            {{ date('d/m/Y', strtotime($venda->data_saida)) }}
                        </p>
                        <p class="mb-0">
                            <strong>Valor:</strong>
                            <span class="badge bg-success fs-6">
                                {{ number_format($venda->valor_total, 2, ',', '.') }} €
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>Informação do Apartamento</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Referência</strong>
                        <p>{{ $apartamento->referencia }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Tipologia</strong>
                        <p>{{ $apartamento->tipologia }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Área</strong>
                        <p>{{ $apartamento->area }} m²</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Morada</strong>
                        <p>{{ $apartamento->morada }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-muted mt-5 apenas-impressao">
            <hr>
            <p class="mb-1">
                Obrigado por escolher a Olive Properties.
            </p>
            <small>
                Documento gerado automaticamente pelo sistema.
            </small>
        </div>

        <div class="text-center mt-4 no-print">
            <a href="{{ route('vendas.create') }}" class="btn btn-dark">
                Nova Reserva
            </a>

            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                Menu Principal
            </a>

            <a href="{{ route('clientes.reservas', $venda->cliente) }}"              class="btn btn-outline-primary">
                Histórico do Cliente
            </a>
        </div>
    </div>

</div>
@endsection
