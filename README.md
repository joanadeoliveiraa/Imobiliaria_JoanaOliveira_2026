# Olive Properties

Aplicação Laravel para apresentação e gestão demonstrativa de propriedades e estadias no Algarve. Inclui website público, backoffice administrativo e área privada de cliente.

O pagamento é **exclusivamente simulado**. A aplicação não processa cobranças, não integra gateways bancários e não recolhe dados financeiros. Os comprovativos não têm valor fiscal.

## Funcionalidades

### Website público

- Página inicial, página institucional e catálogo pesquisável de propriedades.
- Formulário de contacto com assuntos validados, limitação de pedidos e confirmação da Política de Privacidade.
- Página de FAQs com oito categorias, acessível mesmo sem JavaScript.
- Políticas de Privacidade e Cookies e Termos e Condições.
- Interface responsiva e aviso de cookies estritamente necessários.

### Área de cliente

- Registo, autenticação, recuperação de palavra-passe e entrada opcional com Google.
- Perfil explicitamente associado à conta.
- Resumo pessoal, reservas e mensagens próprias.
- Criação de reserva sem permitir selecionar ou manipular outro cliente.
- Checkout com resumo, verificação de disponibilidade e pagamento simulado.
- Confirmação por email quando existe transporte real configurado.
- Comprovativo preparado para impressão.
- Ligação para adicionar uma estadia futura confirmada ao Google Calendar, sem OAuth adicional.
- Consulta dos próprios pedidos de contacto e respostas.

O cliente não pode aceder ao dashboard, gerir propriedades ou clientes, consultar dados de terceiros, ler notas internas ou alterar o seu perfil de autorização. A titularidade é validada no servidor.

### Backoffice administrativo

- Dashboard com indicadores, filtros, gráficos, rankings e relatório imprimível.
- Gestão de propriedades, fotografias, clientes e reservas.
- Checkout administrativo com cálculo no servidor e simulação de aprovação ou recusa.
- Consulta do pagamento simulado e comprovativo.
- Gestão de pedidos de contacto, estados, notas internas, arquivo e respostas por email.
- Notificações persistentes para eventos relevantes.

### Reservas e documentos

O servidor calcula o valor por preço semanal × número de noites ÷ 7. Antes da confirmação, volta a validar preço, datas, propriedade, cliente e sobreposição de reservas. O rascunho expira após 30 minutos e fica associado ao utilizador e à sessão. Repetir o mesmo pedido não cria uma segunda reserva ou pagamento.

Os métodos Cartão, MB WAY e Transferência são apenas simulações. Uma recusa não cria a reserva. O comprovativo declara o seu caráter demonstrativo.

## Perfis e permissões

| Funcionalidade | Administrador | Cliente |
| --- | :---: | :---: |
| Dashboard e relatório | Sim | Não |
| Gerir propriedades e clientes | Sim | Não |
| Gerir todas as reservas | Sim | Não |
| Criar e ver reserva própria | Acesso de gestão | Sim |
| Ver reservas de terceiros | Sim | Não |
| Gerir contactos e notas internas | Sim | Não |
| Ver mensagens próprias | Acesso de gestão | Sim |
| Editar o próprio perfil | Sim | Sim |

As rotas administrativas usam os middleware auth e admin; as rotas pessoais usam auth e client, além de validação explícita de titularidade.

## Tecnologias e requisitos

| Camada | Tecnologia |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 e Eloquent |
| Autenticação | Laravel Breeze e Socialite |
| Frontend | Blade, Alpine.js, JavaScript e CSS modular |
| Assets | Vite 7, Node.js e npm |
| Dados | MySQL ou SQLite |
| Gráficos | Chart.js 4 através de jsDelivr |
| Testes | Pest/PHPUnit e Node Test Runner |
| Formatação | Laravel Pint |

Requer PHP 8.2 ou superior, Composer 2, Node.js compatível com Vite 7, npm e PDO para a base de dados escolhida.

## Instalação

Consulte também [INSTALACAO.md](INSTALACAO.md).

    composer install
    php -r "file_exists('.env') || copy('.env.example', '.env');"
    npm ci
    php artisan key:generate

Numa instalação existente, preserve o .env, a APP_KEY, a base de dados e storage/app/public. Não volte a executar key:generate.

### Base de dados

Para SQLite:

    DB_CONNECTION=sqlite

    php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
    php artisan migrate

Para MySQL, crie uma base de dados com utf8mb4 e configure valores próprios:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=olive_properties
    DB_USERNAME=UTILIZADOR_LOCAL
    DB_PASSWORD="PALAVRA_PASSE_LOCAL"

Depois:

    php artisan config:clear
    php artisan migrate
    php artisan storage:link
    npm run build
    php artisan serve --host=127.0.0.1 --port=8000

Nunca use migrate:fresh ou db:wipe numa instalação com dados a conservar. O .env contém informação privada e não deve ser versionado.

## Email

Por defeito, MAIL_MAILER=log não entrega mensagens. Para enviar recuperações de palavra-passe, respostas a contactos e confirmações de reserva, configure um transporte real no .env. Uma falha no envio da confirmação não elimina a reserva.

## Entrada com Google

Configuração opcional:

    GOOGLE_CLIENT_ID=
    GOOGLE_CLIENT_SECRET=
    GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback

O URI deve coincidir com o configurado no Google Cloud. Consulte [docs/google-login.md](docs/google-login.md). Contas administrativas continuam a entrar com email e palavra-passe.

O botão **Adicionar ao Google Calendar** é independente deste login: abre um evento pré-preenchido e deixa ao utilizador a decisão de o guardar.

## Seeders

Administrador local:

    SEED_ADMIN_NAME="Administração local"
    SEED_ADMIN_EMAIL=admin@oliveproperties.test
    SEED_ADMIN_PASSWORD="DEFINIR_NO_AMBIENTE"

    php artisan config:clear
    php artisan db:seed --class=UserSeeder

A palavra-passe deve ter pelo menos 12 caracteres.

Cliente demonstrativo:

    SEED_CLIENT_PASSWORD="DEFINIR_NO_AMBIENTE"

    php artisan config:clear
    php artisan db:seed --class=ClientDemoSeeder

A palavra-passe deve ter pelo menos 16 caracteres. Os seeders destinam-se apenas a local e testing, são idempotentes e preservam credenciais e perfis existentes. DatabaseSeeder executa apenas UserSeeder.

## Rotas principais

| Área | Caminho |
| --- | --- |
| Catálogo | /apartamentos |
| FAQs | /faqs |
| Contactos | /contactos |
| Login / registo | /login, /register |
| Área de cliente | /minha-area |
| Reservas do cliente | /minha-area/reservas |
| Nova reserva do cliente | /minha-area/nova-reserva |
| Dashboard administrativo | /dashboard |
| Propriedades | /backoffice/propriedades |
| Clientes | /clientes |
| Reservas administrativas | /vendas |
| Pedidos de contacto | /backoffice/contactos |

## Atualizar uma instalação existente

Faça cópias de segurança da base de dados, do .env e de storage/app/public. Depois:

    composer install
    npm ci
    php artisan migrate
    php artisan config:clear
    npm run build

Preserve as migrations históricas, a base de dados e a APP_KEY.

## Testes e qualidade

    composer check-platform-reqs
    composer test
    node --test tests/faq-tabs.test.mjs
    npm run build
    php vendor/bin/pint --test

Os testes PHP usam SQLite em memória e não apagam a base MySQL local. A suite cobre autenticação, OAuth, autorização, catálogo, dashboard, contactos, FAQs, reservas, manipulação de preço e cliente, idempotência, email, comprovativos e Google Calendar.

O package.json não define npm test; o teste JavaScript existente usa diretamente o Node Test Runner.

## Organização

| Local | Responsabilidade |
| --- | --- |
| app/Http/Controllers | Percursos públicos, administrativos e do cliente |
| app/Http/Requests | Autorização e validação |
| app/Models | Entidades e relações Eloquent |
| app/Services | Consultas e agregações do dashboard |
| app/Support | Preços, contas, contactos e calendário |
| database/migrations | Evolução não destrutiva da estrutura |
| database/seeders | Contas locais configuradas pelo ambiente |
| resources/views | Blade, emails e documentos |
| resources/css e resources/js | Estilos e interações |
| tests | Testes PHP e JavaScript |

## Limitações conhecidas

- O cancelamento administrativo elimina a reserva e o pagamento associado; antes de produção deve ser definida uma política de conservação e arquivo.
- Fluxos legados ainda identificam clientes pelo nome. Clientes homónimos exigem uma migração controlada para uso exclusivo de cliente_id.
- A edição administrativa pode recalcular a reserva sem atualizar o snapshot original do pagamento simulado.
- Não existe pagamento real, faturação, reembolso bancário ou integração contabilística.
- O cliente solicita alterações ou cancelamentos através de Contactos.
- Horários, regras de estadia, equipamentos e políticas comerciais devem ser confirmados pela entidade responsável.
- Chart.js é carregado externamente através de jsDelivr.

## Documentação adicional

- [Instalação](INSTALACAO.md)
- [Login com Google](docs/google-login.md)
- [Cliente demonstrativo](docs/cliente-demonstracao.md)
- [Checkout](docs/reservation-checkout.md)
- [Pedidos de contacto](docs/pedidos-contacto.md)
- [Auditoria do dashboard](docs/AUDITORIA_DASHBOARD.md)
- [Auditoria de FAQs e contactos](docs/auditoria-faqs-contactos-2026-11-11.md)

## Produção

Antes de publicar, configure HTTPS, APP_ENV=production, APP_DEBUG=false, cookies seguros, base de dados e email próprios, cópias de segurança, monitorização, permissões do sistema de ficheiros e raiz web em public.

As páginas legais e regras comerciais devem ser revistas pela entidade responsável. Nunca versione .env, bases de dados, exports SQL, backups, tokens ou palavras-passe.
