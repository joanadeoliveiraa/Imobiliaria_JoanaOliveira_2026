<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Apartamento</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .cabecalho-site {
            background-color: #2F4F4F;
            padding: 30px 40px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .cabecalho-site h2,
        .cabecalho-site p,
        .cabecalho-site small {
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="cabecalho-site mb-4">
        <div class="row align-items-center">
            <div class="col-md-3">
                <img src="{{ asset('images/folhas_brancas.png') }}" alt="Olive Properties" width="185">
            </div>
            <div class="col-md-9">
                <h2 class="mb-1">
                    Olive Properties - Algarve
                </h2>
                <p class="mb-1">
                    Luxury Holiday Apartments • Algarve • Portugal
                </p>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h3 class="titulo-principal mb-1">
            Editar Apartamento
        </h3>
        <small class="text-muted">
            Atualização dos dados do imóvel
        </small>
    </div>





    <form action="{{ route('apartamentos.update', $apartamento->id) }}"
        method="POST"
        enctype="multipart/form-data">

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

        @if($apartamento->fotografia)

        <div class="mb-3 text-center">

            <img src="{{ asset('storage/' . $apartamento->fotografia) }}"
                class="img-fluid rounded shadow"
                style="max-height:250px;">

        </div>

        @endif

        <div class="mb-3">
            <label class="form-label">
                Fotografia
            </label>
            <input type="file"
                name="fotografia"
                class="form-control">
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