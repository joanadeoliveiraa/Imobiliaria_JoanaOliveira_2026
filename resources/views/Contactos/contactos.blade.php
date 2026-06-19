<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - Olive Properties</title>

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

        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
        }

        /* Cabeçalho Olive */
        .cabecalho-site {
            background-color: #2F4F4F;
            padding: 30px 40px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
        }

        .cabecalho-site h2,
        .cabecalho-site p,
        .cabecalho-site small {
            color: white !important;
        }

        /* Cards */
        .card-contacto {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            height: 100%;
        }

        .card-contacto h4 {
            color: #2F4F4F;
            font-weight: 600;
        }

        /* Formulário */
        .form-control:focus {
            border-color: #2F4F4F;
            box-shadow: 0 0 0 0.15rem rgba(47, 79, 79, 0.20);
        }


        .btn-outline-secondary:hover {
            background-color: #2F4F4F;
            border-color: #2F4F4F;
        }

        /* Rodapé */
        .footer-contactos {
            margin-top: 50px;
            text-align: center;
            color: #6C757D;
        }
    </style>

</head>

<body>

    <div class="container mt-4">

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Cabeçalho Olive -->
        <div class="cabecalho-site">
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
                    <small>
                        Entre em contacto connosco
                    </small>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card card-contacto p-4">
                    <h4>
                        Informações de Contacto
                    </h4>
                    <p class="text-muted">
                        Estamos disponíveis para esclarecer qualquer questão relacionada com os nossos alojamentos turísticos.
                    </p>
                    <hr>
                    <p>
                        Rua das Oliveiras, 25<br>
                        8200-000 Albufeira
                    </p>

                    <p>
                        <strong>Telefone:</strong><br>
                        +351 289 000 000
                    </p>

                    <p>
                        <strong>Email:</strong><br>
                        info@oliveproperties.pt
                    </p>

                    <p>
                        Estamos disponíveis para esclarecer qualquer dúvida sobre os nossos alojamentos turísticos.
                    </p>

                </div>
            </div>

            <div class="col-md-7">
                <div class="card card-contacto p-4">
                    <h4>
                        Envie-nos uma Mensagem
                    </h4>
                    <p class="text-muted">
                        Responderemos com a maior brevidade possível.
                    </p>
                    <hr>
                    <form action="{{ route('contactos.enviar') }}"
                        method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text"
                                name="nome"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text"
                                name="telefone"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assunto</label>
                            <input type="text"
                                name="assunto"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Mensagem
                            </label>

                            <textarea
                                name="mensagem"
                                class="form-control"
                                rows="5"
                                minlength="100"
                                placeholder="Descreva a sua questão..."
                                required></textarea>

                            <small class="text-muted">
                                Mínimo de 100 caracteres.
                            </small>

                        </div>


                        <button type="submit" class="btn btn-dark">
                            Enviar Mensagem
                        </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="text-center mt-4 mb-4">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                Voltar ao Menu Inicial
            </a>

        </div>

        <div class="footer-contactos">
            <hr>
            <p class="mb-1">
                Olive Properties - Algarve
            </p>
            <small>
                Luxury Holiday Apartments • Algarve • Portugal
            </small>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>