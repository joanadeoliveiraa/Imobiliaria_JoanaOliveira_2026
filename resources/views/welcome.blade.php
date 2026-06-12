<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olive Properties - Algarve</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .hero {
            min-height: 140vh;
            padding-bottom: 80px;
            background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.45);
        }

        .navbar-custom {
            position: relative;
            z-index: 2;
        }

        .navbar-custom a {
            color: white !important;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            top: 120px;
        }

        .hero-content h1 {
            font-size: 5rem;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .hero-content p {
            font-size: 1.4rem;
            margin-bottom: 30px;
        }

        .search-box {
            max-width: 700px;
            margin: auto;
        }


        .card {
            border-radius: 15px;
            height: 100%;
        }

        .card img {
            height: 220px;
            object-fit: cover;
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
        }

        p.card-text {
            font-size: 18px;
        }

        .card-body .btn {
            margin-top: auto;
        }

        .btn-dark {
            background-color: #2F4F4F;
            border: none;
        }

        .btn-dark:hover {
            background-color: #556B2F;
        }

        footer {
            position: relative;
            z-index: 3
        }
    </style>


</head>

<body>


    <section class="hero">

        <div class="overlay"></div>

        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">

                <div class="ms-auto">

                    <a class="me-4 text-decoration-none" href="{{ route('sobre') }}">
                        Sobre Nós
                    </a>

                    <a class="me-4 text-decoration-none" href="{{ route('clientes.index') }}">
                        Clientes
                    </a>

                    <a class="me-4 text-decoration-none" href="{{ route('apartamentos.index') }}">
                        Propriedades
                    </a>

                    <a class="me-4 text-decoration-none" href="{{ route('vendas.index') }}">
                        Vendas
                    </a>

                    <a class="text-decoration-none" href="#">
                        Contactos
                    </a>

                </div>

            </div>
        </nav>

        <div class="hero-content">

        <br><br><br><br><br><br><br><br><br>

            <h1>OLIVE PROPERTIES</h1>

            <p class="lead">
                Luxury Holiday Apartments • Algarve • Portugal
            </p>
            <br><br><br><br><br><br><br><br>

            <p>
                Descubra apartamentos turísticos exclusivos no Algarve
            </p>

            <div class="search-box">
                <!-- Barra de pesquisa -->
                <div class="input-group shadow-lg">
                    <input type="text"
                        class="form-control"
                        placeholder="Pesquisar propriedade...">

                    <button class="btn btn-dark">
                        Procurar
                    </button>
                </div>
            </div>
            <br><br><br>

            <div class="container mt-5">

                <h2 class="text-center text-white mb-4">
                    Alojamentos em Destaque
                </h2>

                <div class="row">

                    <div class="col-md-4 mb-4">
                        <div class="card shadow border-0">
                            <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227"
                                class="card-img-top"
                                alt="Apartamento">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <strong>T4 Vilamoura Golf Resort</strong>
                                </h5>
                                <br>

                                <p class="card-text">
                                    Desfrute do melhor de Vilamoura com piscina privada, vistas para o golfe e acesso rápido às praias da região.
                                </p>
                                <br>

                                <p>
                                    <strong>1.200€/semana</strong>
                                </p>

                                <a href="#" class="btn btn-dark">
                                    Ver mais informações
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Responsivo -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">

                        <div class="card shadow border-0">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
                                class="card-img-top"
                                alt="Apartamento">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <strong>T2 Olhão Marina</strong>
                                </h5>
                                <br>

                                <p class="card-text">
                                    O refúgio ideal para as suas férias, conforto, tranquilidade e acesso rápido às praias e ilhas da Ria Formosa.
                                </p>

                                <p>
                                    <strong>1.050€/semana</strong>
                                </p>

                                <a href="#" class="btn btn-dark">
                                    Ver mais informações
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">

                        <div class="card shadow border-0">
                            <img src="https://images.unsplash.com/photo-1494526585095-c41746248156"
                                class="card-img-top"
                                alt="Apartamento">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <strong>T2 Marina Vilamoura</strong>
                                </h5>
                                <br>

                                <p class="card-text">
                                    Apartamento luminoso com vista para a marina e localização privilegiada junto à praia.
                                </p>
                                <br>

                                <p>
                                    <strong>1.200€/semana</strong>
                                </p>

                                <a href="#"
                                    class="btn btn-dark">
                                    Ver mais informações
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        </div>
        </div>
    </section>


    <footer class="bg-dark text-white text-center py-4 mt-5">

        <h5><strong> Properties - Algarve</strong></h5>
        <p class="fst-italic">
            "Criamos ambientes onde nascem memórias inesquecíveis."
        </p>        

        <p>
            📍 Algarve, Portugal | 📞 +351 289 000 000 | ✉️ info@oliveproperties.pt   |    
            © 2026 Olive Properties. Projeto desenvolvido em homenagem às raízes da família Oliveira.
        </p>

    </footer>
</body>

</html>