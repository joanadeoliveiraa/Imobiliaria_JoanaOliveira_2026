<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olive Properties - Algarve</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ==========================
       Identidade Visual
    ========================== */

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

        /* ==========================
       Cabeçalho
    ========================== */

        .cabecalho-site {
            background-color: #2F4F4F;
            padding: 30px 40px;
            border-radius: 12px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .cabecalho-site h2,
        .cabecalho-site p {
            color: white;
            margin: 0;
        }

        /* ==========================
       Relatórios
    ========================== */

        .cabecalho-relatorio,
        .apenas-impressao {
            display: none;
        }

        .cabecalho-relatorio h2 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cabecalho-relatorio p {
            margin-bottom: 0;
        }

        /* ==========================
       Paginação
    ========================== */

        .pagination .page-link {
            color: #2F4F4F;
            border-color: #2F4F4F;
            border-radius: 6px;
        }

        .pagination .page-link:hover {
            background-color: #2F4F4F;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #2F4F4F;
            border-color: #2F4F4F;
            color: white;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        /* ==========================
       Impressão
    ========================== */

        @media print {

            @page {
                margin: 1.5cm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                zoom: 85%;
                margin: 0;
                padding: 0;
            }



            .no-print,
            .no-print * {
                display: none !important;
            }

            form {
                display: none !important;
            }

            /* Mostrar elementos de impressão */
            .apenas-impressao {
                display: block !important;
            }

            .cabecalho-relatorio {
                display: block !important;
                background-color: #2F4F4F !important;
                color: white !important;
                padding: 25px !important;
                border-radius: 12px !important;
                margin-bottom: 25px !important;
            }

            .cabecalho-relatorio h2,
            .cabecalho-relatorio p,
            .cabecalho-relatorio small {
                color: white !important;
            }

            /* Remover coluna Ações */
            th:last-child,
            td:last-child {
                display: none !important;
            }

            /* Tabela */
            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th {
                background-color: #2F4F4F !important;
                color: white !important;
            }

            .table th,
            .table td {
                padding: 8px !important;
                vertical-align: middle;
            }

            .table-striped tbody tr:nth-child(odd) {
                background-color: #f8f9fa !important;
            }

            /* Rodapé */
            .apenas-impressao hr {
                margin: 30px 0 15px;
            }

            /* Paginação Olive */

            .pagination {
                gap: 5px;
            }

            .pagination .page-link {
                color: #2F4F4F;
                border: 1px solid #2F4F4F;
                border-radius: 6px;
                padding: 8px 14px;
                font-weight: 500;
            }

            .pagination .page-link:hover {
                background-color: #2F4F4F;
                color: white;
                border-color: #2F4F4F;
            }

            .pagination .page-item.active .page-link {
                background-color: #2F4F4F;
                border-color: #2F4F4F;
                color: white;
            }

            .pagination .page-item.disabled .page-link {
                color: #6c757d;
                background-color: #f8f9fa;
            }
        }
    </style>
    </style>

</head>

<body>

    <div class="container py-4" style="max-width:1200px;">

        <!-- Cabeçalho Site -->
        <div class="cabecalho-site no-print mb-5">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('images/folhas_brancas.png') }}" alt="Olive Properties" width="185">
                </div>

                <div class="col-md-9">
                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>
                    <p class="mb-0">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>
                    <small class="text-white-50">
                        Gestão de Clientes
                    </small>
                </div>
            </div>
        </div>

        <!-- Cabeçalho Impressão -->
        <div class="cabecalho-relatorio apenas-impressao mb-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/folhas_brancas.png') }}"
                    alt="Olive Properties"
                    width="170"
                    class="me-4">
                <div>
                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>
                    <p class="mb-1">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>
                </div>
            </div>

        </div>

        <!-- Botões -->
        <div class="d-flex justify-content-between mb-3 no-print">
            <div>
                <a href="{{ route('clientes.create') }}" class="btn btn-dark">
                    Novo Cliente
                </a>
            </div>

            <div>
                <button
                    onclick="window.print()" class="btn btn-outline-secondary">
                    Relatório PDF
                </button>

                <a href="{{ url('/') }}" class="btn btn-outline-dark">
                    ← Menu Principal
                </a>
            </div>
        </div>

        <!-- Pesquisa -->
        <form method="GET" action="{{ route('clientes.index') }}" class="no-print">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <input type="text"
                        name="pesquisa"
                        class="form-control"
                        placeholder="Pesquisar por nome, email, contacto ou NIF"
                        value="{{ request('pesquisa') }}">
                </div>

                <div class="col-md-3">
                    <select name="ordenar" class="form-select" onchange="this.form.submit()">
                        <option value="">Ordenar por...</option>
                        <option value="nome"
                            {{ request('ordenar') == 'nome' ? 'selected' : '' }}>
                            Nome
                        </option>
                        <option value="telefone"
                            {{ request('ordenar') == 'telefone' ? 'selected' : '' }}>
                            Contacto
                        </option>
                        <option value="email"
                            {{ request('ordenar') == 'email' ? 'selected' : '' }}>
                            Email
                        </option>
                        <option value="nif"
                            {{ request('ordenar') == 'nif' ? 'selected' : '' }}>
                            NIF
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-dark flex-fill">
                            Procurar
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-dark flex-fill">
                            Limpar
                        </a>
                    </div>
                </div>
            </div>

        </form>

        <!-- Título Relatório (apenas impressão) -->
        <div class="apenas-impressao mb-4">
            <h3 class="titulo-principal">
                Relatório de Clientes
            </h3>

            <small class="text-muted">
                Documento emitido em {{ date('d/m/Y H:i') }}
            </small>

        </div>

        <!-- Tabela -->
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Morada</th>
                    <th>NIF</th>
                    <th class="no-print">
                        Ações
                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach($clientes as $cliente)

                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->morada }}</td>
                    <td>{{ $cliente->nif }}</td>
                    <td class="no-print">
                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-outline-dark btn-sm">
                            Ver
                        </a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Tem a certeza que pretende apagar este cliente?')">
                                Apagar
                            </button>                         
                    </div>


                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $clientes->appends(request()->query())->links() }}
        </div>

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

    <!-- Modal Confirmação -->

    <div id="modalConfirmacao"
        style="display:none;
               position:fixed;
               top:0;
               left:0;
               width:100%;
               height:100%;
               background:rgba(0,0,0,.5);
               z-index:9999;">

        <div style="background:white;
                    width:400px;
                    max-width:90%;
                    margin:15% auto;
                    padding:25px;
                    border-radius:12px;
                    text-align:center;">

            <h5 class="mb-3">
                Confirmar Cancelamento
            </h5>
            <p>
                Tem a certeza que pretende cancelar esta reserva?
            </p>
            <form id="formApagar" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Sim, Cancelar
                </button>
                <button type="button" onclick="fecharModal()" class="btn btn-secondary">
                    Voltar
                </button>
            </form>
        </div>
    </div>

        <script>
        function abrirModal(url) {
            document.getElementById('formApagar').action = url;
            document.getElementById('modalConfirmacao').style.display = 'block';
        }
        function fecharModal() {
            document.getElementById('modalConfirmacao').style.display = 'none';
        }
    </script>

</body>

</html>