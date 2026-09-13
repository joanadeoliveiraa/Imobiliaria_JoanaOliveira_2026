@extends('layouts.admin')
@section('title', 'Nova reserva — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Nova reserva</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container mt-4">

        <div class="mb-4">
            <h3 class="titulo-principal mb-1">
                Nova Reserva
            </h3>
            <small class="text-muted">
                Registo de uma nova reserva
            </small>

        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('vendas.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="apartamento">
                            Apartamento
                        </label>
<select name="apartamento"
                            id="apartamento"
                            class="form-select">

                            @foreach($apartamentos as $apartamento)

                            <option value="{{ $apartamento->referencia }}"
                                data-preco="{{ $apartamento->preco }}" @selected(old('apartamento') == $apartamento->referencia)>

                                {{ $apartamento->referencia }} -
                                {{ $apartamento->tipologia }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="cliente">
                            Cliente
                        </label>
<select name="cliente" class="form-select" required id="cliente">
                            <option value="">
                                Selecione um cliente
                            </option>

                            @foreach($clientes as $cliente)

                            <option value="{{ $cliente->nome }}"
                                @selected(old('cliente', $clienteSelecionado) == $cliente->nome)>
                                {{ $cliente->nome }}
                            </option>

                            @endforeach

                        </select>
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('clientes.create', ['origem' => 'reserva']) }}" class="btn">
                                + Novo Cliente
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="data_entrada">
                            Data de Entrada
                        </label>
<input type="date"
                            id="data_entrada"
                            name="data_entrada"
                            class="form-control"
                            required value="{{ old('data_entrada') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="data_saida">
                            Data de Saída
                        </label>
<input type="date"
                            id="data_saida"
                            name="data_saida"
                            class="form-control"
                            readonly value="{{ old('data_saida') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="valor_total">
                            Valor Total (€)
                        </label>
<input type="number" step="0.01" min="0"
                            id="valor_total"
                            name="valor_total"
                            class="form-control"
                            readonly value="{{ old('valor_total') }}">
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn">
                            Confirmar Reserva
                        </button>

                        <a href="{{ route('vendas.index') }}" class="btn btn-outline-dark">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
        function atualizarPreco() {
            let apartamento = document.getElementById('apartamento');

            let preco = apartamento.selectedOptions[0]?.dataset.preco ?? '';

            document.getElementById('valor_total').value = preco;
        }

        document.getElementById('data_entrada').addEventListener('change', function() {
            if (!this.value) {
                document.getElementById('data_saida').value = '';
                return;
            }
            let entrada = new Date(this.value);
            entrada.setDate(entrada.getDate() + 7);

            let saida = entrada.toISOString().split('T')[0];

            document.getElementById('data_saida').value = saida;
        });

        document.getElementById('apartamento').addEventListener('change', atualizarPreco);

        atualizarPreco();
    </script>
@endpush
