<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestão de Reservas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

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

        .btn {
            background-color: #2F4F4F;
            color: white;
            border: none;
        }

        .btn:hover {
            background-color: #3f6666;
            color: white;
        }

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
    </style>

</head>

<body>

    <div class="container mt-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
        @endif

        <div class="cabecalho-site mb-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('images/folhas_brancas.png') }}" alt="Olive Properties" width="185">
                </div>
                <div class="col-md-9">
                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>
                    <p class="mb-1">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="titulo-principal mb-1">
                Nova Reserva
            </h3>
            <small class="text-muted">
                Registo de uma nova reserva
            </small>

        </div>



        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('vendas.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Apartamento
                        </label>

                        <select name="apartamento"
                            id="apartamento"
                            class="form-select">

                            @foreach($apartamentos as $apartamento)

                            <option value="{{ $apartamento->referencia }}"
                                data-preco="{{ $apartamento->preco }}">

                                {{ $apartamento->referencia }} -
                                {{ $apartamento->tipologia }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Cliente
                        </label>
                        <select name="cliente" class="form-select" required>
                            <option value="">
                                Selecione um cliente
                            </option>

                            @foreach($clientes as $cliente)

                            <option value="{{ $cliente->nome }}"
                                {{ isset($clienteSelecionado) && $clienteSelecionado == $cliente->nome ? 'selected' : '' }}>
                                {{ $cliente->nome }}
                            </option>

                            @endforeach

                        </select>
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('clientes.create', ['origem' => 'reserva']) }}" class="btn">
                                + Novo Cliente
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Entrada
                        </label>

                        <input type="date"
                            id="data_entrada"
                            name="data_entrada"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Saída
                        </label>
                        <input type="date"
                            id="data_saida"
                            name="data_saida"
                            class="form-control"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Valor Total (€)
                        </label>
                        <input type="number"
                            id="valor_total"
                            name="valor_total"
                            class="form-control"
                            readonly>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn">
                            Confirmar Reserva
                        </button>

                        <a href="{{ route('vendas.index') }}" class="btn btn-outline-dark">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function atualizarPreco() {
            let apartamento = document.getElementById('apartamento');

            let preco = apartamento.options[apartamento.selectedIndex].dataset.preco;

            document.getElementById('valor_total').value = preco;
        }

        document.getElementById('data_entrada').addEventListener('change', function() {
            let entrada = new Date(this.value);
            entrada.setDate(entrada.getDate() + 7);

            let saida = entrada.toISOString().split('T')[0];

            document.getElementById('data_saida').value = saida;
        });

        document.getElementById('apartamento').addEventListener('change', atualizarPreco);

        atualizarPreco();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>