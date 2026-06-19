<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Reserva</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">
    
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
                Detalhes da Reserva
            </p>
        </div>

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

                <!-- <p>
                    <strong>Estado:</strong>
                    {{ $apartamento->estado }}
                </p> -->

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

                <div class="d-flex gap-2">
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
</body>

</html>