@extends('layouts.admin')
@section('title', 'Detalhes do cliente — Olive Properties')
@section('admin_content')
<div class="management-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Detalhes do cliente</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container mt-4">

        <div class="card">

            <div class="card-header">
                <h4>Detalhes do Cliente</h4>
            </div>

            <div class="card-body">
                <p>
                    <strong>ID:</strong> {{ $cliente->id }}
                </p>
                <p>
                    <strong>Nome:</strong> {{ $cliente->nome }}
                </p>
                <p>
                    <strong>Email:</strong> {{ $cliente->email }}
                </p>
                <p>
                    <strong>Telefone:</strong> {{ $cliente->telefone }}
                </p>
                <p>
                    <strong>Morada:</strong> {{ $cliente->morada }}
                </p>
                <p>
                    <strong>NIF:</strong> {{ $cliente->nif }}
                </p>

                <div class="mt-4">
                    <a href="{{ route('clientes.reservas', $cliente->nome) }}" class="btn btn-dark">
                        Histórico de Reservas
                    </a>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-outline-dark">
                        Editar Cliente
                    </a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                        Voltar
                    </a>
                </div>

            </div>

        </div>

</div>

</div>
@endsection
