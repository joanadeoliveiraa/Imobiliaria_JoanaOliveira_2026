<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Novo Apartamento</title>

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

    </head>

<body>

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
                <h4>Novo Apartamento</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('apartamentos.store') }}" method="POST">

                    @csrf

                    <form action="{{ route('apartamentos.store') }}" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Tipologia</label>
                            <input type="text"
                                name="tipologia"
                                class="form-control"
                                placeholder="T1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Morada</label>
                            <input type="text"
                                name="morada"
                                class="form-control"
                                placeholder="Rua da Praia, Albufeira"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Área (m²)</label>
                            <input type="number"
                                step="0.01"
                                name="area"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço por Semana (€)</label>
                            <input type="number"
                                step="0.01"
                                name="preco"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado</label>

                            <select name="estado" class="form-select">

                                <option value="Disponível">Disponível</option>
                                
                                <option value="Não Disponível">Não Disponível</option>

                            </select>

                        </div>

                        <button type="submit"
                            class="btn btn-dark">
                            Gravar
                        </button>

                        <a href="{{ route('apartamentos.index') }}"
                            class="btn btn-outline-secondary">
                            Cancelar
                        </a>

                    </form>

            </div>

        </div>

    </div>


</html>