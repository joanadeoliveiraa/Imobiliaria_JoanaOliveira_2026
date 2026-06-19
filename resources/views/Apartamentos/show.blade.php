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

            @if($apartamento->fotografia)
            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $apartamento->fotografia) }}"
                    class="img-fluid rounded shadow"
                    style="max-height:400px;">
            </div>

            @endif



            <div class="card-header">
                <h4>Detalhes do Apartamento</h4>
            </div>

            <div class="card-body">

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

                <p>
                    <strong>Estado:</strong>
                    {{ $apartamento->estado }}
                </p>


                @if($apartamento->estado == 'Disponivel')

                <a href="{{ route('vendas.create') }}"
                    class="btn btn-dark">
                    Reservar Imóvel
                </a>


                @else

                <div class="alert alert-danger">
                    Este imóvel não se encontra disponível para reserva.
                </div>

                @endif

                <a href="{{ route('apartamentos.index') }}"
                    class="btn btn-outline-secondary">
                    Voltar
                </a>

            </div>

        </div>

    </div>


</body>

</html>