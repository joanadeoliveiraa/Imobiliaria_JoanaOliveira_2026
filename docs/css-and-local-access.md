# CSS e acesso local

## Organização do CSS

`resources/css/app.css` é o ponto de entrada. Os módulos são reunidos por PostCSS e compilados pelo Vite num único ficheiro CSS:

- `base.css`: cores, tipografia, variáveis e estilos base.
- `components.css`: contentores, títulos e botões comuns.
- `public.css`: header, homepage, catálogo e detalhe de propriedades.
- `admin.css`: componentes já existentes do backoffice, tabelas e formulários.
- `responsive.css`: adaptações dos componentes existentes para tablet e mobile.
- `legal.css`: páginas legais e aviso de cookies.
- `footer.css`: rodapé partilhado, com informação legal na coluna da direita.
- `pages.css`: Sobre, Contactos e área de autenticação.
- `management.css`: navegação da área reservada, clientes, reservas, dashboard, confirmações e impressão.

O header está em `resources/views/layouts/header.blade.php` e o footer em `resources/views/layouts/footer.blade.php`. A frase de direitos original foi preservada literalmente. As páginas públicas, autenticação, perfil, propriedades, clientes, reservas e dashboard partilham o layout público. Os estilos inline das páginas de gestão foram substituídos pelo CSS comum; as tabelas, indicadores e gráficos existentes foram mantidos.

O formulário de contactos mantém o destino existente; o envio de mensagens ainda não está implementado, conforme indicado na página.

## Administrador de demonstração

`DatabaseSeeder` chama `UserSeeder`. Configurar no `.env`:

```dotenv
SEED_ADMIN_NAME="Administração local"
SEED_ADMIN_EMAIL=admin@oliveproperties.test
SEED_ADMIN_PASSWORD="definir uma palavra-passe com pelo menos 12 caracteres"
```

Executar:

```sh
php artisan config:clear
php artisan db:seed --class=UserSeeder
```

- Permitido apenas em `local` ou `testing`.
- Não duplica contas nem altera palavras-passe existentes.
- Não promove um utilizador comum quando o email já existe.
- As credenciais locais reais estão no `.env`, não no repositório.
- Entrada: `http://127.0.0.1:8000/login`.
- As contas anteriores foram preservadas.

## Verificação

- 46 testes Laravel aprovados, incluindo autenticação, permissões, seeder, layout comum e preservação de registos.
- Compilação de produção aprovada.
- Sete páginas públicas verificadas no Edge a 1440, 768, 375 e 320 píxeis, sem overflow horizontal. Coluna legal à direita confirmada em desktop e footer inspecionado em desktop/mobile.
- Entrada real com o administrador local confirmada no navegador, com acesso ao dashboard e sem exceções JavaScript.
- Segunda execução do UserSeeder confirmada sem modificar a palavra-passe ou duplicar o administrador.
- A consulta de receita mensal passou de `DATE_FORMAT` para `SUBSTR` sobre a data ISO para compatibilidade entre MySQL e SQLite.
