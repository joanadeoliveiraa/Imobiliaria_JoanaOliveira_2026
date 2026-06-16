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

        .card-topo {
            border-left: 5px solid #2F4F4F;
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .card-dashboard {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-dashboard:hover {
            transform: translateY(-3px);
        }

        .numero {
            font-size: 2rem;
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
    <!-- Cabeçalho -->
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
                <div class="card card-dashboard">
                    <a href="{{ route('apartamentos.index', ['estado' => 'Disponivel']) }}" class="text-decoration-none">
                        <div class="card-body text-center">
                            <div class="titulo-card">Apartamentos Disponíveis</div>
                            <div class="numero">{{ $disponiveis }}</div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dashboard">
                <a href="{{ route('apartamentos.index', ['estado' => 'Nao Disponivel']) }}" class="text-decoration-none">
                    <div class="card-body text-center">
                        <div class="titulo-card">Apartamentos Ocupados</div>
                        <div class="numero">{{ $naoDisponiveis }}</div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body text-center">
                <div class="titulo-card">Clientes Registados</div>
                <div class="numero">{{ $clientes }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-dashboard">
            <div class="card-body text-center">
                <div class="titulo-card">Reservas Totais</div>
                <div class="numero">{{ $reservas }}</div>
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
            <strong>Últimas Atividades</strong>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Ainda não existem atividades registadas.
            </p>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ url('/') }}" class="btn btn-olive">
            Voltar ao Menu Principal
        </a>
    </div>


</body>

</html>