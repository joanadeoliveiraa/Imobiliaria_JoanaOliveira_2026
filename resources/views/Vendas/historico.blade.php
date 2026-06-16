<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Reservas</title>

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
            margin-bottom: 20px;
        }

        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
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
                Histórico de Reservas do Cliente
            </p>

        </div>

        <div class="">
            <strong>Cliente:</strong>
            {{ $cliente }}

        </div>

        <!-- Histórico resevras -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="alert alert-success py-2">
                    <strong>Total de Reservas:</strong>
                    {{ $totalReservas }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-info py-2">
                    <strong>Total Gasto:</strong>
                    {{ number_format($totalGasto, 2, ',', '.') }} €
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-secondary py-2">
                    <strong>Última Reserva:</strong>

                    @if($ultimaReserva)
                    {{ date('d/m/Y', strtotime($ultimaReserva)) }}
                    @else
                    -
                    @endif
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Apartamento</th>
                    <th>Data de Entrada</th>
                    <th>Data de Saída</th>
                    <th>Valor Total</th>
                </tr>
            </thead>

            <tbody>

                @forelse($vendas as $venda)

                <tr>
                    <td>{{ $venda->apartamento }}</td>
                    <td>{{ $venda->data_entrada }}</td>
                    <td>{{ $venda->data_saida }}</td>
                    <td>{{ $venda->valor_total }} €</td>
                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Não existem reservas para este cliente.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        <div class="mt-4">

            <a href="{{ route('vendas.create') }}"
                class="btn btn-dark">
                Nova Reserva
            </a>

            <a href="{{ route('vendas.index') }}"
                class="btn btn-outline-secondary">
                Ver Reservas
            </a>

            <a href="{{ url('/') }}"
                class="btn btn-outline-dark">
                Menu Principal
            </a>

        </div>
    </div>
</body>
</html>