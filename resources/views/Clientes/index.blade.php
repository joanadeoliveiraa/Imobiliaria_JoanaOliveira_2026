<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>

<body>
    <h1>Lista de Clientes</h1>

    <p>
        <a href="{{ route('clientes.create') }}">
            Novo Cliente
        </a>
    </p>

    <table border="1">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Morada</th>
                <th>NIF</th>
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
                    <a href="{{ route('clientes.show', $cliente->id) }}">
                        Ver
                    </a>
                    <a href="{{ route('clientes.edit', $cliente->id) }}">
                        Editar
                    </a>

                    <form action="{{ route('clientes.destroy', $cliente->id) }}"
                        method="POST" style="display:inline;">

                        @csrf
                        @method('DELETE') //Apagar cliente

                        <button type="submit"> Apagar </button>
                    </form>
                </td>
            </tr>

            @endforeach




        </tbody>

    </table>

</body>

</html>