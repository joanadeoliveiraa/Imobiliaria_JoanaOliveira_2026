# Auditoria geral — 12/11/2026

## A. Estado geral

A aplicação tem uma arquitetura Laravel convencional e adequada à dimensão atual: controllers separados por percurso, Form Requests para validação, relações Eloquent, serviços de dashboard, componentes Blade partilhados e assets modulares. A separação funcional entre administrador e cliente está implementada com middleware e verificações de titularidade.

Pontos fortes:

- preço, disponibilidade e proprietário da reserva determinados no servidor;
- checkout idempotente e protegido contra sobreposição;
- pagamentos sem dados bancários e claramente identificados como simulados;
- rotas administrativas e pessoais separadas;
- contactos com limitação de pedidos, validação e escaping;
- testes de manipulação de IDs, preço, cliente e links de notificações;
- documentos imprimíveis sem exposição pública;
- suite automatizada abrangente.

Fragilidades principais:

- cancelamento administrativo destrutivo;
- identificação pelo nome em fluxos legados de clientes e reservas;
- divergência possível entre edição da reserva e snapshot do pagamento;
- políticas comerciais ainda não formalizadas;
- dependências PHP com avisos conhecidos que exigem atualização dedicada.

## B. Limpeza e correções efetuadas

- Removida uma cópia completa, antiga, limpa e não versionada do repositório que existia dentro da pasta principal.
- Removidos imports sem utilização e normalizados comentários técnicos em português.
- Aplicado Laravel Pint ao código PHP do projeto principal.
- Reduzido o conteúdo sensível dos logs de falhas de email.
- Reforçada a validação de destinos internos das notificações.
- Corrigidas FAQs que prometiam estados, prazos, reembolsos, horários, equipamentos e serviços inexistentes.
- Mantidas migrations históricas, dados de negócio, exports privados e configurações locais.
- Não foram removidas dependências apenas por ausência de correspondência textual.

## C. Problemas identificados

### Correções necessárias

| Problema | Impacto | Estado |
| --- | --- | --- |
| Cancelamento elimina reserva e pagamento | Perda de histórico e auditoria | Pendente de decisão funcional |
| Fluxos legados usam nome do cliente | Homónimos podem produzir associação ambígua | Pendente de migração controlada |
| Snapshot do pagamento após edição | Documento histórico pode divergir da reserva editada | Pendente de regra funcional |
| Avisos de dependências PHP | Risco de segurança e manutenção | Atualização dedicada recomendada |

### Segurança

- Passwords usam hashing nativo; login regenera sessão e tem limitação de tentativas.
- OAuth Google valida estado, email verificado e não associa contas apenas por coincidência de email.
- As rotas de administrador usam auth/admin; as de cliente usam auth/client.
- Reservas, comprovativos e mensagens pessoais validam titularidade no backend.
- Formulários usam CSRF e validação no servidor.
- Uploads de propriedades estão limitados a formatos de imagem e tamanho, em rotas administrativas.
- Não foram encontrados segredos nos ficheiros alterados. Esta verificação não substitui auditoria completa do histórico Git.

### Desempenho

- Listagens principais usam paginação.
- Dashboard limita rankings e listas recentes e concentra agregações num serviço.
- Relações necessárias são carregadas nos percursos principais da área de cliente.
- A página inicial da área do cliente carrega todas as reservas da conta para calcular os cartões; é aceitável no volume atual, mas deverá passar a agregações na base de dados se o volume crescer.
- Chart.js continua a ser um recurso externo carregado apenas no dashboard.

### Interface e acessibilidade

- FAQs são renderizadas no servidor e permanecem legíveis sem JavaScript.
- Separadores suportam teclado; accordions usam elementos nativos.
- Tema claro/escuro, formulários, comprovativos e páginas de cliente partilham a identidade visual.
- Não foi realizada auditoria manual com leitor de ecrã nem validação completa em Safari.

## D. Melhorias recomendadas

Estas propostas não foram implementadas e aguardam aprovação.

| Categoria | Melhoria | Necessidade e solução | Benefício | Prioridade | Complexidade | Módulos |
| --- | --- | --- | --- | --- | --- | --- |
| Correção | Cancelamento com estado e arquivo | Substituir eliminação por estado, data, autor e motivo | Preserva histórico e documentos | Alta | Média | Venda, pagamento, controllers, migrations |
| Correção | Cliente identificado apenas por ID | Migrar consultas e registos legados de nome para cliente_id | Evita conflitos entre homónimos | Alta | Alta | Cliente, Venda, relatórios, migrations |
| Correção | Versão do comprovativo | Definir se uma edição gera nova versão ou mantém o documento original | Coerência documental | Alta | Média | Reserva, pagamento, comprovativos |
| Técnica | Atualização de dependências | Atualizar Composer/npm em ramo dedicado e rever avisos um a um | Segurança e suporte | Alta | Média | composer.lock, package-lock.json |
| Técnica | Processamento assíncrono de email | Colocar emails numa fila com tentativas e monitorização | Menor latência e mais resiliência | Média | Média | Mail, jobs, queue |
| Técnica | Agregações da área do cliente | Calcular contagens e próxima reserva na base de dados | Escala melhor com histórico longo | Média | Baixa | ClientAreaController |
| Interface | Pedido de alteração/cancelamento contextual | Formulário próprio ligado à reserva, sem executar cancelamento automático | Percurso mais claro | Média | Média | Cliente, contactos |
| Interface | Calendário de disponibilidade | Vista mensal administrativa baseada em intervalos reais | Gestão mais rápida | Média | Média | Reservas, dashboard |
| Nova função | Exportação iCalendar | Rota protegida para ficheiro ICS de reserva própria | Compatibilidade com Outlook/Apple | Baixa | Baixa | Cliente, calendário |
| Nova função | Arquivo documental versionado | Guardar versões imutáveis dos documentos emitidos | Auditoria e rastreabilidade | Baixa | Alta | Storage, models, migrations |

Ordem sugerida: conservação de cancelamentos; migração para cliente_id; regra de versionamento; atualização de dependências; filas de email; restantes melhorias.

## E. Validação

Executado:

- suite PHP completa;
- teste JavaScript dos separadores de FAQs;
- build Vite;
- Laravel Pint;
- listagem das rotas;
- estado das migrations;
- requisitos da plataforma Composer;
- npm audit para dependências de produção;
- verificação de whitespace pelo Git.

Resultado final:

- 106 testes PHP aprovados, com 857 asserções;
- 1 teste JavaScript aprovado;
- build Vite concluído;
- Laravel Pint sem alterações pendentes;
- todas as migrations da base MySQL local aplicadas;
- zero reservas com referência órfã de cliente, zero pagamentos órfãos e zero contactos associados a utilizadores inexistentes;
- npm sem vulnerabilidades nas dependências de produção; a árvore completa de desenvolvimento reportou 10 entradas;
- Composer reportou 37 avisos que afetam 10 pacotes do lockfile.

Limitações da auditoria:

- o Composer não conseguiu atualizar a base remota de avisos nesta execução por indisponibilidade de rede;
- não foram feitos pagamentos reais, pois não existem;
- não foi efetuado teste manual com leitor de ecrã;
- não foi efetuado teste cruzado completo em Safari e Firefox;
- regras comerciais das FAQs continuam a exigir validação da entidade responsável quando forem definidas.
