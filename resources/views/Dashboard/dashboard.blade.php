@extends('layouts.admin')
@section('title', 'Dashboard — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Dashboard</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container py-4" >

        <div class="mb-3">
            <small class="text-muted">
                Último acesso: {{ $ultimoAcesso }}
            </small>
        </div>

        <div class="d-flex justify-content-end mb-4 no-print">
            <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                Relatório PDF
            </button>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                ← Menu Principal
            </a>
        </div>

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">
                    Receita Total da Empresa
                </h6>
                <h1 class="titulo-principal">
                    {{ number_format($receitaTotal, 2, ',', '.') }} €
                </h1>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <a href="{{ route('admin.apartamentos.index', ['estado' => 'Disponivel']) }}" class="text-decoration-none">
                    <div class="card card-dashboard">
                        <div class="card-body text-center">
                            <div class="titulo-card">
                                Apartamentos Disponíveis
                            </div>
                            <div class="numero">
                                {{ $disponiveis }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.apartamentos.index', ['estado' => 'Nao Disponivel']) }}" class="text-decoration-none">
                    <div class="card card-dashboard">
                        <div class="card-body text-center">
                            <div class="titulo-card">
                                Apartamentos Ocupados
                            </div>
                            <div class="numero">
                                {{ $naoDisponiveis }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <div class="card card-dashboard">
                    <div class="card-body text-center">
                        <div class="titulo-card">
                            Clientes Registados
                        </div>
                        <div class="numero">
                            {{ $clientes }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-dashboard">
                    <div class="card-body text-center">
                        <div class="titulo-card">
                            Reservas Totais
                        </div>
                        <div class="numero">
                            {{ $reservas }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body text-center">
                        <div class="titulo-card">
                            Cliente Mais Frequente
                        </div>
                        <div class="numero numero--text">
                            {{ $clienteTop->cliente ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body text-center">
                        <div class="titulo-card">
                            Apartamento Mais Reservado
                        </div>
                        <div class="numero numero--text">
                            {{ $apartamentoTop->apartamento ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body text-center">
                        <div class="titulo-card">
                            Próxima Reserva
                        </div>
                        <div class="numero numero--text">
                            @if($proximaReserva)
                            {{ date('d/m/Y', strtotime($proximaReserva->data_entrada)) }}
                            @else
                            -
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header">
                   <strong> Ocupação dos Apartamentos </strong>
                </div>
                <div class="card-body">
                    <div class="data-table-wrap"><table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Referência</th>
                                <th>Estado</th>
                                <th>Ocupado até</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ocupacao as $apartamento)
                            <tr>
                                <td>
                                    {{ $apartamento->referencia }}
                                </td>
                                <td>
                                    @if($apartamento->estado == 'Disponivel')
                                    <span class="badge bg-success">
                                        Disponível
                                    </span>
                                    @else
                                    <span class="badge bg-danger">
                                        Ocupado
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($apartamento->estado == 'Nao Disponivel' && $apartamento->data_saida)
                                    {{ date('d/m/Y', strtotime($apartamento->data_saida)) }}
                                    @else
                                    —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table></div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <strong>Receita Mensal</strong>
            </div>
            <div class="card-body">
                @foreach($receitaMensal as $receita)
                <div class="d-flex justify-content-between mb-2">
                    <span>
                        {{ $receita->mes }}
                    </span>
                    <span class="badge bg-success">
                        {{ number_format($receita->total, 2, ',', '.') }} €
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header">
                        Top Clientes
                    </div>
                    <div class="card-body chart-panel">
                        <canvas id="graficoClientes"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header">
                        Receita Mensal
                    </div>
                    <div class="card-body chart-panel">
                        <canvas id="graficoReceita"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header">
                        Reservas por Apartamento
                    </div>
                    <div class="card-body chart-panel">
                        <canvas id="graficoApartamentos"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <strong>Últimas Atividades</strong>
            </div>
            <div class="card-body">
                @if($atividades->count())
                <ul class="list-group list-group-flush">
                    @foreach($atividades as $atividade)
                    <li class="list-group-item">
                        <small class="text-muted">
                            {{ $atividade->created_at->format('d/m/Y H:i') }}
                        </small>
                        <br>
                        {{ $atividade->descricao }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">
                    Ainda não existem atividades registadas.
                </p>
                @endif
            </div>
        </div>

</div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
            // Gráfico de Receita
            const ctx = document.getElementById('graficoReceita');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labelsReceita),
                    datasets: [{
                        label: 'Receita (€)',
                        data: @json($dadosReceita),
                        borderColor: '#2F4F4F',
                        backgroundColor: '#2F4F4F',
                        borderWidth: 3,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Gráfico de Clientes
            const ctxClientes = document.getElementById('graficoClientes');

            new Chart(ctxClientes, {
                type: 'bar',
                data: {
                    labels: @json($labelsClientes),
                    datasets: [{
                        label: 'Reservas',
                        data: @json($dadosClientes),
                        backgroundColor: '#2F4F4F',
                        borderColor: '#2F4F4F',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Gráfico de Reservas por Apartamento
            const ctxApartamentos = document.getElementById('graficoApartamentos');

            new Chart(ctxApartamentos, {
                type: 'bar',
                data: {
                    labels: @json($labelsApartamentos),
                    datasets: [{
                        label: 'Reservas',
                        data: @json($dadosApartamentos),
                        backgroundColor: '#2F4F4F',
                        borderColor: '#2F4F4F',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
@endpush
