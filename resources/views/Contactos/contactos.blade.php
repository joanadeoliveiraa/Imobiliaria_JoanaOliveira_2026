<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - Olive Properties</title>


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
            margin-bottom: 30px;
        }

        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
        }

        .card-contacto {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        <div class="card-topo">
            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>

            <p class="subtitulo">
                Entre em contacto connosco
            </p>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card card-contacto p-4">
                    <h4>Informações de Contacto</h4>
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
                    <h4>Formulário de Contacto</h4>
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


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>