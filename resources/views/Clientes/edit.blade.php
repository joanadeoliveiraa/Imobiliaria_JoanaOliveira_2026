<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olive Properties - Algarve</title>

```
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
```

</head>

<body>

```
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
            <h4>Editar Cliente</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text"
                        name="nome"
                        class="form-control"
                        value="{{ $cliente->nome }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                        name="email"
                        class="form-control"
                        value="{{ $cliente->email }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="text"
                        name="telefone"
                        class="form-control"
                        value="{{ $cliente->telefone }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Morada</label>
                    <input type="text"
                        name="morada"
                        class="form-control"
                        value="{{ $cliente->morada }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">NIF</label>
                    <input type="text"
                        name="nif"
                        class="form-control"
                        value="{{ $cliente->nif }}">
                </div>

                <button type="submit"
                    class="btn btn-dark">
                    Atualizar
                </button>

                <a href="{{ route('clientes.index') }}"
                    class="btn btn-outline-secondary">
                    Cancelar
                </a>

            </form>

        </div>

    </div>

</div>
```

</body>

</html>
