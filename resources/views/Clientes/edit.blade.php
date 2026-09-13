@extends('layouts.admin')
@section('title', 'Editar cliente — Olive Properties')
@section('admin_content')
<header class="admin-page-heading"><div><p class="eyebrow">Área reservada · Clientes</p><h1>Editar cliente</h1></div></header>
@include('layouts.management-feedback')
<form class="form-panel" method="POST" action="{{ route('clientes.update', $cliente->id) }}">
    @method('PUT')
    @include('Clientes._form')
    <div class="form-actions">
        <button type="submit" class="button button--primary">Guardar alterações</button>
        <a href="{{ route('clientes.index') }}" class="button button--outline">Cancelar</a>
    </div>
</form>
@endsection
