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
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        overflow-x: hidden;
    }

    .hero {
        min-height: 100vh;
        padding-bottom: 120px;
        background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.50);
    }

    .navbar-custom {
        position: relative;
        z-index: 2;
        padding-top: 15px;
    }

    .navbar-custom a {
        color: white !important;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: 0.3s;
    }

    .navbar-custom a:hover {
        opacity: 0.8;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        padding-top: 120px;
    }

    .hero-content h1 {
        font-size: 5rem;
        font-weight: 700;
        letter-spacing: 4px;
        margin-bottom: 15px;
    }

    .hero-content .lead {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .hero-content p {
        font-size: 1.2rem;
    }

    .search-box {
        max-width: 800px;
        margin: 0 auto;
    }

    .search-box .input-group {
        overflow: hidden;
        border-radius: 10px;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 250px;
        width: 100%;
        object-fit: cover;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        padding: 25px;
    }

    .card-title {
        color: #2F4F4F;
        font-weight: bold;
    }

    .card-text {
        font-size: 17px;
        flex-grow: 1;
    }

    .btn-dark {
        background-color: #2F4F4F;
        border: none;
    }

    .btn-dark:hover {
        background-color: #3d6666;
    }

    .btn-dark,
    .btn-outline-light {
        border-radius: 8px;
    }

    footer {
        position: relative;
        z-index: 3;
        background-color: #1f2933;
    }

    /* Tablets */
    @media (max-width: 992px) {
        .hero-content h1 {
            font-size: 3.5rem;
        }
        .hero-content .lead {
            font-size: 1.2rem;
        }
    }

    /* Telemóveis */
    @media (max-width: 768px) {
        .hero {
            background-attachment: scroll;
        }
        .hero-content {
            padding-top: 80px;
        }
        .hero-content h1 {
            font-size: 2.5rem;
            letter-spacing: 2px;
        }
        .hero-content p {
            font-size: 1rem;
        }
        .search-box {
            padding: 0 15px;
        }
        .card-img-top {
            height: 220px;
        }
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

                    <a class="text-decoration-none" href="{{ route('contactos') }}">
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

            <!-- Barra de pesquisa -->
            <div class="search-box">
            <form action="{{ route('apartamentos.index') }}" method="GET">

                <div class="input-group shadow-lg">

                    <input type="text"
                        name="pesquisa"
                        class="form-control"
                        placeholder="Pesquisar referência, tipologia ou localização">

                    <button type="submit"
                        class="btn btn-dark">
                        Procurar
                    </button>

                </div>

            </form>
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
            📍 Algarve, Portugal | 📞 +351 289 000 000 | ✉️ info@oliveproperties.pt |
            © 2026 Olive Properties. Projeto desenvolvido em homenagem às raízes da família Oliveira.
        </p>

    </footer>
</body>

</html>