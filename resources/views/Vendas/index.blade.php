@extends('layouts.admin')
@section('title', 'Reservas — Olive Properties')
@section('admin_content')
<div class="management-page">
    <x-document-header title="Relatório de reservas" :scope="'Registos '.($vendas->firstItem() ?? 0).'–'.($vendas->lastItem() ?? 0).' de '.$vendas->total().' · Página '.$vendas->currentPage().' de '.$vendas->lastPage()" />
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Reservas</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container py-4" >

        <div class="d-flex justify-content-between mb-3 no-print">
            <div>
                <a href="{{ route('vendas.create') }}" class="btn btn-dark">
                    Nova Reserva
                </a>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    Relatório PDF
                </button>
                <a href="{{ url('/') }}" class="btn btn-outline-dark">
                    ← Menu Principal
                </a>
            </div>
        </div>


        <div class="data-table-wrap"><table class="table table-striped table-bordered">
            <thead class="table-dark">

                <tr>

                    <th>Cliente</th>
                    <th>Apartamento</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Valor Total</th>

                    <th class="no-print">
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->cliente }}</td>
                    <td>{{ $venda->apartamento }}</td>
                    <td>{{ date('d/m/Y', strtotime($venda->data_entrada)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($venda->data_saida)) }}</td>
                    <td>{{ number_format($venda->valor_total, 2, ',', '.') }} €</td>
                    <td class="no-print">
                        <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-outline-dark btn-sm">
                            Detalhes
                        </a>
                        <a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>
                        <form action="{{ route('vendas.destroy', $venda->id) }}"
                            method="POST"
                            class="inline-form">

                            @csrf
                            @method('DELETE')

                            <button type="button"
                                class="btn btn-outline-danger btn-sm btn-apagar"
                                data-delete-url="{{ route('vendas.destroy', $venda->id) }}">
                                Apagar
                            </button>

                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table></div>

        <div class="apenas-impressao text-center text-muted mt-5">
            <hr>
            <p class="mb-1">
                Obrigado por escolher a Olive Properties.
            </p>
            <small>
                Documento gerado automaticamente pelo sistema.
            </small>
        </div>

    </div>

<div class="pagination-wrap no-print">{{ $vendas->withQueryString()->links() }}</div>

</div>
@endsection
