@extends('layouts.admin')
@section('title', 'Editar reserva — Olive Properties')
@section('admin_content')
<header class="admin-page-heading"><div><p class="eyebrow">Área reservada · Reservas</p><h1>Editar reserva</h1></div></header>
@include('layouts.management-feedback')
<form action="{{ route('vendas.update', $venda->id) }}" method="POST" class="form-panel">
    @csrf
    @method('PUT')
    <div class="form-grid">
        <div class="field">
            <label for="cliente">Cliente *</label>
            <input id="cliente" name="cliente" value="{{ old('cliente', $venda->cliente) }}" required>
        </div>
        <div class="field">
            <label for="apartamento">Apartamento</label>
            <input id="apartamento" value="{{ $venda->apartamento }}" readonly>
        </div>
        <div class="field">
            <label for="data_entrada">Data de entrada *</label>
            <input id="data_entrada" name="data_entrada" type="date" value="{{ old('data_entrada', $venda->data_entrada?->format('Y-m-d')) }}" required>
        </div>
        <div class="field">
            <label for="data_saida">Data de saída *</label>
            <input id="data_saida" name="data_saida" type="date" value="{{ old('data_saida', $venda->data_saida?->format('Y-m-d')) }}" required>
        </div>
        <div class="field">
            <label for="valor_total">Valor total (€)</label>
            <input id="valor_total" name="valor_total" type="number" min="0" step="0.01" value="{{ old('valor_total', $venda->valor_total) }}" readonly>
            <p class="field-help">O valor é calculado a partir do preço da propriedade.</p>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="button button--primary">Guardar alterações</button>
        <a href="{{ route('vendas.index') }}" class="button button--outline">Voltar</a>
        <button type="button" class="button button--danger" data-delete-url="{{ route('vendas.destroy', $venda->id) }}">Cancelar reserva</button>
    </div>
</form>
@endsection
