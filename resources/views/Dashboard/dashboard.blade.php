@extends('layouts.admin')
@section('title', 'Dashboard — Olive Properties')
@section('admin_content')
<div class="management-page dashboard-page">
    <x-document-header title="Dashboard" scope="Indicadores de reservas e ocupação por datas." />
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Dashboard</h1><p>Visão geral da atividade e desempenho da Olive Properties.</p></div></header>
    @include('layouts.management-feedback')
    <div class="container">
        <form method="get" action="{{ route('dashboard') }}" class="dashboard-filter no-print">
            <label for="periodo">Período</label>
            <select id="periodo" name="periodo" class="form-select" data-period-select>
                @foreach($periodos as $key => $label)<option value="{{ $key }}" @selected($periodo === $key)>{{ $label }}</option>@endforeach
            </select>
            <div class="dashboard-custom-dates" data-custom-dates @if($periodo !== 'personalizado') hidden @endif>
                <label for="from">De</label><input id="from" name="from" type="date" class="form-control" value="{{ $from }}" @if($periodo === 'personalizado') required @endif>
                <label for="to">Até</label><input id="to" name="to" type="date" class="form-control" max="{{ $hoje }}" value="{{ $to }}" @if($periodo === 'personalizado') required @endif>
            </div>
            <button class="btn btn-outline-secondary" type="submit">Aplicar</button>
            <a class="btn btn-outline-secondary" href="{{ route('dashboard.report', array_filter(['periodo' => $periodo, 'from' => $from, 'to' => $to])) }}">Relatório para imprimir</a>
        </form>
        <p class="dashboard-context">{{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }} · atualizado em {{ $agora->format('d/m/Y H:i') }}. Valores de reservas com entrada no período; pagamentos são simulados e não comprovam recebimentos.</p>

        <section class="dashboard-section no-print" aria-labelledby="quick-title">
            <div class="dashboard-section-heading"><h2 id="quick-title">Acesso rápido</h2></div>
            <nav class="dashboard-quick" aria-label="Ações rápidas">
                <a class="dashboard-quick-primary" href="{{ route('vendas.create') }}"><span aria-hidden="true">＋</span> Nova reserva</a>
                <a class="dashboard-quick-primary" href="{{ route('clientes.create') }}"><span aria-hidden="true">＋</span> Novo cliente</a>
                <a class="dashboard-quick-primary" href="{{ route('apartamentos.create') }}"><span aria-hidden="true">＋</span> Nova propriedade</a>
                <a href="{{ route('vendas.index') }}"><span aria-hidden="true">↗</span> Ver reservas</a>
                <a href="{{ route('clientes.index') }}"><span aria-hidden="true">↗</span> Ver clientes</a>
                <a href="{{ route('admin.apartamentos.index') }}"><span aria-hidden="true">↗</span> Ver propriedades</a>
                <a href="{{ route('dashboard.report', array_filter(['periodo' => $periodo, 'from' => $from, 'to' => $to])) }}"><span aria-hidden="true">▤</span> Relatórios</a>
                <a href="{{ route('admin.contactos.index') }}"><span aria-hidden="true">✉</span> Pedidos de contacto</a>
            </nav>
        </section>

        <section class="dashboard-section" aria-labelledby="kpi-title">
            <div class="dashboard-section-heading"><h2 id="kpi-title">Indicadores principais</h2></div>
            <div class="dashboard-kpis">
                <a class="dashboard-kpi dashboard-kpi-link" href="{{ route('admin.contactos.index') }}"><span>Pedidos de contacto</span><strong>{{ $novosContactos }} novos</strong><small>Ver pedidos recebidos ↗</small></a>
                @foreach(['Propriedades' => $propriedades, 'Ocupadas hoje' => $ocupadas, 'Disponíveis hoje' => $disponiveis, 'Indisponíveis' => $indisponiveis, 'Reservas no período' => $reservas, 'Clientes registados' => $clientes, 'Taxa de ocupação hoje' => number_format($taxaOcupacao, 1, ',', '.').'%', 'Valor das reservas' => number_format($receita, 2, ',', '.').' €'] as $label => $value)
                    <div class="dashboard-kpi"><span>{{ $label }}</span><strong>{{ $value }}</strong>
                        @if($label === 'Reservas no período' && $comparacao['reservas'] > 0)<small>{{ number_format(($reservas - $comparacao['reservas']) / $comparacao['reservas'] * 100, 1, ',', '.') }}% vs. período anterior</small>@endif
                        @if($label === 'Valor das reservas' && $comparacao['receita'] > 0)<small>{{ number_format(($receita - $comparacao['receita']) / $comparacao['receita'] * 100, 1, ',', '.') }}% vs. período anterior</small>@endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="dashboard-section dashboard-alerts" aria-labelledby="alerts-title"><div class="dashboard-section-heading"><h2 id="alerts-title">Pontos a rever</h2></div>
            @if($alertas)<div class="dashboard-alert-list">@foreach($alertas as $alerta)<a href="{{ route($alerta['rota']) }}"><strong>{{ $alerta['total'] }}</strong><span>{{ $alerta['texto'] }}</span><span aria-hidden="true">↗</span></a>@endforeach</div>
            @else<p class="dashboard-empty">Sem situações que necessitem de atenção.</p>@endif
        </section>

        <section class="dashboard-section" aria-labelledby="performance-title"><div class="dashboard-section-heading"><h2 id="performance-title">Desempenho</h2><p>Séries mensais até {{ $fim->format('m/Y') }}; períodos curtos incluem meses anteriores para contexto.</p></div>
            <div class="dashboard-chart-grid">
                <div class="dashboard-panel dashboard-chart-wide"><h3>Evolução mensal das reservas</h3><div class="dashboard-chart"><canvas id="chart-value" aria-label="Evolução mensal do valor das reservas" role="img"></canvas></div><details><summary>Ver dados do gráfico</summary><table><thead><tr><th>Mês</th><th>Valor</th><th>Reservas</th></tr></thead><tbody>@foreach($receitaMensal as $mes)<tr><td>{{ $mes['label'] }}</td><td>{{ number_format($mes['total'], 2, ',', '.') }} €</td><td>{{ $mes['reservas'] }}</td></tr>@endforeach</tbody></table></details></div>
                <div class="dashboard-panel"><h3>Estado das propriedades hoje</h3><div class="dashboard-chart dashboard-chart-donut"><canvas id="chart-state" aria-label="Estado das propriedades hoje" role="img"></canvas></div><ul class="dashboard-chart-legend"><li>Ocupadas: {{ $ocupadas }} ({{ $propriedades ? number_format($ocupadas / $propriedades * 100, 1, ',', '.') : 0 }}%)</li><li>Disponíveis: {{ $disponiveis }} ({{ $propriedades ? number_format($disponiveis / $propriedades * 100, 1, ',', '.') : 0 }}%)</li><li>Indisponíveis: {{ $indisponiveis }} ({{ $propriedades ? number_format($indisponiveis / $propriedades * 100, 1, ',', '.') : 0 }}%)</li></ul></div>
                <div class="dashboard-panel"><h3>Reservas por mês</h3><p class="dashboard-panel-note">Reservas registadas no sistema</p><div class="dashboard-chart"><canvas id="chart-created" aria-label="Número de reservas criadas por mês" role="img"></canvas></div><details><summary>Ver dados do gráfico</summary><table><thead><tr><th>Mês</th><th>Reservas</th></tr></thead><tbody>@foreach($receitaMensal as $mes)<tr><td>{{ $mes['label'] }}</td><td>{{ $mes['criadas'] }}</td></tr>@endforeach</tbody></table></details></div>
                <div class="dashboard-panel"><h3>Taxa de ocupação</h3><p class="dashboard-panel-note">Propriedades ocupadas por dia / propriedades disponíveis na base</p><div class="dashboard-chart"><canvas id="chart-occupancy" aria-label="Taxa mensal de ocupação" role="img"></canvas></div><details><summary>Ver dados do gráfico</summary><table><thead><tr><th>Mês</th><th>Taxa</th></tr></thead><tbody>@foreach($ocupacaoMensal as $mes)<tr><td>{{ $mes['label'] }}</td><td>{{ number_format($mes['total'], 1, ',', '.') }}%</td></tr>@endforeach</tbody></table></details></div>
                <div class="dashboard-panel"><h3>Propriedades mais reservadas</h3>@if($topPropriedades->isEmpty())<p class="dashboard-empty">Sem reservas no período.</p>@else<div class="dashboard-chart"><canvas id="chart-properties" aria-label="Top cinco propriedades por número de reservas" role="img"></canvas></div><details><summary>Ver dados do gráfico</summary><table><thead><tr><th>Referência</th><th>Reservas</th><th>Valor</th></tr></thead><tbody>@foreach($topPropriedades as $item)<tr><td>{{ $item->apartamento }}</td><td>{{ $item->total }}</td><td>{{ number_format($item->valor, 2, ',', '.') }} €</td></tr>@endforeach</tbody></table></details>@endif<a href="{{ route('admin.apartamentos.index') }}">Ver propriedades ↗</a></div>
                <div class="dashboard-panel"><h3>Valor de reservas por propriedade</h3>@if($valorPropriedades->isEmpty())<p class="dashboard-empty">Sem reservas no período.</p>@else<div class="dashboard-chart"><canvas id="chart-property-value" aria-label="Top cinco propriedades por valor de reservas" role="img"></canvas></div><details><summary>Ver dados do gráfico</summary><table><thead><tr><th>Referência</th><th>Valor</th><th>Reservas</th></tr></thead><tbody>@foreach($valorPropriedades as $item)<tr><td>{{ $item->apartamento }}</td><td>{{ number_format($item->valor, 2, ',', '.') }} €</td><td>{{ $item->reservas }}</td></tr>@endforeach</tbody></table></details>@endif</div>
            </div>
        </section>

        <section class="dashboard-section" aria-labelledby="operations-title"><div class="dashboard-section-heading"><h2 id="operations-title">Operação diária</h2></div>
            <div class="dashboard-two-column"><div class="dashboard-panel"><h3>Entradas próximas</h3>@forelse($chegadas as $reserva)<a class="dashboard-reservation" href="{{ route('vendas.show', $reserva) }}"><time>{{ $reserva->data_entrada->format('d/m/Y') }}</time><strong>{{ $reserva->apartamento }}</strong><span>{{ $reserva->cliente }}</span></a>@empty<p class="dashboard-empty">Sem entradas próximas.</p>@endforelse</div>
            <div class="dashboard-panel"><h3>Saídas de estadias em curso</h3>@forelse($saidas as $reserva)<a class="dashboard-reservation" href="{{ route('vendas.show', $reserva) }}"><time>{{ $reserva->data_saida->format('d/m/Y') }}</time><strong>{{ $reserva->apartamento }}</strong><span>{{ $reserva->cliente }}</span></a>@empty<p class="dashboard-empty">Sem saídas próximas.</p>@endforelse</div></div>
            <div class="dashboard-panel dashboard-occupancy"><div class="dashboard-panel-heading"><h3>Ocupação atual</h3><a href="{{ route('dashboard.report', array_filter(['periodo' => $periodo, 'from' => $from, 'to' => $to])) }}">Ver relatório completo ↗</a></div><div class="data-table-wrap"><table class="table"><thead><tr><th>Referência</th><th>Estado hoje</th><th>Ocupada até</th><th>Próxima entrada</th></tr></thead><tbody>@forelse($ocupacao as $propriedade)<tr><td>{{ $propriedade->referencia }}</td><td><span class="dashboard-status dashboard-status--{{ $propriedade->estado_atual === 'Ocupada' ? 'occupied' : ($propriedade->estado_atual === 'Indisponível' ? 'blocked' : 'available') }}">{{ $propriedade->estado_atual }}</span></td><td>{{ $propriedade->ocupado_ate ? date('d/m/Y', strtotime($propriedade->ocupado_ate)) : '—' }}</td><td>{{ $propriedade->proxima_entrada ? date('d/m/Y', strtotime($propriedade->proxima_entrada)) : '—' }}</td></tr>@empty<tr><td colspan="4">Sem propriedades.</td></tr>@endforelse</tbody></table></div></div>
        </section>

        <section class="dashboard-section" aria-labelledby="analysis-title"><div class="dashboard-section-heading"><h2 id="analysis-title">Análise e atividade</h2></div><div class="dashboard-two-column">
            <div class="dashboard-panel"><h3>Clientes com mais reservas</h3><table class="table"><thead><tr><th>Cliente</th><th>Reservas</th><th>Valor</th></tr></thead><tbody>@forelse($topClientes as $item)<tr><td>{{ $item->cliente }}</td><td>{{ $item->total }}</td><td>{{ number_format($item->valor, 2, ',', '.') }} €</td></tr>@empty<tr><td colspan="3">Sem clientes identificáveis no período.</td></tr>@endforelse</tbody></table></div>
            <div class="dashboard-panel"><div class="dashboard-panel-heading"><h3>Reservas recentes</h3><a href="{{ route('vendas.index') }}">Ver todas ↗</a></div><div class="data-table-wrap"><table class="table"><thead><tr><th>Ref.</th><th>Cliente</th><th>Entrada</th><th>Estado</th></tr></thead><tbody>@forelse($recentes as $reserva)<tr><td><a href="{{ route('vendas.show', $reserva) }}">#{{ $reserva->id }} · {{ $reserva->apartamento }}</a></td><td>{{ $reserva->cliente }}</td><td>{{ $reserva->data_entrada->format('d/m/Y') }}</td><td>{{ $reserva->estadoNaData($hoje) }}</td></tr>@empty<tr><td colspan="4">Sem reservas recentes.</td></tr>@endforelse</tbody></table></div></div>
        </div><div class="dashboard-panel dashboard-activity"><h3>Últimas atividades</h3>@forelse($atividades as $atividade)<div class="dashboard-timeline-item"><time datetime="{{ $atividade->created_at->toIso8601String() }}">{{ $atividade->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</time><p>{{ $atividade->descricao }}</p></div>@empty<p class="dashboard-empty">Ainda não existem atividades registadas.</p>@endforelse</div></section>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.querySelector('[data-period-select]');
    const dates = document.querySelector('[data-custom-dates]');
    select?.addEventListener('change', () => { const custom = select.value === 'personalizado'; dates.hidden = !custom; dates.querySelectorAll('input').forEach(input => input.required = custom); if (!custom) select.form.submit(); });
    const monthly = @json($receitaMensal);
    const occupancy = @json($ocupacaoMensal);
    const top = @json($topPropriedades);
    const valueTop = @json($valorPropriedades);
    const state = [{{ $ocupadas }}, {{ $disponiveis }}, {{ $indisponiveis }}];
    const labels = monthly.map(item => item.label);
    const green = '#30493b', sage = '#718a72', light = '#cfd9cc';
    if (typeof Chart === 'undefined') {
        document.querySelectorAll('.dashboard-chart').forEach(panel => panel.hidden = true);
        document.querySelectorAll('.dashboard-panel details').forEach(table => table.open = true);
        return;
    }
    function draw(id, type, chartLabels, values, opts = {}) {
        const element = document.getElementById(id);
        if (!element || typeof Chart === 'undefined') return;
        const count = state.reduce((sum, value) => sum + value, 0);
        const tooltipLabel = ctx => {
            if (type === 'doughnut') return `${ctx.label}: ${ctx.raw} (${count ? (ctx.raw / count * 100).toFixed(1) : 0}%)`;
            if (opts.money) return new Intl.NumberFormat('pt-PT', {style: 'currency', currency: 'EUR'}).format(ctx.raw);
            return `${ctx.dataset.label}: ${ctx.raw}${opts.percent ? '%' : ''}`;
        };
        new Chart(element, {
            type,
            data: {labels: chartLabels, datasets: [{label: opts.label || '', data: values, borderColor: green, backgroundColor: opts.colors || sage, borderWidth: 2, tension: .28, fill: false}]},
            options: {
                responsive: true, maintainAspectRatio: false, animation: false,
                indexAxis: opts.horizontal ? 'y' : 'x',
                plugins: {legend: {display: type === 'doughnut'}, tooltip: {callbacks: {label: tooltipLabel, afterLabel: ctx => opts.extra?.[ctx.dataIndex] || ''}}},
                scales: type === 'doughnut' ? {} : {
                    y: {beginAtZero: true, ticks: {callback: value => opts.money ? `${value} €` : opts.percent ? `${value}%` : value}},
                    x: {ticks: {maxRotation: 0, autoSkip: true}}
                }
            }
        });
    }
    draw('chart-value', 'line', labels, monthly.map(item => item.total), {label: 'Valor de reservas', money: true, extra: monthly.map(item => `${item.reservas} reserva(s) com entrada no mês`)});
    draw('chart-created', 'bar', labels, monthly.map(item => item.criadas), {label: 'Reservas registadas'});
    draw('chart-occupancy', 'line', occupancy.map(item => item.label), occupancy.map(item => item.total), {label: 'Taxa de ocupação', percent: true});
    draw('chart-properties', 'bar', top.map(item => item.apartamento), top.map(item => item.total), {label: 'Reservas', horizontal: true, extra: top.map(item => `${new Intl.NumberFormat('pt-PT', {style: 'currency', currency: 'EUR'}).format(item.valor)} em reservas`)});
    draw('chart-property-value', 'bar', valueTop.map(item => item.apartamento), valueTop.map(item => Number(item.valor)), {label: 'Valor de reservas', money: true, extra: valueTop.map(item => `${item.reservas} reserva(s)`)});
    draw('chart-state', 'doughnut', ['Ocupadas', 'Disponíveis', 'Indisponíveis'], state, {colors: [green, sage, light]});
});
</script>
@endpush
