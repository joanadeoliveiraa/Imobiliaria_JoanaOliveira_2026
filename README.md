# Olive Properties

Aplicação web para apresentação, gestão e aluguer de casas de férias de luxo no Algarve. Inclui website público, backoffice, reservas com pagamento simulado e documentos imprimíveis.

## Funcionalidades

### Website público

- Página inicial com propriedades em destaque e slider dos passos de uma estadia.
- Catálogo com pesquisa, ordenação, paginação em português e filtro automático de disponibilidade.
- Detalhes das propriedades: fotografia, localização, tipologia, área, disponibilidade e preço semanal.
- Páginas Sobre, Contactos, Política de Privacidade, Política de Cookies e Termos e Condições.
- Header e footer partilhados e apresentação adaptada a desktop, tablet e telemóvel.
- Aviso de cookies necessários, com escolha guardada no navegador durante 180 dias, quando o armazenamento está disponível.

### Área reservada

- Acesso à gestão restrito ao perfil `administrador`.
- Gestão de propriedades, clientes e reservas. A edição de propriedades está disponível no backoffice.
- Pesquisa de clientes por nome, contacto ou NIF nas novas reservas, incluindo nomes sem acentos.
- Dashboard com indicadores, ocupação, atividades recentes e gráficos.
- Relatórios com logótipo, título, autor e data/hora de emissão de Lisboa.
- Impressão ou gravação em PDF pelo navegador. Os relatórios paginados identificam a página e os registos incluídos; não exportam automaticamente todas as páginas.

## Tecnologias e requisitos

| Camada | Tecnologia |
| --- | --- |
| Aplicação | PHP 8.2 ou superior compatível com as dependências, Laravel 12 |
| Interface | Blade, Alpine.js, JavaScript, Tailwind CSS e CSS modular |
| Compilação | Vite 7, Node.js e npm |
| Dados | Eloquent, migrações, MySQL ou SQLite |
| Autenticação | Laravel Breeze |
| Gráficos | Chart.js por CDN no dashboard |
| Testes e formatação | Pest, PHPUnit e Laravel Pint |

Requer Composer 2 e Node.js compatível com Vite 7 (por exemplo, Node 22.12 ou superior da série 22). Ativar as extensões PHP exigidas pelo Composer, incluindo `pdo_sqlite` para SQLite e testes, ou `pdo_mysql` para MySQL.

## Instalação local — nova cópia

Consulte o [guia de instalação passo a passo](INSTALACAO.md), com opções SQLite/MySQL e resolução de problemas.

Na pasta do projeto:

```sh
composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
npm ci
```

Editar o `.env`:

```dotenv
APP_NAME="Olive Properties"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
```

O `.env.example` usa SQLite por defeito. Criar o ficheiro sem substituir um existente:

```sh
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Em alternativa, criar uma base MySQL e configurar `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`. Usar UTF-8/`utf8mb4` para preservar os acentos.

Depois de configurar a base:

```sh
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Abrir **http://127.0.0.1:8000**. Para atualizar estilos e scripts durante o desenvolvimento, executar `npm run dev` noutro terminal, mantendo o servidor PHP a funcionar. No PowerShell, pode usar `npm.cmd` se a execução de `npm.ps1` estiver bloqueada.

Uma nova instalação não inclui a base de dados local. O seeder cria apenas o administrador; propriedades e clientes podem ser introduzidos no backoffice. Ao copiar uma instalação existente, transferir também as fotografias em `storage/app/public`: `storage:link` cria o acesso público, não recupera ficheiros em falta.

## Administrador local

Configurar no `.env` uma palavra-passe própria, com pelo menos 12 caracteres:

```dotenv
SEED_ADMIN_NAME="Administração local"
SEED_ADMIN_EMAIL=admin@oliveproperties.test
SEED_ADMIN_PASSWORD="SUBSTITUIR_POR_PALAVRA_PASSE_PROPRIA"
```

Executar:

```sh
php artisan config:clear
php artisan db:seed --class=UserSeeder
```

O `UserSeeder` funciona apenas em `local` e `testing`. Não duplica contas, não altera palavras-passe existentes e não promove uma conta comum que já use o email configurado. As credenciais reais pertencem ao `.env`, não ao repositório.

| Destino | Caminho |
| --- | --- |
| Entrada | `/login` |
| Dashboard | `/dashboard` |
| Gestão de propriedades | `/backoffice/propriedades` |
| Clientes | `/clientes` |
| Reservas | `/vendas` |
| Nova reserva | `/vendas/create` |

## Reservas e pagamento simulado

1. Selecionar cliente, propriedade disponível e datas de entrada e saída.
2. Rever o total e escolher cartão, MB WAY ou transferência de demonstração.
3. Simular aprovação ou recusa. Uma recusa permite nova tentativa e não cria uma reserva.
4. Após aprovação, abrir a confirmação e usar **Imprimir / Guardar PDF**.

O servidor calcula **preço semanal × número de noites ÷ 7**, arredondado aos cêntimos. O rascunho fica associado ao administrador e à sessão durante 30 minutos. O preço e a disponibilidade são verificados novamente antes da aprovação. Repetir o mesmo pagamento não duplica a reserva.

A aprovação cria a reserva, guarda o pagamento simulado e marca a propriedade como indisponível. O modelo atual usa um estado global por propriedade; não é um calendário de disponibilidade por intervalos de datas.

O comprovativo conserva os detalhes no momento da confirmação e pode ser reaberto nos detalhes da reserva. Identifica quem emite a cópia e quem confirmou a reserva, quando essa informação está disponível. Nos novos registos, o nome de quem confirmou fica guardado nos detalhes históricos.

**Não há cobranças reais, integração bancária nem recolha de credenciais de pagamento. Os comprovativos são documentos de demonstração, sem valor fiscal.**

## Atualizar uma instalação existente

Preservar o `.env`, a base de dados e as fotografias. Fazer cópia de segurança antes de aplicar migrações. Não voltar a gerar a `APP_KEY` de uma instalação existente.

```sh
composer install
npm ci
php artisan migrate
npm run build
```

Não usar `migrate:fresh`, `db:wipe` ou substituir a base para atualizar o projeto: essas operações eliminam dados. Não é necessário executar o seeder para aplicar alterações de interface.

## Organização do projeto

| Pasta ou ficheiro | Responsabilidade |
| --- | --- |
| `app/Http/Controllers` | Catálogo, gestão, reservas e checkout |
| `app/Http/Requests` | Validação dos formulários |
| `app/Models` | Modelos de dados |
| `app/Support/ReservationPricing.php` | Cálculo da estadia |
| `database/migrations` | Evolução da estrutura da base |
| `database/seeders` | Administrador local configurável |
| `resources/views` | Páginas Blade, layouts e componentes |
| `resources/css/app.css` | Entrada dos módulos CSS |
| `resources/css/checkout.css` | Reserva e pagamento |
| `resources/css/documents.css` | Documentos e impressão |
| `resources/css/holiday-journey.css` | Slider da estadia |
| `resources/js` | Interações, pesquisa, cookies e impressão |
| `routes/web.php` | Rotas públicas e administrativas |
| `tests` | Testes automatizados |

## Verificação

```sh
composer test
npm run build
php vendor/bin/pint --test
```

A configuração de `phpunit.xml` utiliza SQLite em memória. Os testes cobrem autenticação, permissões, catálogo, layouts, seeders e integridade das reservas, incluindo recusa, repetição, expiração e alteração de preço. A última execução completa durante o desenvolvimento terminou com **56 testes aprovados**.

## Estado e limitações

- O formulário de contactos ainda não envia emails nem guarda mensagens, apesar da resposta de sucesso existente na rota.
- As páginas legais contêm campos `[A PREENCHER]` que devem ser completados e validados antes da publicação.
- Não existe integração de pagamentos reais nem ferramentas de analytics adicionadas ao fluxo de cookies.
- Os indicadores do dashboard incluem valores de reservas registadas; não representam conciliação de pagamentos bancários.
- O texto de direitos existente no footer deve ser preservado.
- A publicação exige configuração de alojamento, HTTPS, `APP_DEBUG=false` e proteção das credenciais. O servidor de desenvolvimento destina-se a utilização local.

## Documentação complementar

- [Reservas com pagamento simulado](docs/reservation-checkout.md)
- [Organização do CSS e acesso local](docs/css-and-local-access.md)
- [Verificação do layout partilhado](docs/shared-layout-qa.md)
- [Verificação do footer e páginas legais](docs/footer-legal-qa.md)

Os documentos de verificação registam fases de desenvolvimento e podem referir contagens de testes anteriores.
