# FAQs, Contactos e auditoria técnica — 11/11/2026

## Resultado e âmbito

Criada a página pública `/faqs`, com 34 perguntas em oito categorias, separadores acessíveis, accordions nativos e ligações a Contactos. O formulário tem uma secção de acesso às FAQs antes dos campos. Cada resposta permite iniciar um contacto com um assunto válido pré-selecionado. O contexto de uma reserva tem prioridade sobre o assunto recebido pelo URL.

Arquitetura reutilizada: Laravel 12, Eloquent, Blade, Alpine, Tailwind/CSS e Vite. O conteúdo está em `config/faqs.php`, é renderizado pelo servidor e permanece disponível sem JavaScript. Não foi criada uma tabela de FAQs nem uma segunda rota equivalente. Não foram executadas migrations nem alterados utilizadores ou outros dados de negócio.

## Ficheiros criados

- `config/faqs.php`: conteúdo em português de Portugal e associação de categorias aos assuntos permitidos.
- `resources/views/faqs.blade.php`: página, categorias, perguntas e ligações.
- `resources/css/faqs.css`: estilos responsivos que reutilizam as variáveis do tema claro/escuro.
- `resources/js/faq-tabs.js`: gestão dos separadores com setas, Home e End.
- `tests/Feature/FaqTest.php`: conteúdo, acesso público/autenticado, ligações e validação de assuntos no URL.
- `tests/faq-tabs.test.mjs`: navegação por teclado e gestão do foco.
- Este relatório.

## Ficheiros modificados

- `routes/web.php`: rota pública nomeada `faqs`.
- `app/Http/Controllers/ContactoController.php`: validação por lista permitida do assunto no URL; valores desconhecidos ou arrays são ignorados sem refletir conteúdo arbitrário.
- `resources/views/Contactos/contactos.blade.php`: secção antes do formulário e assunto inicial.
- `resources/views/layouts/footer.blade.php`: acesso público às FAQs.
- `resources/css/app.css` e `resources/js/app.js`: integração dos novos módulos.
- `app/Http/Controllers/PedidoContactoController.php` e `ReservaCheckoutController.php`: logs de falhas de email passam a guardar apenas o identificador e a classe da exceção, sem mensagem técnica ou objeto completo.
- `tests/Feature/ContactRequestsTest.php` e `ClientAreaTest.php`: verificação do contexto limitado dos logs de erro.
- `ApartamentoController.php`: removidos os imports não utilizados de `Atividade` e `Cliente`.
- `Auth/RegisteredUserController.php`: removido o import não utilizado de `ValidationException`.
- Comentários em português normalizados em `User.php`, `ClientAccount.php`, `UserSeeder.php`, `Auth/LoginRequest.php`, `ProfileUpdateRequest.php`, nos controllers de autenticação `GoogleAuthController`, `RegisteredUserController`, `NewPasswordController` e `PasswordResetLinkController`, em `ReservaCheckoutController.php` e em `resources/js/documents.js`. Anotações de tipos e contratos foram preservadas.

## Revisão e segurança

| Área | Verificação e resultado |
| --- | --- |
| Autenticação | bcrypt, regeneração da sessão no login, limite de tentativas, proteção do estado OAuth e recusa da associação Google apenas por email. |
| Admin/Cliente | Rotas de gestão protegidas por `auth` e `admin`; área pessoal por `auth` e `client`. Não existem classes Policy próprias; a autorização atual é feita por middleware e verificações explícitas de titularidade. |
| Reservas | Datas validadas, preço calculado no servidor, rascunhos associados ao utilizador e com validade limitada, verificação de sobreposição e bloqueio da propriedade na confirmação. |
| Pagamentos | Apenas simulação. Não foi introduzida integração bancária nem alterada a lógica ou os registos de pagamento. |
| Documentos | Comprovativos HTML protegidos pela titularidade da reserva e impressão/Guardar PDF através do navegador. Não existe download de PDF gerado pelo servidor nem arquivo fiscal privado nesta versão. |
| Contactos | Select validado no servidor, especificação condicional de Outros assuntos, CSRF, limitação de pedidos e associação apenas a reservas pertencentes ao cliente. Envio de respostas preservado. |
| Uploads | Fotografias limitadas a imagens JPG/JPEG/PNG/WebP até 5 MB, em rotas administrativas; armazenamento público apropriado a fotografias de imóveis. |
| Views | Respostas das FAQs e assuntos apresentados com escaping Blade. Nenhum HTML proveniente do URL é introduzido no conteúdo. |
| Base de dados | Consulta de integridade às chaves estrangeiras sem referências órfãs; duas contas mantidas. Testes utilizam SQLite em memória, sem limpar a base MySQL local. |
| Segredos | A comparação dos segredos atualmente configurados com os ficheiros versionados não encontrou correspondências. Isto não equivale a uma auditoria de todo o histórico Git ou a uma garantia de ausência de outros segredos. `.env`, exports SQL e backups privados são ignorados pelo Git. |
| Erros | Reduzido o contexto dos logs de falhas de email. Os erros continuam a ser comunicados ao utilizador e os estados existentes são preservados. |

## Dependências: atualização prioritária pendente

Foram consultados os serviços de auditoria através de `composer audit --locked --format=json` e `npm audit --json`, em 11/11/2026. A existência de um aviso num pacote não demonstra, por si só, exploração na aplicação; exige avaliar o caminho de execução afetado.

Composer reportou **37 avisos em 10 pacotes**:

| Pacote | Avisos |
| --- | ---: |
| guzzlehttp/guzzle | 9 |
| guzzlehttp/psr7 | 2 |
| laravel/framework | 3 |
| league/commonmark | 12 |
| league/flysystem | 1 |
| symfony/http-foundation | 5 |
| symfony/http-kernel | 1 |
| symfony/mime | 1 |
| symfony/routing | 1 |
| symfony/yaml | 2 |

Existe um aviso crítico relativo ao TokenGuard do Laravel. A aplicação utiliza autenticação web por sessão; não foi identificada uma rota API que use TokenGuard. Ainda assim, a atualização dos pacotes afetados deve ser priorizada.

O npm reportou **10 entradas de vulnerabilidade: 1 crítica, 6 altas, 2 moderadas e 1 baixa**, na árvore das ferramentas de frontend/desenvolvimento. Entre os pacotes estão `shell-quote`, `vite`, `concurrently`, `browserslist`, `esbuild`, `nanoid` e `source-map-js`. O aviso crítico em `shell-quote` merece atenção no ambiente Windows.

Resultados completos guardados localmente em `storage/app/private/composer-audit.json` e `storage/app/private/npm-audit.json`, fora do Git. Não foram executados `audit fix`, atualizações de versões principais ou alterações aos lockfiles. Recomenda-se uma intervenção dedicada de atualização compatível, com revisão dos avisos e repetição de todos os testes. A aplicação não deve ser considerada pronta para produção apenas por passar os testes funcionais.

## Problemas e limitações identificados

1. **Cancelamento administrativo destrutivo:** `VendaController::destroy` elimina a reserva e a relação com o pagamento tem eliminação em cascata. Deve ser definida uma política de conservação antes de substituir esta lógica por estados/arquivo. Não foi executado qualquer cancelamento nem alterada esta regra.
2. **Identificação por nome em fluxos antigos:** `ClienteController::update`, `historicoCliente` e alguns scopes ainda usam o nome do cliente. Clientes homónimos podem afetar a atualização ou agregação de reservas. A migração para `cliente_id` deve tratar explicitamente os registos legados e ter testes próprios; nenhuma associação foi reescrita nesta intervenção.
3. **Email local:** o transporte atual é `log`. A recuperação de palavra-passe pode escrever o link de recuperação no log; configurar um capturador local ou SMTP apropriado antes de testes com dados sensíveis. A confirmação por email não deve ser prometida quando o transporte não está configurado.
4. **Debug local:** `APP_DEBUG` está ativo em ambiente `local`. Deve ser desativado no ambiente de produção.
5. **Edição de reservas e pagamento:** a edição administrativa pode recalcular o valor da reserva sem reescrever o snapshot original da simulação. É necessário definir como apresentar alterações e documentos históricos antes de uma evolução para pagamentos reais.
6. **Uploads e transações:** os ficheiros não participam na transação SQL. Uma falha depois do armazenamento da fotografia pode deixar um ficheiro sem referência; prever compensação numa alteração específica.
7. **Concorrência de perfis:** `ClientAccount::for` usa uma relação única, mas não trata explicitamente a criação simultânea do primeiro perfil por dois pedidos. A restrição da base de dados impede duplicados, mas um pedido concorrente pode falhar.
8. **Inventário conservador:** CSS, JavaScript, views e dependências não foram removidos com base apenas na ausência de correspondências textuais, pois há classes e componentes dinâmicos. Logs locais, backups e migrations históricas foram preservados. A cópia completa e antiga do repositório, limpa e não versionada, foi removida posteriormente durante a auditoria geral. O commit de referência anterior ao trabalho é `d9ea31e`.

## Validação

- Suite PHP: **105 testes aprovados / 843 verificações** após a implementação das FAQs. Depois de acrescentar as duas expectativas específicas sobre logs, a execução final dos testes de contactos e Área de Cliente passou com **15 testes / 165 verificações**.
- JavaScript: **5 testes aprovados**, incluindo setas/Home/End, foco, cookies e pesquisa de clientes.
- `npm run build`: concluído, assets locais atualizados.
- Edge headless com Playwright: navegação FAQs → Contactos → FAQs, CTA geral, pré-seleção de assunto, campo Outros assuntos, teclado e accordions verificados a **1440, 768 e 390 px**, sem transbordo horizontal.
- Tema escuro verificado; sem erros JavaScript; com JavaScript desativado, as oito categorias e 34 respostas continuam presentes e visíveis.
- Capturas inspecionadas em desktop e mobile; evidências locais em `storage/app/private/browser-qa/`, ignoradas pelo Git. A ferramenta de navegador foi instalada apenas nessa pasta, sem alterar os manifests do projeto.
- Rotas `/faqs` e `/contactos` verificadas sem duplicação da rota FAQ. `git diff --check` sem erros.
- Não foi feita uma auditoria manual com leitores de ecrã nem validação em Safari/Firefox. Não foram testadas cobranças reais, pois não existem.

## Conteúdos pendentes de validação comercial

Confirmar por alojamento: horários de entrada/saída, entrega de chaves, capacidade, animais, festas, visitas, silêncio, roupa de cama, toalhas, equipamentos, internet, limpeza e estacionamento. Confirmar também prazos de pagamento, faturação, alterações, cancelamentos, encargos, reembolsos, assistência e objetos esquecidos.

As respostas usam linguagem neutra e remetem para a equipa quando não existe uma regra no projeto. Não foram inventados horários, preços, taxas, garantias de serviço ou políticas de reembolso.
