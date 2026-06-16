<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>


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

<body>

    <div class="container mt-4">

        <div class="card-topo">

            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>

            <p class="subtitulo">
                Gestão de Reservas
            </p>

        </div>

        <a href="{{ route('vendas.create') }}"
            class="btn btn-dark mb-3">
            Nova Reserva
        </a>

        <a href="{{ url('/') }}"
            class="btn btn-outline-dark mb-3">
            ← Menu Principal
        </a>

        <table class="table table-striped table-bordered">

            <thead>
                <tr>

                    <th>Cliente</th>
                    <th>Apartamento</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody>

                @foreach($vendas as $venda)

                <tr>

                    <td>{{ $venda->cliente }}</td>
                    <td>{{ $venda->apartamento }}</td>
                    <td>{{ $venda->data_entrada }}</td>
                    <td>{{ $venda->data_saida }}</td>
                    <td>{{ $venda->valor_total }} €</td>
                    <td>

                        <a href="{{ route('vendas.show', $venda->id) }}"
                            class="btn btn-outline-dark btn-sm">
                            Detalhes
                        </a>

                        <a href="{{ route('vendas.edit', $venda->id) }}"
                            class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>
                    

                    <!-- <form action="{{ route('vendas.destroy', $venda->id) }}"
                        method="POST"
                        style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Apagar
                        </button>

                    </form> -->

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>


</body>

</html>