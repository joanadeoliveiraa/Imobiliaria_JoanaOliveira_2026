<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartamentos</title>
</head>

<body>
    <h1>Lista de apartamentos</h1>

    <a href="{{ route('apartamentos.create') }}">
        Novo Apartamento
    </a>

    <hr>

    @foreach($apartamentos as $apartamento)

        <p>
            {{ $apartamento->referencia }}
        </p>

    @endforeach
    
</body>
</html>