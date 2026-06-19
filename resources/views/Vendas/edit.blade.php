<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">


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

        .btn-olive {
            background-color: #2F4F4F;
            color: white;
            border: none;
        }

        .btn-olive:hover {
            background-color: #556B2F;
            color: white;
        }

        /* Cabeçalho Olive */

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

    <div class="container py-4" style="max-width:1200px;">

        <!-- Cabeçalho -->
        <div class="cabecalho-site mb-4">

            <div class="row align-items-center">

                <div class="col-md-3">
                    <img src="{{ asset('images/folhas_brancas.png') }}"
                        alt="Olive Properties"
                        width="185">
                </div>

                <div class="col-md-9">
                    <h2 class="mb-1">
                        Olive Properties - Algarve
                    </h2>

                    <p class="mb-1">
                        Luxury Holiday Apartments • Algarve • Portugal
                    </p>

                    <small>
                        Gestão de Reservas
                    </small>
                </div>

            </div>

        </div>

        <!-- Título Página -->

        <h4 class="titulo-principal mb-4">
            Editar Reserva
        </h4>

        <!-- Formulário -->

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('vendas.update', $venda->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            Cliente
                        </label>
                        <input type="text"
                            name="cliente"
                            class="form-control"
                            value="{{ $venda->cliente }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Apartamento
                        </label>
                        <input type="text"
                            class="form-control"
                            value="{{ $venda->apartamento }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Entrada
                        </label>
                        <input type="date"
                            name="data_entrada"
                            class="form-control"
                            value="{{ $venda->data_entrada }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Data de Saída
                        </label>
                        <input type="date"
                            name="data_saida"
                            class="form-control"
                            value="{{ $venda->data_saida }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Valor Total (€)
                        </label>
                        <input type="number"
                            name="valor_total"
                            class="form-control"
                            value="{{ $venda->valor_total }}"
                            required>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button type="submit" class="btn btn-olive">
                                Guardar Alterações
                            </button>
                            <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary">
                                Voltar
                            </a>
                        </div>

                        <button type="button" class="btn btn-outline-danger" onclick="abrirModal('{{ route('vendas.destroy', $venda->id) }}')">
                            Cancelar Reserva
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirmação -->

    <div id="modalConfirmacao"
        style="display:none;
               position:fixed;
               top:0;
               left:0;
               width:100%;
               height:100%;
               background:rgba(0,0,0,.5);
               z-index:9999;">

        <div style="background:white;
                    width:400px;
                    max-width:90%;
                    margin:15% auto;
                    padding:25px;
                    border-radius:12px;
                    text-align:center;">

            <h5 class="mb-3">
                Confirmar Cancelamento
            </h5>
            <p>
                Tem a certeza que pretende cancelar esta reserva?
            </p>
            <form id="formApagar" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Sim, Cancelar
                </button>
                <button type="button" onclick="fecharModal()" class="btn btn-secondary">
                    Voltar
                </button>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(url) {
            document.getElementById('formApagar').action = url;
            document.getElementById('modalConfirmacao').style.display = 'block';
        }
        function fecharModal() {
            document.getElementById('modalConfirmacao').style.display = 'none';
        }
    </script>

</body>

</html>