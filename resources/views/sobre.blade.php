<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Olive Properties</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .titulo-principal {
            color: #2F4F4F;
            font-weight: bold;
        }

        .card-topo {
            border-left: 5px solid #2F4F4F;
            padding-left: 15px;
            margin-bottom: 40px;
        }

        .imagem-historia {
            max-width: 900px;
            width: 100%;
            border-radius: 15px;
        }

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

        .btn-olive {
            background-color: #2F4F4F;
            color: white;
            border: none;
        }

        .btn-olive:hover {
            background-color: #3f6666;
            color: white;
        }
    </style>


</head>

<body>

    <div class="container mt-5">
        <div class="cabecalho-site mb-5">
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

        <div class="mb-5">
            <h3 class="titulo-principal mb-1">
                A Nossa História
            </h3>
            <small class="text-muted">
                Conheça a origem e os valores da Olive Properties
            </small>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p class="lead">
                    A Olive Properties nasceu de uma ligação profunda à terra,
                    às tradições e aos valores que definem a nossa identidade.
                </p>
                <br>
                <p>
                    Inspirado no apelido da família Oliveira, o nome da empresa
                    reflete as nossas raízes e o respeito pelas pessoas,
                    pela autenticidade e pela beleza única do Algarve.
                </p>
                <p>
                    Especializamo-nos na gestão de alojamentos turísticos,
                    oferecendo aos proprietários um serviço de excelência e aos
                    hóspedes experiências memoráveis em destinos cuidadosamente
                    selecionados.
                </p>
                <p>
                    Acreditamos que as melhores férias vão muito além de um lugar
                    para ficar. São momentos de descanso, descoberta e partilha
                    que se transformam em recordações para toda a vida.
                </p>
                <p>
                    Por isso, cada propriedade que gerimos é preparada com atenção
                    ao detalhe, conforto e qualidade, garantindo estadias à altura
                    das expectativas dos nossos hóspedes.
                </p>
                <p>
                    Guiados pela confiança, profissionalismo e proximidade,
                    trabalhamos diariamente para proporcionar experiências
                    autênticas que refletem o melhor da hospitalidade algarvia.
                </p>
                <p class="fst-italic fw text-center mt-4"> Não gerimos apenas propriedades.
                    Criamos ambientes onde nascem memórias inesquecíveis.
                </p>
            </div>
        </div>

        <div class="text-center mt-5 mb-5">

            <img src="{{ asset('images/familia-oliveira.jpg') }}"
                alt="Família Oliveira"
                class="img-fluid shadow imagem-historia">

        </div>

        <div class="text-center mb-5">
            <a href="{{ url('/') }}" class="btn btn-olive">
                Voltar ao Menu Inicial
            </a>
        </div>

    </div>
</body>

</html>