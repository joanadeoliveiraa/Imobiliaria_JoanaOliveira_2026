<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .titulo-principal {
            color: #2F4F4F;
            font-weight: bold;
        }

        .subtitulo {
            color: #6C757D;
        }

        .card-body canvas {
            height: 280px !important;
        }

        .card-topo {
            border-left: 5px solid #2F4F4F;
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .card-dashboard {
            transition: 0.3s;
        }

        .card-header {
            background-color: #2F4F4F !important;
            color: white !important;
        }

        .card-dashboard:hover {
            transform: translateY(-4px);
        }

        .numero {
            font-size: 2.3rem;
            font-weight: bold;
            color: #2F4F4F;
        }

        .titulo-card {
            color: #6C757D;
            font-size: 0.95rem;
        }

        .btn-olive {
            background-color: #2F4F4F;
            color: white;
            border: none;
        }

        .btn-olive:hover {
            background-color: #556B2F;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="card-topo">
            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>
            <p class="subtitulo">
                Painel de Gestão Empresarial
            </p>
            <p class="text-muted">
                Último acesso: {{ $ultimoAcesso }}
            </p>
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
                <a href="{{ route('apartamentos.index', ['estado' => 'Disponivel']) }}" class="text-decoration-none">
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
                <a href="{{ route('apartamentos.index', ['estado' => 'Nao Disponivel']) }}" class="text-decoration-none">
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
                        <div class="numero" style="font-size:1.2rem;">
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
                        <div class="numero" style="font-size:1.2rem;">
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
                        <div class="numero" style="font-size:1.2rem;">
                            @if($proximaReserva)
                            {{ date('d/m/Y', strtotime($proximaReserva->data_entrada)) }}
                            @else
                            -
                            @endif
                        </div>
                    </div>
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
                    <div class="card-body">
                        <canvas id="graficoClientes"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header">
                        Receita Mensal
                    </div>
                    <div class="card-body">
                        <canvas id="graficoReceita"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-dashboard h-100">
                    <div class="card-header">
                        Reservas por Apartamento
                    </div>
                    <div class="card-body">
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

        <div class="text-center mt-5">
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                Voltar ao Menu Principal
            </a>
        </div>
    </div>

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
</body>

</html>