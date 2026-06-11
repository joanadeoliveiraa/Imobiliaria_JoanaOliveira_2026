<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Cliente</title>
</head>

<body>
    <h1>Novo Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">

    @csrf

        <p>
            Nome: <input type="text" name="nome">
        </p>

        <p>
            Email: <input type="email" name="email">
        </p>

        <p>
            Telefone: <input type="text" name="telefone">
        </p>

        <p>
            Morada: <input type="text" name="morada">
        </p>

        <p>
            NIF: <input type="text" name="nif">
        </p>

        
        <button type="submit"> Gravar </button>



    </form>
    
</body>
</html>