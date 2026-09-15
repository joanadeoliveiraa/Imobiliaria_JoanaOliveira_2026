# Auditoria e reestruturação do dashboard

## Diagnóstico anterior às alterações — 13/09/2026

- Dashboard implementado no `ApartamentoController`; relatório era a impressão da mesma Blade, com blocos repetidos de receita e gráficos dependentes de CDN.
- `leftJoin` de propriedades com todas as vendas repetia cada imóvel por reserva histórica. O estado estático `Nao Disponivel` era apresentado incorretamente como ocupado.
- A próxima reserva era a primeira de todo o histórico, sem filtro de datas. A receita somava todos os registos, incluindo estadias futuras e duplicados.
- Base local: 15 propriedades, 35 reservas, 4 grupos de duplicados exatos, 2 grupos de clientes com nomes repetidos; nenhuma reserva com datas invertidas/valor negativo e nenhuma referência órfã. Consulta de ocupação por datas: 0 propriedades ocupadas na data da auditoria. Estado estático: 9 indisponíveis, das quais 7 com histórico de reservas.
- Reservas em `vendas`: cliente por nome e propriedade por referência, sem chaves estrangeiras nem estado de reserva. Cancelar elimina a venda. Rascunhos pendentes ficam na sessão; pagamentos aprovados são apenas simulações. Não existe prova de recebimento real.
- Checkout alterava o estado global da propriedade ao reservar datas futuras e não verificava sobreposição por datas. Cancelamento podia apagar uma indisponibilidade administrativa.
- Ausência de relações de domínio, indicadores operacionais limitados, listagens sem limites no dashboard, pouca informação acessível nos gráficos, ausência de estados vazios em alguns blocos.
- A proteção `auth` + `admin` já existe e deve ser preservada. O backoffice já tem componentes, cores, tipografia e estilos de impressão reutilizáveis.

## Decisões

- Não corrigir automaticamente dados históricos ambíguos nem eliminar registos. A flag antiga de indisponibilidade pode representar manutenção ou uma reserva; preservar e sinalizar para revisão.
- Deduplicar indicadores por cliente, propriedade, entrada, saída e valor, conservando o menor ID como registo representativo. Manter todos os registos nas páginas administrativas para revisão.
- Cliente por nome não permite distinguir homónimos: excluir nomes ambíguos do ranking individual e apresentar alerta. A migração para IDs de cliente deve ser um trabalho de dados separado, com identificação humana dos registos.
- Não inventar estados de pagamento, cancelamentos históricos nem receitas efetivamente recebidas.

## Implementação e validação — 15/09/2026

- O dashboard usa um serviço próprio com período selecionável, ocupação por datas, taxa de ocupação, entradas e saídas próximas, rankings limitados e alertas de qualidade de dados.
- O relatório tem uma página de impressão separada com a ocupação de todas as propriedades. Os valores são apresentados como valores de reservas com entrada no período, sem alegar recebimentos reais.
- Os indicadores excluem duplicados exatos e reservas com datas, valores ou referências inválidas; os registos originais permanecem acessíveis na gestão.
- A confirmação de uma reserva deixa de alterar a flag administrativa de disponibilidade; o checkout e a edição verificam sobreposição de datas, e o cancelamento não altera essa flag.
- Testes de dashboard e checkout cobrem ocupação, duplicados e manutenção do estado administrativo. A identificação estável de clientes e a revisão dos dados históricos ambíguos continuam a exigir trabalho de dados separado.

## Reformulação visual e funcional — 15/09/2026

- Os filtros incluem mês anterior e intervalo personalizado até 12 meses; os totais, rankings e relatório usam as mesmas datas de entrada de reserva. A comparação usa um intervalo anterior com igual número de dias e omite percentagens quando o valor anterior é zero.
- A página apresenta atalhos para rotas administrativas reais, oito KPIs, painel de alertas, seis gráficos, entradas e saídas, ocupação, clientes, reservas recentes e timeline. Os gráficos têm tabelas equivalentes e o relatório impresso mantém essa informação em tabelas.
- A série financeira agrupa reservas pela data de entrada; "Reservas por mês" agrupa pela data de criação do registo. Estas são métricas distintas. Os períodos curtos mostram até seis meses de contexto nos gráficos, mas os KPIs e rankings permanecem estritamente no período selecionado.
- A taxa mensal de ocupação mede dias de estadia de propriedades distintas divididos pelos dias do mês multiplicados pelo número atual de propriedades. Isto usa a carteira atual como denominador histórico; não existem dados suficientes para reconstruir com segurança a carteira disponível em cada dia passado.
- Os valores de reservas incluem pagamentos simulados e não demonstram recebimentos reais. Clientes homónimos continuam excluídos do ranking até existirem identificadores de cliente nas reservas históricas.

## Verificação final

- `php artisan test`: 59 testes, 354 asserções, todos passaram. Os testes cobrem permissões do dashboard e relatório, filtros de mês anterior e personalizado, consistência entre KPI e ocupação, duplicados, estados vazios, atalhos e um limite de menos de 30 queries para uma abertura do dashboard na base de teste.
- `npm.cmd run build` e `node --check` do JavaScript dos gráficos passaram. `git diff --check` passou.
- A migração de índices foi aplicada à base MySQL local. Depois dela, dashboard do mês atual, dashboard do mês anterior e relatório responderam com HTTP 200 numa sessão administrativa real.
- A captura visual automatizada em Edge foi impedida pelo acesso negado ao perfil do navegador neste ambiente. A grelha usa breakpoints para tablet e mobile, mas não foi possível confirmar visualmente os três tamanhos nem inspecionar a consola do navegador. A página abre as tabelas de dados se Chart.js não carregar.
