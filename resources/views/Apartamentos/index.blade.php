<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartamentos</title>

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
             
        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
        }
    </style>

</head>

<body>
    <div class="container mt-4">

        <div class="card-topo">
            <h1 class="titulo-principal"> Olive Properties - Algarve </h1>

            <p class="subtitulo"> Gestão de apartamentos turísticos no Algarve </p>

        </div>
            @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

            @endif
        
        <a href="{{ route('apartamentos.create') }}" class="btn btn-dark mb-3">
            Novo Apartamento 
        </a>

        <a href="{{ url('/') }}"
            class="btn btn-dark mb-3">
            ← Menu Principal
        </a>



        <table class="table table-striped table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>Referência</th>
                    <th>Tipologia</th>
                    <th>Morada</th>
                    <th>Área</th>
                    <th>Preço</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>

            </thead>
            <tbody>

                @foreach($apartamentos as $apartamento)
                <tr>
                    <td>{{ $apartamento->referencia }}</td>
                    <td>{{ $apartamento->tipologia }}</td>
                    <td>{{ $apartamento->morada }}</td>
                    <td>{{ $apartamento->area }} m²</td>
                    <td>{{ $apartamento->preco }} €</td>
                    <td>{{ $apartamento->estado }}</td>
                    <td>
                        <a href="{{ route('apartamentos.show', $apartamento->id) }}" class="btn btn-outline-dark btn-sm"> Ver </a>

                        <a href="{{ route('apartamentos.edit', $apartamento->id) }}" class="btn btn-outline-secondary btn-sm"> Editar </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>