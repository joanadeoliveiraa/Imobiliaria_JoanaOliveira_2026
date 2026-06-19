<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .titulo-principal {
        color: #2F4F4F;
        font-weight: bold;
    }

    .subtitulo {
        color: #6C757D;
    }

    .btn-dark {
        background-color: #2F4F4F;
        border: none;
    }

    .btn-dark:hover {
        background-color: #556B2F;
    }

    /* Cabeçalho Olive */

    .cabecalho-site {
        background-color: #2F4F4F;
        padding: 30px 40px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .cabecalho-site h2,
    .cabecalho-site p,
    .cabecalho-site small {
        color: white !important;
    }

    .apenas-impressao {
        display: none;
    }

    /* Impressão */

    @media print {

        @page {
            margin: 1.5cm;
        }

        body {
            zoom: 75%;
            margin: 0;
            padding: 0;
        }

        /* esconder apenas elementos do site */

        .no-print,
        .no-print * {
            display: none !important;
        }

        /* mostrar título do relatório */

        .apenas-impressao {
            display: block !important;
        }

        /* manter cores */

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* tabela */

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .table th,
        .table td {
            padding: 5px !important;
            vertical-align: middle;
        }

        .table-dark th {
            background-color: #2F4F4F !important;
            color: white !important;
        }

        thead {
            display: table-header-group;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa !important;
        }

        /* esconder coluna ações */

        th.no-print,
        td.no-print {
            display: none !important;
        }
    }
</style>

<body>
    <div class="container py-4" style="max-width:1200px;">

        <!-- Cabeçalho Site -->
        <div class="cabecalho-site mb-4">
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
                    <p class="mb-1">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>
                    <small>
                        Gestão de Reservas
                    </small>
                </div>

            </div>

        </div>



        <!-- Botões -->
        <div class="d-flex justify-content-between mb-3 no-print">
            <div>
                <a href="{{ route('vendas.create') }}" class="btn btn-dark">
                    Nova Reserva
                </a>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    Relatório PDF
                </button>
                <a href="{{ url('/') }}" class="btn btn-outline-dark">
                    ← Menu Principal
                </a>
            </div>
        </div>

        <!-- Título Impressão -->
        <div class="apenas-impressao mb-4">
            <h3 class="titulo-principal">
                Relatório de Reservas
            </h3>
            <small class="text-muted">
                Documento emitido em {{ date('d/m/Y H:i') }}
            </small>
        </div>

        <!-- Tabela -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">

                <tr>

                    <th>Cliente</th>
                    <th>Apartamento</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Valor Total</th>

                    <th class="no-print">
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->cliente }}</td>
                    <td>{{ $venda->apartamento }}</td>
                    <td>{{ date('d/m/Y', strtotime($venda->data_entrada)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($venda->data_saida)) }}</td>
                    <td>{{ number_format($venda->valor_total, 2, ',', '.') }} €</td>
                    <td class="no-print">
                        <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-outline-dark btn-sm">
                            Detalhes
                        </a>
                        <a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>
                        <form action="{{ route('vendas.destroy', $venda->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="button"
                                class="btn btn-outline-danger btn-sm btn-apagar"
                                data-url="{{ route('vendas.destroy', $venda->id) }}">
                                Apagar
                            </button>

                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Rodapé Impressão -->
        <div class="apenas-impressao text-center text-muted mt-5">
            <hr>
            <p class="mb-1">
                Obrigado por escolher a Olive Properties.
            </p>
            <small>
                Documento gerado automaticamente pelo sistema.
            </small>
        </div>

    </div>
    <div class="modal fade" id="modalApagarReserva" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        Confirmar Eliminação
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    Tem a certeza que pretende apagar esta reserva?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <form id="formEliminar" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-danger">
                            Apagar Reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>