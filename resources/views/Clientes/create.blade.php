@extends('layouts.admin')
@section('title', 'Novo cliente — Olive Properties')
@section('admin_content')
<header class="admin-page-heading"><div><p class="eyebrow">Área reservada · Clientes</p><h1>Novo cliente</h1></div></header>
@include('layouts.management-feedback')
<form class="form-panel" method="POST" action="{{ route('clientes.store') }}">
    <input type="hidden" name="origem" value="{{ old('origem', request('origem')) }}">
    @include('Clientes._form')
    <div class="form-actions">
        <button type="submit" class="button button--primary">Gravar cliente</button>
        <a href="{{ route('clientes.index') }}" class="button button--outline">Cancelar</a>
    </div>
</form>
@endsection
