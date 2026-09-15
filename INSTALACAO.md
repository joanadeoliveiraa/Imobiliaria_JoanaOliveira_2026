# Instalação da Olive Properties — passo a passo

Este guia destina-se a uma instalação local. Execute os comandos na pasta que contém o ficheiro `artisan`. O pagamento é exclusivamente simulado.

## 1. Preparar os requisitos

Instale PHP 8.2 ou superior compatível com o projeto, Composer 2, Node.js compatível com Vite 7 (por exemplo Node 22.12+ da série 22) e npm. Confirme no terminal:

```sh
php --version
composer --version
node --version
npm --version
```

O PHP deve ter as extensões exigidas pelo Composer e `pdo_sqlite` para executar testes. Para a base MySQL, é necessário `pdo_mysql`. Pode consultar as extensões com `php -m` e o ficheiro de configuração com `php --ini`.

## 2. Abrir a pasta do projeto

Extraia ou clone o projeto para uma pasta local. No PowerShell, por exemplo:

```powershell
Set-Location 'C:\Laravel\Imobiliaria_JoanaOliveira_2026'
```

Adapte o caminho à sua instalação. Os passos 3 a 8 são para uma cópia nova. Para atualizar uma instalação com dados, consulte a secção 11.

## 3. Instalar as dependências

```sh
composer install
npm ci
```

Use os ficheiros de lock existentes. Não é necessário executar `composer update` ou `npm update` para instalar o projeto.

Se o PowerShell bloquear `npm.ps1`, use `npm.cmd ci` e `npm.cmd run build`.

## 4. Criar a configuração local

```sh
php -r "file_exists('.env') || copy('.env.example', '.env');"
```

Abra `.env` e configure:

```dotenv
APP_NAME="Olive Properties"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
MAIL_FROM_NAME="${APP_NAME}"
```

O `.env` contém configuração privada e não deve ser incluído em commits ou partilhado publicamente.

## 5. Escolher a base de dados

Escolha **uma** das opções seguintes.

### Opção A — SQLite

Indicada para começar sem instalar um servidor de base de dados. No `.env`:

```dotenv
DB_CONNECTION=sqlite
```

Remova ou comente um eventual `DB_DATABASE` de uma configuração MySQL anterior. Sem essa variável, a aplicação usa `database/database.sqlite`. Crie o ficheiro:

```sh
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

### Opção B — MySQL

Inicie o serviço MySQL, crie uma base vazia com codificação `utf8mb4` e atribua um utilizador com permissões sobre essa base. Preencha os valores reais no `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olive_properties
DB_USERNAME=SUBSTITUIR_PELO_UTILIZADOR
DB_PASSWORD="SUBSTITUIR_PELA_PALAVRA_PASSE"
```

O nome `olive_properties` é um exemplo de base a criar. Os comandos seguintes não criam um servidor MySQL nem as credenciais.

## 6. Inicializar a aplicação

Numa instalação nova:

```sh
php artisan config:clear
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Resultado esperado: migrações concluídas e ligação de `public/storage` para `storage/app/public`. A aplicação precisa de escrever em `storage` e `bootstrap/cache`.

Não execute `key:generate` numa instalação já existente: deve preservar a chave original.

## 7. Criar o administrador local

No `.env`, substitua a palavra-passe de exemplo por uma própria, com pelo menos 12 caracteres:

```dotenv
SEED_ADMIN_NAME="Administração local"
SEED_ADMIN_EMAIL=admin@oliveproperties.test
SEED_ADMIN_PASSWORD="SUBSTITUIR_POR_PALAVRA_PASSE_PROPRIA"
```

```sh
php artisan config:clear
php artisan db:seed --class=UserSeeder
```

O seeder funciona apenas em `local` ou `testing`. Se o administrador já existir, conserva a sua palavra-passe. Se o email pertencer a um utilizador sem perfil de administrador, o seeder não o promove.

Não são criados clientes nem propriedades de demonstração por este seeder.

## 8. Compilar e abrir o website

```sh
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Mantenha o terminal do servidor aberto:

- Website: http://127.0.0.1:8000
- Entrada: http://127.0.0.1:8000/login
- Backoffice: http://127.0.0.1:8000/dashboard

Entre com o email e a palavra-passe configurados no passo 7. Use sempre o mesmo endereço base no navegador para manter a sessão. Para parar o servidor, pressione `Ctrl+C` no seu terminal.

Durante alterações ao frontend, pode executar `npm run dev` num segundo terminal. Para utilização sem o servidor Vite, use `npm run build`.

## 9. Preparar os dados e experimentar o fluxo

1. Abra **Backoffice → Propriedades** e registe uma propriedade disponível com preço semanal e fotografia.
2. Registe um cliente com os campos pedidos.
3. Abra **Reservas → Nova reserva** e pesquise o cliente por nome, contacto ou NIF.
4. Escolha a propriedade e as datas.
5. Continue para pagamento e simule aprovação ou recusa.
6. Após aprovação, abra o comprovativo e escolha **Imprimir / Guardar PDF**.

A simulação aprovada cria uma reserva e marca a propriedade como indisponível. Não movimenta dinheiro.

Para reproduzir uma instalação existente, é necessário importar a respetiva cópia de segurança da base de dados e copiar as fotografias de `storage/app/public`. Os ficheiros Git e `storage:link` não substituem essa cópia.

## 10. Verificar a instalação

```sh
composer check-platform-reqs
composer test
npm run build
```

Os testes usam SQLite em memória, conforme `phpunit.xml`. Confirme também que consegue entrar no backoffice, abrir o catálogo e carregar as fotografias.

| Problema | Verificação |
| --- | --- |
| `could not find driver` | Ative `pdo_sqlite` ou `pdo_mysql` no PHP usado pelo terminal. |
| Ligação MySQL recusada | Confirme serviço, porta, base e credenciais do `.env`. |
| Chave da aplicação em falta | Execute o passo 6 apenas se for uma instalação nova. |
| Manifesto Vite em falta | Execute `npm ci` e `npm run build`. |
| Fotografias não aparecem | Confirme os ficheiros em `storage/app/public` e a ligação `public/storage`. |
| Falha ao criar ligação no Windows | Confirme as permissões para criar ligações simbólicas; poderá ser necessário Modo de Programador ou terminal com permissões adequadas. |
| Porta 8000 ocupada | Use outra porta em `artisan serve` e atualize `APP_URL`. |
| Configuração antiga | Execute `php artisan config:clear` após editar o `.env`. |
| Erro 419 | Reabra o formulário no mesmo endereço usado no login e confirme a configuração de sessão. |
| Acesso negado ao backoffice | Confirme que a conta tem o perfil `administrador`. |

Consulte `storage/logs/laravel.log` para detalhes de erros, sem partilhar credenciais ou dados de clientes.

## 11. Atualizar sem perder dados

Faça cópia de segurança da base, do `.env` e de `storage/app/public`. Depois de obter as alterações:

```sh
composer install
npm ci
php artisan migrate
npm run build
php artisan config:clear
```

Não execute `migrate:fresh`, `db:wipe`, não substitua a base e não regenere a `APP_KEY`. Não é necessário executar seeders para atualizar o layout.

## 12. Antes de publicar

Este guia configura desenvolvimento local. A publicação exige alojamento com a raiz web em `public`, HTTPS, `APP_ENV=production`, `APP_DEBUG=false`, credenciais próprias, permissões adequadas e cópias de segurança. O `UserSeeder` local não cria contas em produção.

Complete os campos pendentes das páginas legais. O formulário de contactos guarda pedidos; para responder por email, configure um serviço real conforme [Pedidos de contacto](docs/pedidos-contacto.md). Os pagamentos são apenas simulações. Consulte também o [README](README.md).
