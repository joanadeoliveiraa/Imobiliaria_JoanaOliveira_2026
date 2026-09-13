# Olive Properties

Aplicação web para apresentação, gestão e aluguer de propriedades de luxo no Algarve.

A plataforma integra um website público, uma área reservada de administração, gestão de propriedades e clientes, sistema de reservas com pagamento simulado, dashboard de gestão, relatórios e documentos preparados para impressão ou gravação em PDF.

O projeto foi desenvolvido com foco numa experiência simples, elegante e consistente, adequada ao posicionamento de uma empresa de alojamentos turísticos de luxo.

---

## Funcionalidades

### Website público

- Página inicial com propriedades em destaque e apresentação visual das principais etapas da experiência de reserva.
- Catálogo de propriedades com pesquisa, ordenação e paginação em português.
- Filtro automático das propriedades disponíveis.
- Página individual de cada propriedade com fotografia, localização, tipologia, área, disponibilidade e preço semanal.
- Página institucional **Sobre**.
- Página de **Contactos**.
- Página de **Política de Privacidade**.
- Página de **Política de Cookies**.
- Página de **Termos e Condições**.
- Header e footer partilhados entre as diferentes páginas.
- Interface responsiva e adaptada a desktop, tablet e dispositivos móveis.
- Aviso de cookies necessários, com a preferência do utilizador guardada no navegador durante 180 dias, quando o armazenamento local está disponível.

### Área reservada / Backoffice

- Autenticação de utilizadores.
- Acesso à área de gestão restrito ao perfil `administrador`.
- Gestão de propriedades, clientes e reservas.
- Criação, consulta e edição de propriedades.
- Controlo do estado de disponibilidade das propriedades.
- Gestão dos dados dos clientes.
- Pesquisa de clientes por nome, contacto ou NIF, com pesquisa normalizada.
- Criação e acompanhamento de reservas.
- Dashboard administrativo com indicadores gerais, informação de ocupação, atividades recentes e gráficos de apoio à gestão.
- Relatórios com logótipo, título, identificação do autor e data/hora de emissão no fuso horário de Lisboa.
- Impressão ou gravação dos documentos em PDF através do navegador.
- Relatórios paginados com identificação da página e dos registos apresentados.

> Os relatórios paginados apresentam os registos da página consultada e não exportam automaticamente todas as páginas existentes.

---

## Tecnologias e requisitos

| Camada | Tecnologia |
| --- | --- |
| Aplicação | PHP 8.2 ou superior compatível com as dependências, Laravel 12 |
| Interface | Blade, Alpine.js, JavaScript, Tailwind CSS e CSS modular |
| Compilação | Vite 7, Node.js e npm |
| Dados | Eloquent ORM, migrações, MySQL ou SQLite |
| Autenticação | Laravel Breeze |
| Gráficos | Chart.js através de CDN no dashboard |
| Testes e formatação | Pest, PHPUnit e Laravel Pint |

### Requisitos principais

O projeto requer:

- PHP 8.2 ou superior compatível com as dependências;
- Composer 2;
- Node.js compatível com Vite 7;
- npm;
- MySQL ou SQLite.

Como referência, pode ser utilizada uma versão Node.js 22.12 ou superior da série 22.

Devem estar ativas as extensões PHP exigidas pelo Composer e pela base de dados utilizada, nomeadamente:

- `pdo_sqlite` para SQLite e execução dos testes;
- `pdo_mysql` para MySQL.

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

Em alternativa, criar uma base de dados MySQL e configurar no `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olive_properties
DB_USERNAME=SUBSTITUIR_PELO_UTILIZADOR
DB_PASSWORD="SUBSTITUIR_PELA_PALAVRA_PASSE"
```

Recomenda-se a utilização de codificação `utf8mb4` para garantir a correta preservação de caracteres e acentos.

---

## Inicializar a aplicação

Depois de configurar a base de dados:

```sh
php artisan config:clear
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Abrir no navegador:

```text
http://127.0.0.1:8000
```

Durante o desenvolvimento do frontend, pode executar num segundo terminal:

```sh
npm run dev
```

O servidor PHP deve permanecer em execução.

No PowerShell, caso a execução de `npm.ps1` esteja bloqueada, podem ser utilizados:

```powershell
npm.cmd ci
npm.cmd run build
npm.cmd run dev
```

> Numa instalação existente, não deve voltar a executar `php artisan key:generate`. A `APP_KEY` original deve ser preservada.

---

## Fotografias e armazenamento

Uma instalação nova não inclui automaticamente os dados ou fotografias de uma instalação anterior.

O comando:

```sh
php artisan storage:link
```

cria a ligação necessária entre o armazenamento da aplicação e a pasta pública, mas **não recupera ficheiros que estejam em falta**.

Ao transferir uma instalação existente, devem ser preservados:

- a base de dados;
- o ficheiro `.env`;
- os ficheiros existentes em `storage/app/public`.

---

## Administrador local

Para criar o administrador inicial, configurar no `.env`:

```dotenv
SEED_ADMIN_NAME="Administração local"
SEED_ADMIN_EMAIL=admin@oliveproperties.test
SEED_ADMIN_PASSWORD="SUBSTITUIR_POR_PALAVRA_PASSE_PROPRIA"
```

A palavra-passe utilizada deve ter, no mínimo, 12 caracteres.

Depois executar:

```sh
php artisan config:clear
php artisan db:seed --class=UserSeeder
```

O `UserSeeder` funciona apenas nos ambientes `local` e `testing`.

O seeder:

- não duplica contas existentes;
- não altera palavras-passe de contas já existentes;
- não promove automaticamente uma conta comum que já utilize o email configurado;
- não cria propriedades ou clientes de demonstração.

As credenciais reais devem permanecer exclusivamente no `.env` e nunca devem ser guardadas no repositório.

---

## Principais rotas

| Destino | Caminho |
| --- | --- |
| Entrada | `/login` |
| Dashboard | `/dashboard` |
| Gestão de propriedades | `/backoffice/propriedades` |
| Clientes | `/clientes` |
| Reservas | `/vendas` |
| Nova reserva | `/vendas/create` |

---

## Reservas e pagamento simulado

O fluxo de reserva permite demonstrar o processo completo desde a seleção do cliente e da propriedade até à confirmação do pagamento.

### Fluxo

1. Selecionar ou pesquisar o cliente.
2. Selecionar uma propriedade disponível.
3. Indicar as datas de entrada e saída.
4. Rever os dados e o valor total da estadia.
5. Escolher um método de pagamento de demonstração:
   - cartão;
   - MB WAY;
   - transferência.
6. Simular a aprovação ou recusa do pagamento.
7. Após aprovação, consultar a confirmação.
8. Utilizar **Imprimir / Guardar PDF** para obter o comprovativo.

Uma tentativa recusada permite realizar uma nova tentativa e não cria uma reserva.

---

## Cálculo da estadia

O servidor calcula o valor da reserva através da fórmula:

```text
preço semanal × número de noites ÷ 7
```

O resultado é arredondado aos cêntimos.

O rascunho da reserva fica associado ao administrador autenticado e à respetiva sessão durante 30 minutos.

Antes da aprovação, o sistema volta a verificar:

- o preço;
- a disponibilidade;
- os dados necessários à reserva.

A repetição do mesmo pagamento não cria reservas duplicadas.

---

## Confirmação da reserva

Após uma simulação de pagamento aprovada, o sistema:

- cria a reserva;
- guarda o registo do pagamento simulado;
- associa a operação ao utilizador responsável;
- guarda os dados necessários ao comprovativo;
- atualiza o estado de disponibilidade da propriedade.

O comprovativo conserva os detalhes existentes no momento da confirmação e pode ser novamente consultado através dos detalhes da reserva.

Sempre que a informação esteja disponível, o documento identifica:

- quem emitiu a cópia;
- quem confirmou a reserva;
- os dados da reserva;
- os dados do pagamento simulado.

Nos novos registos, o nome do utilizador que confirmou a reserva fica igualmente preservado nos dados históricos.

---

## Disponibilidade das propriedades

Na versão atual, a disponibilidade é controlada através de um **estado global da propriedade**.

Quando uma reserva é aprovada, a propriedade é marcada como indisponível.

Este modelo não corresponde ainda a um calendário de ocupação baseado em intervalos de datas.

Uma evolução futura deverá implementar disponibilidade por períodos, permitindo que uma mesma propriedade possa receber diferentes reservas desde que as respetivas datas não se sobreponham.

---

## Importante — pagamentos

**O sistema de pagamento é exclusivamente demonstrativo.**

Não existe:

- cobrança real;
- integração bancária;
- gateway de pagamento;
- processamento de cartões;
- processamento real de MB WAY;
- transferência bancária automática;
- recolha de credenciais financeiras.

Os comprovativos gerados são documentos de demonstração e **não possuem valor fiscal**.

---

## Atualizar uma instalação existente

Antes de atualizar uma instalação com dados existentes, fazer uma cópia de segurança de:

- base de dados;
- `.env`;
- `storage/app/public`.

Depois de obter a nova versão do projeto:

```sh
composer install
npm ci
php artisan migrate
npm run build
php artisan config:clear
```

### Não executar numa instalação com dados

Não utilizar:

```sh
php artisan migrate:fresh
php artisan db:wipe
```

Também não deve:

- substituir a base de dados existente;
- substituir inadvertidamente o `.env`;
- voltar a gerar a `APP_KEY`;
- executar seeders sem necessidade.

Estas operações podem provocar perda de dados ou impedir o acesso a informação anteriormente encriptada.

Não é necessário executar o seeder apenas para aplicar alterações de interface ou layout.

---

## Organização do projeto

| Pasta ou ficheiro | Responsabilidade |
| --- | --- |
| `app/Http/Controllers` | Catálogo, gestão, reservas e checkout |
| `app/Http/Requests` | Validação dos formulários |
| `app/Models` | Modelos e entidades de dados |
| `app/Support/ReservationPricing.php` | Cálculo do valor da estadia |
| `database/migrations` | Evolução da estrutura da base de dados |
| `database/seeders` | Criação configurável do administrador local |
| `resources/views` | Páginas Blade, layouts e componentes |
| `resources/css/app.css` | Entrada principal dos módulos CSS |
| `resources/css/checkout.css` | Estilos do processo de reserva e pagamento |
| `resources/css/documents.css` | Estilos dos documentos e impressão |
| `resources/css/holiday-journey.css` | Estilos da apresentação das etapas da estadia |
| `resources/js` | Interações, pesquisa, cookies e impressão |
| `routes/web.php` | Rotas públicas e administrativas |
| `tests` | Testes automatizados |

---

## Verificação do projeto

Antes da apresentação, entrega ou publicação, recomenda-se executar:

```sh
composer check-platform-reqs
composer test
npm run build
php vendor/bin/pint --test
```

A configuração definida em `phpunit.xml` utiliza SQLite em memória durante os testes.

A suite de testes foi desenvolvida para validar diferentes áreas da aplicação, incluindo:

- autenticação;
- permissões;
- catálogo;
- layouts;
- seeders;
- criação de reservas;
- recusa de pagamentos simulados;
- repetição de operações;
- expiração de rascunhos;
- alterações de preço;
- integridade geral do fluxo de reservas.

A suite completa deve ser executada antes da entrega ou publicação para confirmar que as funcionalidades continuam a comportar-se conforme esperado.

---

## Verificação manual

Além dos testes automatizados, recomenda-se validar manualmente:

1. A página inicial.
2. O catálogo de propriedades.
3. A visualização individual de uma propriedade.
4. A adaptação do website a desktop, tablet e telemóvel.
5. O login no backoffice.
6. A criação e edição de propriedades.
7. A criação e pesquisa de clientes.
8. A criação de uma reserva.
9. A simulação de pagamento aprovado.
10. A simulação de pagamento recusado.
11. A consulta do comprovativo.
12. A impressão ou gravação do comprovativo em PDF.
13. O dashboard.
14. Os relatórios.
15. As páginas legais.
16. O aviso e preferência de cookies.
17. O header, footer e navegação entre páginas.

---

## Estado e limitações

A versão atual encontra-se preparada para demonstração e utilização em ambiente local.

Antes de uma eventual publicação em produção, devem ser considerados os seguintes pontos:

- O formulário de contacto encontra-se atualmente em modo demonstrativo e ainda não efetua o envio ou armazenamento de mensagens.
- As páginas de **Política de Privacidade**, **Política de Cookies** e **Termos e Condições** devem ser revistas e preenchidas com os dados legais da entidade responsável antes da publicação.
- O processo de pagamento é exclusivamente simulado.
- Não existe integração com gateways de pagamento, entidades bancárias ou sistemas de cobrança real.
- A disponibilidade das propriedades é atualmente controlada através de um estado global.
- Uma evolução futura deverá implementar disponibilidade através de intervalos de datas e prevenção de sobreposição de reservas.
- Os indicadores financeiros apresentados no dashboard têm como base os valores registados nas reservas e não representam conciliação ou confirmação bancária.
- Os relatórios paginados não exportam automaticamente todos os registos existentes.
- O texto de direitos existente no footer deve ser preservado.
- O servidor disponibilizado através de `php artisan serve` destina-se exclusivamente ao desenvolvimento e utilização local.

---

## Publicação em produção

Este projeto encontra-se configurado para desenvolvimento local.

Uma eventual publicação em produção deverá incluir, entre outros aspetos:

- alojamento adequado a Laravel;
- raiz pública configurada para a pasta `public`;
- certificado HTTPS;
- configuração de domínio;
- base de dados de produção;
- credenciais próprias e protegidas;
- permissões adequadas de ficheiros e diretórios;
- estratégia de cópias de segurança;
- revisão das páginas legais;
- configuração de email, caso o formulário de contacto venha a ser ativado;
- revisão das configurações de cookies e analytics, caso sejam adicionados serviços adicionais.

No ambiente de produção:

```dotenv
APP_ENV=production
APP_DEBUG=false
```

A `APP_KEY` deve ser única, protegida e nunca exposta publicamente.

O `UserSeeder` destinado ao ambiente local não cria automaticamente contas administrativas em produção.

---

## Documentação complementar

O projeto inclui documentação adicional:

- [Instalação passo a passo](INSTALACAO.md)
- [Reservas com pagamento simulado](docs/reservation-checkout.md)
- [Organização do CSS e acesso local](docs/css-and-local-access.md)
- [Verificação do layout partilhado](docs/shared-layout-qa.md)
- [Verificação do footer e páginas legais](docs/footer-legal-qa.md)

Os documentos de verificação registam diferentes fases do desenvolvimento e podem, por esse motivo, referir estados ou contagens de testes anteriores.

---

## Nota final

**Olive Properties** foi desenvolvida como uma aplicação de gestão e apresentação de propriedades de luxo, reunindo numa única plataforma a experiência pública de consulta das propriedades e as principais operações internas de administração, clientes e reservas.

A arquitetura permite a evolução futura do projeto, nomeadamente através da implementação de disponibilidade por calendário, pagamentos reais, comunicação através do formulário de contacto e funcionalidades adicionais de análise e gestão.
