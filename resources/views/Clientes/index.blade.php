<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olive Properties - Algarve</title>

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
    </style>

</head>

<body>

    <div class="container mt-4">

        <div class="card-topo">
            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>

            <p class="subtitulo">
                Gestão de Clientes
            </p>
        </div>

        <a href="{{ route('clientes.create') }}"
            class="btn btn-dark mb-3">
            Novo Cliente
        </a>

        <a href="{{ url('/') }}"
            class="btn btn-outline-dark mb-3">
            ← Menu Principal
        </a>


        <!-- Pesquisa avançada de clientes -->
        <form method="GET" action="{{ route('clientes.index') }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text"
                        name="pesquisa"
                        class="form-control"
                        placeholder="Pesquisar por nome, email, contacto ou NIF"
                        value="{{ request('pesquisa') }}">
                </div>

                <div class="col-md-3">                
                <select name="ordenar"
                        class="form-select"
                        onchange="this.form.submit()">
                        <option value="">
                            Ordenar por...
                        </option>
                        <option value="nome">
                            Nome
                        </option>
                        <option value="telefone">
                            Contacto
                        </option>
                        <option value="email">
                            Email
                        </option>
                        <option value="nif">
                            NIF
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">
                        Procurar
                    </button>

                </div>
            </div>
        </form>


        <table class="table table-striped table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Morada</th>
                    <th>NIF</th>
                    <th>Ações</th>
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

                    <td>

                        <a href="{{ route('clientes.show', $cliente->id) }}"
                            class="btn btn-outline-dark btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('clientes.edit', $cliente->id) }}"
                            class="btn btn-outline-secondary btn-sm">
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

                        </form>

                    </td>

                </tr>

                @endforeach



            </tbody>



        </table>

    </div>



</body>

</html>