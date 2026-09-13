# Olive Properties

Aplicação web para apresentação, gestão e aluguer de propriedades de luxo no Algarve.

A plataforma integra um website público, uma área reservada de administração, gestão de propriedades e clientes, sistema de reservas com pagamento simulado, dashboard de gestão, relatórios e documentos preparados para impressão ou gravação em PDF.

O projeto foi desenvolvido com foco numa experiência simples, elegante e consistente, adequada ao posicionamento de uma empresa de alojamentos turísticos de luxo.

---

## Funcionalidades

### Website público

* Página inicial com propriedades em destaque e apresentação visual das principais etapas da experiência de reserva.
* Catálogo de propriedades com pesquisa, ordenação e paginação em português.
* Filtro automático das propriedades disponíveis.
* Página individual de cada propriedade com:

  * fotografia;
  * localização;
  * tipologia;
  * área;
  * disponibilidade;
  * preço semanal.
* Página institucional **Sobre**.
* Página de **Contactos**.
* Página de **Política de Privacidade**.
* Página de **Política de Cookies**.
* Página de **Termos e Condições**.
* Header e footer partilhados entre as diferentes páginas.
* Interface responsiva e adaptada a desktop, tablet e dispositivos móveis.
* Aviso de cookies necessários, com a preferência do utilizador guardada no navegador durante 180 dias, quando o armazenamento local está disponível.

---

### Área reservada / Backoffice

* Autenticação de utilizadores.
* Acesso à área de gestão restrito ao perfil `administrador`.
* Gestão de propriedades, clientes e reservas.
* Criação, consulta e edição de propriedades.
* Controlo do estado de disponibilidade das propriedades.
* Gestão dos dados dos clientes.
* Pesquisa de clientes por nome, contacto ou NIF, com pesquisa normalizada.
* Criação e acompanhamento de reservas.
* Dashboard administrativo com:

  * indicadores gerais;
  * informação de ocupação;
  * atividades recentes;
  * gráficos de apoio à gestão.
* Relatórios com:

  * logótipo;
  * título;
  * identificação do autor;
  * data e hora de emissão no fuso horário de Lisboa.
* Impressão ou gravação dos documentos em PDF através do navegador.
* Relatórios paginados com identificação da página e dos registos apresentados.

> Os relatórios paginados apresentam os registos da página consultada e não exportam automaticamente todas as páginas existentes.

---

## Tecnologias e requisitos

| Camada              | Tecnologia                                                     |
| ------------------- | -------------------------------------------------------------- |
| Aplicação           | PHP 8.2 ou superior compatível com as dependências, Laravel 12 |
| Interface           | Blade, Alpine.js, JavaScript, Tailwind CSS e CSS modular       |
| Compilação          | Vite 7, Node.js e npm                                          |
| Dados               | Eloquent ORM, migrações, MySQL ou SQLite                       |
| Autenticação        | Laravel Breeze                                                 |
| Gráficos            | Chart.js através de CDN no dashboard                           |
| Testes e formatação | Pest, PHPUnit e Laravel Pint                                   |

### Requisitos principais

O projeto requer:

* PHP 8.2 ou superior compatível com as dependências;
* Composer 2;
* Node.js compatível com Vite 7;
* npm;
* MySQL ou SQLite.

Como referência, pode ser utilizada uma versão Node.js 22.12 ou superior da série 22.

Devem estar ativas as extensões PHP exigidas pelo Composer e pela base de dados utilizada, nomeadamente:

* `pdo_sqlite` para SQLite e execução dos testes;
* `pdo_mysql` para MySQL.

---

## Instalação local — nova cópia

Para instruções detalhadas, consulte o [guia de instalação passo a passo](INSTALACAO.md), que inclui configuração com SQLite ou MySQL e resolução dos problemas mais comuns.

Na pasta principal do projeto, onde se encontra o ficheiro `artisan`, executar:

```sh
composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
npm ci
```

### Configuração do ambiente

Editar o ficheiro `.env`:

```dotenv
APP_NAME="Olive Properties"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
```

O ficheiro `.env` contém configurações privadas da aplicação e **não deve ser incluído em commits nem partilhado publicamente**.

---

## Base de dados

O `.env.example` está preparado para permitir a utilização de SQLite por defeito.

### Opção A — SQLite

Definir:

```dotenv
DB_CONNECTION=sqlite
```

Criar o ficheiro da base de dados sem substituir um ficheiro já existente:

```sh
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

### Opção B — MySQL

Em alternativa, criar uma b
