<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Olive Properties</title>

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
    </style>


</head>

<body>


    <div class="container mt-5">

        <div class="card-topo">
            <h1 class="titulo-principal">
                Olive Properties - Algarve
            </h1>
            <p class="text-muted">
                A Nossa História
            </p>
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

            <a href="{{ url('/') }}"
                class="btn btn-outline-dark">
                Voltar ao Menu Inicial
            </a>
        </div>

    </div>
    ```

</body>

</html>