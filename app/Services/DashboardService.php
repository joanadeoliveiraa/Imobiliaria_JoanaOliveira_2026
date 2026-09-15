<?php

namespace App\Services;

use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\PedidoContacto;
use App\Models\Venda;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public const PERIODOS = [
        'mes' => 'Este mês', 'anterior' => 'Mês anterior', '3meses' => 'Últimos 3 meses',
        '6meses' => 'Últimos 6 meses', 'ano' => 'Este ano', 'personalizado' => 'Personalizado',
    ];

    public function dados(string $periodo = 'mes', bool $report = false, ?string $from = null, ?string $to = null): array
    {
        $agora = CarbonImmutable::now('Europe/Lisbon');
        $hoje = $agora->toDateString();
        [$inicio, $fim] = match ($periodo) {
            'anterior' => [$agora->startOfMonth()->subMonth(), $agora->startOfMonth()->subDay()->endOfDay()],
            '3meses' => [$agora->startOfMonth()->subMonths(2), $agora],
            '6meses' => [$agora->startOfMonth()->subMonths(5), $agora],
            'ano' => [$agora->startOfYear(), $agora],
            'personalizado' => [CarbonImmutable::parse($from, 'Europe/Lisbon')->startOfDay(), CarbonImmutable::parse($to, 'Europe/Lisbon')->endOfDay()],
            default => [$agora->startOfMonth(), $agora],
        };
        $periodStart = $inicio->toDateString();
        $periodEnd = $fim->toDateString();
        $base = fn () => Venda::receitaEntre($periodStart, $periodEnd);

        $periodDays = $inicio->startOfDay()->diffInDays($fim->startOfDay()) + 1;
        $anteriorInicio = $inicio->startOfDay()->subDays($periodDays);
        $anteriorFim = $inicio->startOfDay()->subDay()->endOfDay();
        $comparacao = [
            'inicio' => $anteriorInicio, 'fim' => $anteriorFim,
            'reservas' => Venda::receitaEntre($anteriorInicio->toDateString(), $anteriorFim->toDateString())->count(),
            'receita' => (float) Venda::receitaEntre($anteriorInicio->toDateString(), $anteriorFim->toDateString())->sum('valor_total'),
        ];

        $ocupada = fn (Builder $q) => $q->whereHas('reservas', fn ($r) => $r->emCurso($hoje));
        $livre = fn (Builder $q) => $q->whereDoesntHave('reservas', fn ($r) => $r->emCurso($hoje));
        $propriedades = Apartamento::count();
        $ocupadas = $ocupada(Apartamento::query())->count();
        $disponiveis = $livre(Apartamento::where('estado', Apartamento::ESTADO_DISPONIVEL))->count();
        $indisponiveis = $propriedades - $ocupadas - $disponiveis;
        $receita = (float) $base()->sum('valor_total');
        $reservas = $base()->count();
        $clientes = Cliente::count();
        $novosContactos = PedidoContacto::where('estado', 'new')->count();
        $contactosPendentes = PedidoContacto::whereIn('estado', ['new', 'in_progress'])->count();
        $taxaOcupacao = $propriedades ? round($ocupadas / $propriedades * 100, 1) : 0;

        // A série mostra até 12 meses e inclui contexto recente para períodos curtos.
        $chartEnd = $fim->startOfMonth();
        $monthsInPeriod = (int) $inicio->startOfMonth()->diffInMonths($chartEnd) + 1;
        $chartMonths = min(12, max(6, $monthsInPeriod));
        $chartStart = $chartEnd->subMonths($chartMonths - 1);
        $seriesEnd = $fim->toDateString();
        $financial = Venda::receitaEntre($chartStart->toDateString(), $seriesEnd)
            ->selectRaw('SUBSTR(data_entrada, 1, 7) as mes, COUNT(*) as reservas, SUM(valor_total) as total')
            ->groupBy('mes')->get()->keyBy('mes');
        $created = Venda::deGestao()->whereBetween('created_at', [$chartStart->startOfDay(), $fim])
            ->selectRaw('SUBSTR(created_at, 1, 7) as mes, COUNT(*) as total')
            ->groupBy('mes')->get()->keyBy('mes');
        $receitaMensal = collect();
        foreach (range(0, $chartMonths - 1) as $offset) {
            $month = $chartStart->addMonths($offset);
            $key = $month->format('Y-m');
            $receitaMensal->push([
                'mes' => $key, 'label' => $month->locale('pt')->translatedFormat('M Y'),
                'total' => (float) ($financial[$key]->total ?? 0),
                'reservas' => (int) ($financial[$key]->reservas ?? 0),
                'criadas' => (int) ($created[$key]->total ?? 0),
            ]);
        }

        // Propriedades ocupadas por dia, sem contar estadias sobrepostas duas vezes.
        $occupancyReservations = Venda::deGestao()
            ->where('data_entrada', '<', $fim->startOfMonth()->addMonth()->toDateString())
            ->where('data_saida', '>', $chartStart->toDateString())
            ->get(['apartamento', 'data_entrada', 'data_saida']);
        $ocupacaoMensal = $receitaMensal->map(function ($month) use ($occupancyReservations, $propriedades, $fim) {
            $start = CarbonImmutable::parse($month['mes'].'-01', 'Europe/Lisbon');
            $end = $start->endOfMonth();
            if ($end > $fim) {
                $end = $fim;
            }
            $occupiedDays = [];
            foreach ($occupancyReservations as $reservation) {
                $arrival = CarbonImmutable::parse($reservation->data_entrada->toDateString());
                $departure = CarbonImmutable::parse($reservation->data_saida->toDateString());
                for ($day = max($arrival, $start); $day < min($departure, $end->startOfDay()->addDay()); $day = $day->addDay()) {
                    $occupiedDays[$day->toDateString()][$reservation->apartamento] = true;
                }
            }
            $occupied = array_sum(array_map('count', $occupiedDays));
            $days = $start->diffInDays($end->startOfDay()) + 1;
            return ['label' => $month['label'], 'total' => $propriedades && $days ? round($occupied / ($propriedades * $days) * 100, 1) : 0];
        });

        $topPropriedades = $base()->select('apartamento')->selectRaw('COUNT(*) as total, SUM(valor_total) as valor')
            ->groupBy('apartamento')->orderByDesc('total')->orderBy('apartamento')->limit(5)->get();
        $valorPropriedades = $base()->select('apartamento')->selectRaw('COUNT(*) as reservas, SUM(valor_total) as valor')
            ->groupBy('apartamento')->orderByDesc('valor')->orderBy('apartamento')->limit(5)->get();
        $topClientes = $base()->whereRaw('(SELECT COUNT(*) FROM clientes WHERE clientes.nome = vendas.cliente) = 1')
            ->select('cliente')->selectRaw('COUNT(*) as total, SUM(valor_total) as valor')
            ->groupBy('cliente')->orderByDesc('total')->orderBy('cliente')->limit(5)->get();
        $chegadas = Venda::futuras($hoje)->orderBy('data_entrada')->orderBy('id')->limit(5)->get();
        $saidas = Venda::emCurso($hoje)->orderBy('data_saida')->orderBy('id')->limit(5)->get();
        $recentes = Venda::deGestao()->latest('created_at')->latest('id')->limit(5)->get();
        $atividades = Atividade::latest()->latest('id')->limit(6)->get();
        $ocupacao = Apartamento::comEstadoAtual($hoje)->orderBy('referencia');
        $ocupacao = $report ? $ocupacao->get() : $ocupacao->limit(5)->get();

        $totalVendas = Venda::count();
        $semDuplicados = Venda::semDuplicados()->count();
        $validas = Venda::deGestao()->count();
        $ambiguous = DB::table('clientes')->select('nome')->groupBy('nome')->havingRaw('COUNT(*) > 1')->get()->count();
        $alertas = [];
        $addAlert = function (int $count, string $text, string $route) use (&$alertas): void {
            if ($count > 0) {
                $alertas[] = ['total' => $count, 'texto' => $text, 'rota' => $route];
            }
        };
        $addAlert(Venda::deGestao()->where('data_entrada', $hoje)->count(), 'entrada(s) hoje', 'vendas.index');
        $addAlert(Venda::deGestao()->where('data_saida', $hoje)->count(), 'saída(s) hoje', 'vendas.index');
        $addAlert($indisponiveis, 'propriedade(s) indisponível(is)', 'admin.apartamentos.index');
        $addAlert($contactosPendentes, 'pedido(s) de contacto aguardam análise', 'admin.contactos.index');
        $addAlert($totalVendas - $semDuplicados, 'reserva(s) duplicada(s) excluída(s) dos indicadores', 'vendas.index');
        $addAlert($semDuplicados - $validas, 'reserva(s) com dados inválidos ou referências em falta', 'vendas.index');
        $addAlert($ambiguous, 'nome(s) de cliente ambíguo(s)', 'clientes.index');
        $addAlert(Apartamento::whereHas('reservas', fn ($q) => $q->emCurso($hoje), '>', 1)->count(), 'propriedade(s) com estadias sobrepostas hoje', 'vendas.index');

        return compact('agora', 'hoje', 'periodo', 'inicio', 'fim', 'from', 'to', 'propriedades', 'ocupadas', 'disponiveis', 'indisponiveis', 'receita', 'reservas', 'clientes', 'novosContactos', 'taxaOcupacao', 'comparacao', 'receitaMensal', 'ocupacaoMensal', 'topPropriedades', 'valorPropriedades', 'topClientes', 'chegadas', 'saidas', 'recentes', 'atividades', 'ocupacao', 'alertas') + ['periodos' => self::PERIODOS];
    }
}
