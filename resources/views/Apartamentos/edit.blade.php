<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Apartamento</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>


<div class="container mt-4">

    <h1 class="text-primary">
        Olive Properties - Algarve
    </h1>

    <h3>
        Editar Apartamento
    </h3>

    <form action="{{ route('apartamentos.update', $apartamento->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label class="form-label">
                Referência
            </label>

            <input type="text"
                class="form-control"
                value="{{ $apartamento->referencia }}"
                readonly>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Tipologia
            </label>

            <input type="text"
                name="tipologia"
                class="form-control"
                value="{{ $apartamento->tipologia }}">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Morada
            </label>

            <input type="text"
                name="morada"
                class="form-control"
                value="{{ $apartamento->morada }}">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Área (m²)
            </label>

            <input type="number"
                name="area"
                class="form-control"
                value="{{ $apartamento->area }}">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Preço por Semana (€)
            </label>

            <input type="number"
                name="preco"
                class="form-control"
                value="{{ $apartamento->preco }}">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Estado
            </label>

            <select name="estado" class="form-select">

                <option value="Disponivel"
                    {{ $apartamento->estado == 'Disponivel' ? 'selected' : '' }}>
                    Disponível
                </option>

                <option value="Nao Disponivel"
                    {{ $apartamento->estado == 'Nao Disponivel' ? 'selected' : '' }}>
                    Não Disponível
                </option>

            </select>

        </div>

        <button type="submit"
            class="btn btn-dark">
            Atualizar
        </button>

        <a href="{{ route('apartamentos.index') }}"
            class="btn btn-outline-secondary">
            Cancelar
        </a>

    </form>

</div>


</body>

</html>
