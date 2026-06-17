<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da Reserva</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .titulo-principal {
            color: #2F4F4F;
            font-weight: bold;
        }

        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
        }

        .card-header-custom {
            background-color: #2F4F4F;
            color: white;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>


</head>

<body>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header card-header-custom">
                <h3>Reserva Confirmada</h3>
            </div>

            <div class="card-body">
                <h4 class="titulo-principal">
                    Olive Properties - Algarve
                </h4>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="subtitulo mb-0">
                        Resumo da Reserva
                    </h5>

                    <div class="no-print">
                        <button
                            onclick="window.print()"
                            class="btn btn-outline-secondary">
                            🖨 Imprimir / PDF
                        </button>
                    </div>

                </div>

                <hr>


                <p>
                    <strong>Cliente:</strong>
                    {{ $venda->cliente }}
                </p>

                <p>
                    <strong>Apartamento:</strong>
                    {{ $venda->apartamento }}
                </p>
                <hr>

                <h5 class="mb-3">
                    Detalhes do Imóvel
                </h5>

                <p>
                    <strong>Referência:</strong>
                    {{ $apartamento->referencia }}
                </p>

                <p>
                    <strong>Tipologia: </strong>
                    {{ $apartamento->tipologia }}
                </p>

                <p>
                    <strong>Morada: </strong>
                    {{ $apartamento->morada }}
                </p>

                <p>
                    <strong>Área:</strong>
                    {{ $apartamento->area }} m²
                </p>
                <hr>
                <h5 class="mb-3">
                    Detalhes da Reserva
                </h5>
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

                <a href="{{ route('vendas.create') }}"
                    class="btn btn-dark">
                    Nova Reserva
                </a>

                <a href="{{ url('/') }}"
                    class="btn btn-outline-secondary">
                    Menu Principal
                </a>

                <a href="{{ route('clientes.reservas', $venda->cliente) }}"
                    class="btn btn-outline-primary">
                    Histórico do Cliente
                </a>

            </div>

        </div>


    </div>

</body>

</html>