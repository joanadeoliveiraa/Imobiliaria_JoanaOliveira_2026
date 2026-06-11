<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Cliente</title>
</head>

<body>
    <h1>Detalhes do Cliente</h1>

    <p>
        <strong>ID:</strong>{{ $cliente->id }}
    </p>
    
    <p>
        <strong>Nome:</strong>{{ $cliente->nome }}
    </p>

    <p>
        <strong>Email:</strong>{{ $cliente->email }}
    </p>

    <p>
        <strong>Telefone:</strong>{{ $cliente->telefone }}
    </p>

    <p>
        <strong>Morada:</strong>{{ $cliente->morada }}
    </p>

    <p>
        <strong>NIF:</strong>{{ $cliente->nif }}
    </p>

    <a href="{{ route('clientes.index') }}">
        Voltar
    </a>
</body>
</html>