<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartamentos</title>

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
       Cabeçalho Site
    ========================== */

    .cabecalho-site {
        background-color: #2F4F4F;
        padding: 30px 40px;
        border-radius: 12px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .cabecalho-site h2,
    .cabecalho-site p,
    .cabecalho-site small {
        color: white;
        margin: 0;
    }

    /* ==========================
       Impressão
    ========================== */

    .cabecalho-relatorio,
    .apenas-impressao {
        display: none;
    }

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

        .apenas-impressao {
            display: block !important;
        }

        .cabecalho-relatorio {
            display: block !important;
            background-color: #2F4F4F !important;
            color: white !important;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .cabecalho-relatorio h2,
        .cabecalho-relatorio p,
        .cabecalho-relatorio small {
            color: white !important;
        }

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

        /* esconder coluna ações */

        th:last-child,
        td:last-child {
            display: none !important;
        }

        .apenas-impressao hr {
            margin: 30px 0 15px;
        }

        /* esconder fotografias na impressão */

        .foto-apartamento {
            display: none !important;
        }

        th:first-child,
        td:first-child {
            display: none !important;
        }
    }

</style>
    </style>

</head>

<body>

    <div class="container py-4" style="max-width:1200px;">

        <!-- Cabeçalho Site -->
        <div class="cabecalho-site no-print mb-4">

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
                        Gestão de Apartamentos Turísticos
                    </small>

                </div>

            </div>

        </div>

        <!-- Cabeçalho Impressão -->
        <div class="cabecalho-relatorio apenas-impressao mb-4">

            <div class="d-flex align-items-center">

                <img src="{{ asset('images/folhas_brancas.png') }}"
                    alt="Olive Properties"
                    width="180"
                    class="me-4">

                <div>

                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>

                    <p class="mb-1">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>

                    <small>
                        Relatório de Apartamentos |
                        {{ date('d/m/Y H:i') }}
                    </small>

                </div>

            </div>

        </div>

        @if(session('success'))

        <div class="alert alert-success no-print">
            {{ session('success') }}
        </div>

        @endif

        <!-- Botões -->
        <div class="d-flex justify-content-between mb-3 no-print">

            <div>

                <a href="{{ route('apartamentos.create') }}"
                    class="btn btn-dark">

                    Novo Apartamento

                </a>

            </div>

            <div>

                <button onclick="window.print()"
                    class="btn btn-outline-secondary">

                    Relatório PDF

                </button>

                <a href="{{ url('/') }}"
                    class="btn btn-outline-dark">

                    ← Menu Principal

                </a>

            </div>

        </div>

        <!-- Pesquisa avançada apartamentos -->
        <form method="GET"
            action="{{ route('apartamentos.index') }}"
            class="no-print">

            <div class="row mb-3 align-items-center">

                <div class="col-md-6">

                    <input type="text"
                        name="pesquisa"
                        class="form-control"
                        placeholder="Pesquisar por referência, tipologia ou morada"
                        value="{{ request('pesquisa') }}">

                </div>

                <div class="col-md-3">

                    <select name="ordenar"
                        class="form-select"
                        onchange="this.form.submit()">

                        <option value="">
                            Ordenar por...
                        </option>

                        <option value="id"
                            {{ request('ordenar') == 'id' ? 'selected' : '' }}>
                            ID
                        </option>

                        <option value="tipologia"
                            {{ request('ordenar') == 'tipologia' ? 'selected' : '' }}>
                            Tipologia
                        </option>

                        <option value="area"
                            {{ request('ordenar') == 'area' ? 'selected' : '' }}>
                            Área
                        </option>

                        <option value="preco"
                            {{ request('ordenar') == 'preco' ? 'selected' : '' }}>
                            Preço
                        </option>

                    </select>

                </div>

                <div class="col-md-3">

                    <div class="d-flex gap-3">

                        <button type="submit"
                            class="btn btn-dark flex-fill">

                            Procurar

                        </button>

                        <a href="{{ route('apartamentos.index') }}"
                            class="btn btn-outline-dark flex-fill">

                            Limpar

                        </a>

                    </div>

                </div>

            </div>

        </form>

        <!-- Título para impressão -->
        <div class="apenas-impressao mb-4">

            <h3 class="titulo-principal">
                Relatório de Apartamentos
            </h3>

            <small class="text-muted">
                Documento emitido em {{ date('d/m/Y H:i') }}
            </small>

        </div>

        <!-- Tabela -->
        <table class="table table-striped table-bordered">

            <thead class="table-dark">

                <tr>

                    <th class="foto-apartamento">Foto</th>
                    <th>Referência</th>
                    <th>Tipologia</th>
                    <th>Morada</th>
                    <th>Área</th>
                    <th>Preço</th>
                    <th>Estado</th>

                    <th class="no-print">
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($apartamentos as $apartamento)

                <tr>

                    <td class="foto-apartamento">

                        @if($apartamento->fotografia)

                        <img src="{{ asset('storage/' . $apartamento->fotografia) }}"
                            width="80"
                            height="60"
                            class="rounded shadow-sm"
                            style="object-fit: cover;">

                        @else

                        <span class="text-muted">
                            Sem foto
                        </span>

                        @endif

                    </td>

                    <td>{{ $apartamento->referencia }}</td>
                    <td>{{ $apartamento->tipologia }}</td>
                    <td>{{ $apartamento->morada }}</td>
                    <td>{{ $apartamento->area }} m²</td>
                    <td>{{ $apartamento->preco }} €</td>
                    <td>{{ $apartamento->estado }}</td>

                    <td class="no-print">

                        <a href="{{ route('apartamentos.show', $apartamento->id) }}"
                            class="btn btn-outline-dark btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('apartamentos.edit', $apartamento->id) }}"
                            class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $apartamentos->appends(request()->query())->links() }}
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

</body>

</html>