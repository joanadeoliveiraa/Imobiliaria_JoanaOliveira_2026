@extends('layouts.admin')
@section('title', 'Histórico de reservas — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Histórico de reservas</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container mt-4">

        <div class="">
            <strong>Cliente:</strong>
            {{ $cliente }}

        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="alert alert-success py-2">
                    <strong>Total de Reservas:</strong>
                    {{ $totalReservas }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-info py-2">
                    <strong>Total Gasto:</strong>
                    {{ number_format($totalGasto, 2, ',', '.') }} €
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-secondary py-2">
                    <strong>Última Reserva:</strong>

                    @if($ultimaReserva)
                    {{ date('d/m/Y', strtotime($ultimaReserva)) }}
                    @else
                    -
                    @endif
                </div>
            </div>
        </div>

        <div class="data-table-wrap"><table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Apartamento</th>
                    <th>Data de Entrada</th>
                    <th>Data de Saída</th>
                    <th>Valor Total</th>
                </tr>
            </thead>

            <tbody>

                @forelse($vendas as $venda)

                <tr>
                    <td>{{ $venda->apartamento }}</td>
                    <td>{{ $venda->data_entrada }}</td>
                    <td>{{ $venda->data_saida }}</td>
                    <td>{{ $venda->valor_total }} €</td>
                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Não existem reservas para este cliente.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table></div>

        <div class="mt-4">

            <a href="{{ route('vendas.create') }}"
                class="btn btn-dark">
                Nova Reserva
            </a>

            <a href="{{ route('vendas.index') }}"
                class="btn btn-outline-secondary">
                Ver Reservas
            </a>

            <a href="{{ url('/') }}"
                class="btn btn-outline-dark">
                Menu Principal
            </a>

        </div>
    </div>

</div>
@endsection
