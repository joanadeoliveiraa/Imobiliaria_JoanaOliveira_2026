<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>

<body>

    <h1>Editar Cliente</h1>

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">

        @csrf
        @method('PUT') // Indicar que vamos atualizar um registo

        <p>
            Nome: <input type="text" name="nome" value="{{ $cliente->nome }}">
        </p>

        <p>
            Email: <input type="email" name="email" value="{{ $cliente->email }}">
        </p>

        <p>
            Telefone: <input type="text" name="telefone" value="{{ $cliente->telefone }}">
        </p>

        <p>
            Morada: <input type="text" name="morada" value="{{ $cliente->morada }}">
        </p>

        <p>
            NIF: <input type="text" name="nif" value="{{ $cliente->nif }}">
        </p>

        <button type="submit"> Atualizar </button>

        <a href="{{ route('clientes.index') }}"> Cancelar </a>

    </form>

</body>

</html>