<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboard)
    {
        $filter = $this->filter($request);
        return view('Dashboard.dashboard', $dashboard->dados(...[$filter['periodo'], false, $filter['from'] ?? null, $filter['to'] ?? null]));
    }

    public function report(Request $request, DashboardService $dashboard)
    {
        $filter = $this->filter($request);
        return view('Dashboard.report', $dashboard->dados(...[$filter['periodo'], true, $filter['from'] ?? null, $filter['to'] ?? null]));
    }

    private function filter(Request $request): array
    {
        $data = $request->validate([
            'periodo' => ['sometimes', Rule::in(array_keys(DashboardService::PERIODOS))],
            'from' => ['required_if:periodo,personalizado', 'nullable', 'date_format:Y-m-d'],
            'to' => ['required_if:periodo,personalizado', 'nullable', 'date_format:Y-m-d', 'after_or_equal:from', 'before_or_equal:today'],
        ]);
        $data['periodo'] ??= 'mes';
        if ($data['periodo'] === 'personalizado' && CarbonImmutable::parse($data['from'])->diffInDays(CarbonImmutable::parse($data['to'])) > 365) {
            throw \Illuminate\Validation\ValidationException::withMessages(['from' => 'Escolha um período até 12 meses.']);
        }
        return $data;
    }
}
