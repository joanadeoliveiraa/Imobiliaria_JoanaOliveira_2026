# Layout comum e disponibilidade automática

## Alterações

- Um único documento HTML base, header e footer partilhados pelos ecrãs públicos, autenticação, perfil e gestão.
- Header e footer incluem os logótipos existentes; o copyright permanece literalmente igual.
- Navegação reservada para dashboard, propriedades, clientes, reservas, perfil e terminar sessão. Os utilizadores comuns não recebem links administrativos e entram diretamente no perfil.
- Estilos de clientes, reservas e dashboard centralizados em `management.css`, sem carregar Bootstrap. Chart.js mantém os gráficos existentes através do fornecedor já utilizado, jsDelivr.
- Tabelas, indicadores, atividades e campos existentes preservados. Formulários de clientes partilham um componente; erros e valores anteriores são apresentados.
- Datas de edição de reservas no formato necessário aos inputs; valores monetários admitem cêntimos. Confirmação de eliminação acessível com um diálogo nativo, sem eliminar qualquer registo durante o QA local.
- Paginação das reservas visível. Escolher disponibilidade submete automaticamente os filtros públicos e administrativos, mantendo os restantes campos e recomeçando a paginação.
- Navegação, ações e aviso de cookies ocultos na impressão.

## Dados

Antes das alterações foram guardadas contagens e assinaturas SHA-256 dos registos completos de `users`, `clientes`, `apartamentos`, `vendas` e `atividades`. A comparação final confirmou igualdade integral. Não foram executadas migrações, seeders ou operações de criação/edição/eliminação na base de dados local nesta fase. Os testes de escrita usaram a base SQLite em memória.

## Verificação

- `php artisan test --compact`: 46 testes, 236 asserções, aprovados.
- `npm.cmd run build`: aprovado.
- Edge: 14 ecrãs de gestão a 1440, 768, 375 e 320 píxeis. Um header e um footer por ecrã, footer fora do conteúdo, sem overflow horizontal da página.
- Tabelas largas continuam acessíveis com deslocamento horizontal dentro do respetivo contentor.
- Confirmados os estados Disponível e Indisponível sem clicar em Pesquisar, preservando pesquisa e ordenação. Confirmado também o filtro automático do backoffice.
- Diálogo de eliminação aberto, destino confirmado e operação cancelada, sem alterações de dados.
- Media de impressão verificado com header e footer de navegação ocultos.
- Sem exceções JavaScript nos percursos verificados.

O formulário público de contactos continua com o envio pendente, conforme já documentado; não foi configurado um serviço de email nesta fase.
