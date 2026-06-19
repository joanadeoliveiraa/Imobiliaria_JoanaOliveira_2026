<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olive Properties - Algarve</title>

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
    </style>


</head>

<body>


    <div class="container mt-4">

        <div class="card-topo">

            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>

            <p class="subtitulo">
                Gestão de apartamentos turísticos no Algarve
            </p>

        </div>

        <div class="card">

            <div class="card-header">
                <h4>Detalhes do Cliente</h4>
            </div>

            <div class="card-body">

                <p>
                    <strong>ID:</strong> {{ $cliente->id }}
                </p>

                <p>
                    <strong>Nome:</strong> {{ $cliente->nome }}
                </p>

                <p>
                    <strong>Email:</strong> {{ $cliente->email }}
                </p>

                <p>
                    <strong>Telefone:</strong> {{ $cliente->telefone }}
                </p>

                <p>
                    <strong>Morada:</strong> {{ $cliente->morada }}
                </p>

                <p>
                    <strong>NIF:</strong> {{ $cliente->nif }}
                </p>

<div class="mt-4">
                <a href="{{ route('clientes.reservas', $cliente->nome) }}"
                    class="btn btn-dark">
                    Histórico de Reservas
                </a>

                <a href="{{ route('clientes.edit', $cliente->id) }}"
                    class="btn btn-outline-dark">
                    Editar Cliente
                </a>
                <a href="{{ route('clientes.index') }}"
                    class="btn btn-outline-secondary">
                    Voltar
                </a>

            </div>

        </div>

    </div>


</body>

</html>