@extends('layouts.admin')
@section('title', 'Relatório de reservas — Olive Properties')
@section('admin_content')
<div class="management-page dashboard-report">
    <x-document-header title="Relatório de reservas" :scope="$periodos[$periodo].' · '.$inicio->format('d/m/Y').' a '.$fim->format('d/m/Y')" />
    <header class="admin-page-heading no-print"><div><p class="eyebrow">Área reservada · Dashboard</p><h1>Relatório de reservas</h1><p>Ocupação e atividade no período selecionado.</p></div></header>
    <div class="dashboard-report__actions no-print">
        <a class="button button--outline" href="{{ route('dashboard', array_filter(['periodo' => $periodo, 'from' => $from, 'to' => $to])) }}">← Voltar atrás</a>
        <button type="button" class="button button--primary" onclick="window.print()">Imprimir / guardar PDF</button>
    </div>
    <div class="dashboard-report__intro">
        <p><strong>{{ $periodos[$periodo] }}</strong> · {{ $inicio->format('d/m/Y') }} a {{ $fim->format('d/m/Y') }} · emitido em {{ $agora->format('d/m/Y H:i') }} (Lisboa)</p>
        <p class="dashboard-report__note">Os montantes são valores de reservas registadas, sem confirmação de recebimento. O pagamento no sistema é uma simulação.</p>
    </div>

    <section class="dashboard-report__section" aria-labelledby="report-summary"><h2 id="report-summary">Visão geral</h2>
        <div class="data-table-wrap"><table class="table"><tbody>
            <tr><th>Propriedades</th><td>{{ $propriedades }}</td><th>Ocupadas hoje</th><td>{{ $ocupadas }}</td></tr>
            <tr><th>Disponíveis hoje</th><td>{{ $disponiveis }}</td><th>Indisponíveis</th><td>{{ $indisponiveis }}</td></tr>
            <tr><th>Reservas no período</th><td>{{ $reservas }}</td><th>Valor das reservas</th><td>{{ number_format($receita, 2, ',', '.') }} €</td></tr>
        </tbody></table></div>
    </section>

    <section class="dashboard-report__section" aria-labelledby="report-occupancy"><h2 id="report-occupancy">Ocupação das propriedades</h2>
        <div class="data-table-wrap"><table class="table"><thead><tr><th>Referência</th><th>Estado hoje</th><th>Ocupada até</th><th>Próxima entrada</th></tr></thead><tbody>
            @forelse($ocupacao as $propriedade)<tr><td>{{ $propriedade->referencia }}</td><td>{{ $propriedade->estado_atual }}</td><td>{{ $propriedade->ocupado_ate ? date('d/m/Y', strtotime($propriedade->ocupado_ate)) : '—' }}</td><td>{{ $propriedade->proxima_entrada ? date('d/m/Y', strtotime($propriedade->proxima_entrada)) : '—' }}</td></tr>
            @empty<tr><td colspan="4">Sem propriedades.</td></tr>@endforelse
        </tbody></table></div>
    </section>

    <section class="dashboard-report__section" aria-labelledby="report-monthly"><h2 id="report-monthly">Evolução mensal</h2><p>Para períodos curtos, a série inclui meses anteriores como contexto.</p>
        <div class="data-table-wrap"><table class="table"><thead><tr><th>Mês</th><th>Valor de reservas</th><th>Reservas com entrada</th><th>Reservas registadas</th><th>Ocupação</th></tr></thead><tbody>
            @foreach($receitaMensal as $index => $mes)<tr><td>{{ $mes['label'] }}</td><td>{{ number_format($mes['total'], 2, ',', '.') }} €</td><td>{{ $mes['reservas'] }}</td><td>{{ $mes['criadas'] }}</td><td>{{ number_format($ocupacaoMensal[$index]['total'], 1, ',', '.') }}%</td></tr>@endforeach
        </tbody></table></div>
    </section>

    <div class="dashboard-report__rankings">
        <section class="dashboard-report__section" aria-labelledby="report-top"><h2 id="report-top">Mais reservadas</h2><table class="table"><thead><tr><th>Referência</th><th>Reservas</th><th>Valor</th></tr></thead><tbody>
            @forelse($topPropriedades as $item)<tr><td>{{ $item->apartamento }}</td><td>{{ $item->total }}</td><td>{{ number_format($item->valor, 2, ',', '.') }} €</td></tr>@empty<tr><td colspan="3">Sem reservas no período.</td></tr>@endforelse
        </tbody></table></section>
        <section class="dashboard-report__section" aria-labelledby="report-value"><h2 id="report-value">Maior valor de reservas</h2><table class="table"><thead><tr><th>Referência</th><th>Valor</th><th>Reservas</th></tr></thead><tbody>
            @forelse($valorPropriedades as $item)<tr><td>{{ $item->apartamento }}</td><td>{{ number_format($item->valor, 2, ',', '.') }} €</td><td>{{ $item->reservas }}</td></tr>@empty<tr><td colspan="3">Sem reservas no período.</td></tr>@endforelse
        </tbody></table></section>
    </div>
    @if($alertas)<section class="dashboard-report__section" aria-labelledby="report-alerts"><h2 id="report-alerts">Pontos a rever</h2><ul>@foreach($alertas as $alerta)<li>{{ $alerta['total'] }} {{ $alerta['texto'] }}</li>@endforeach</ul></section>@endif
</div>
@endsection
