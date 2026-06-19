<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>


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
                Editar Reserva
            </p>

        </div>

        <div class="card shadow-sm">

            <div class="card-body">
                <form action="{{ route('vendas.update', $venda->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            Cliente
                        </label>
                        <input type="text"
                            name="cliente"
                            class="form-control"
                            value="{{ $venda->cliente }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Apartamento
                        </label>
                        <input type="text"
                            class="form-control"
                            value="{{ $venda->apartamento }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Entrada
                        </label>
                        <input type="date"
                            name="data_entrada"
                            class="form-control"
                            value="{{ $venda->data_entrada }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Saída
                        </label>
                        <input type="date"
                            name="data_saida"
                            class="form-control"
                            value="{{ $venda->data_saida }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Valor Total (€)
                        </label>
                        <input type="number"
                            name="valor_total"
                            class="form-control"
                            value="{{ $venda->valor_total }}"
                            required>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button type="submit" class="btn btn-olive">
                                Guardar Alterações
                            </button>
                            <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary">
                                Voltar
                            </a>

                        </div>

                        <form action="{{ route('vendas.destroy', $venda->id) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <!-- Botão alerta cancelar reserva -->
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Tem a certeza que pretende cancelar a reserva?')">
                                Cancelar Reserva
                            </button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>