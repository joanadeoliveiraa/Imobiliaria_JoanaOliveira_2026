@extends('layouts.admin')
@section('title', 'Clientes — Olive Properties')
@section('admin_content')
<div class="management-page">
    <x-document-header title="Relatório de clientes" :scope="'Registos '.($clientes->firstItem() ?? 0).'–'.($clientes->lastItem() ?? 0).' de '.$clientes->total().' · Página '.$clientes->currentPage().' de '.$clientes->lastPage().(request('pesquisa') ? ' · Pesquisa: '.request('pesquisa') : '')" />
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Clientes</h1></div></header>
    @include('layouts.management-feedback')

    <div class="container py-4" >

        <div class="d-flex justify-content-between mb-3 no-print">
            <div>
                <a href="{{ route('clientes.create') }}" class="btn btn-dark">
                    Novo Cliente
                </a>
            </div>

            <div>
                <button
                    onclick="window.print()" class="btn btn-outline-secondary">
                    Relatório PDF
                </button>

                <a href="{{ url('/') }}" class="btn btn-outline-dark">
                    ← Menu Principal
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('clientes.index') }}" class="no-print">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <input type="text"
                        name="pesquisa"
                        class="form-control"
                        placeholder="Pesquisar por nome, email, contacto ou NIF"
                        value="{{ request('pesquisa') }}">
                </div>

                <div class="col-md-3">
                    <select name="ordenar" class="form-select" onchange="this.form.submit()">
                        <option value="">Ordenar por...</option>
                        <option value="nome"
                            {{ request('ordenar') == 'nome' ? 'selected' : '' }}>
                            Nome
                        </option>
                        <option value="telefone"
                            {{ request('ordenar') == 'telefone' ? 'selected' : '' }}>
                            Contacto
                        </option>
                        <option value="email"
                            {{ request('ordenar') == 'email' ? 'selected' : '' }}>
                            Email
                        </option>
                        <option value="nif"
                            {{ request('ordenar') == 'nif' ? 'selected' : '' }}>
                            NIF
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-dark flex-fill">
                            Procurar
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-dark flex-fill">
                            Limpar
                        </a>
                    </div>
                </div>
            </div>

        </form>

        <div class="data-table-wrap"><table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Morada</th>
                    <th>NIF</th>
                    <th class="no-print">
                        Ações
                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach($clientes as $cliente)

                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>{{ $cliente->morada }}</td>
                    <td>{{ $cliente->nif }}</td>
                    <td class="no-print">
                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-outline-dark btn-sm">
                            Ver
                        </a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-outline-secondary btn-sm">
                            Editar
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}"
                            method="POST"
                            class="inline-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Tem a certeza que pretende apagar este cliente?')">
                                Apagar
                            </button>                         

                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table></div>

        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $clientes->appends(request()->query())->links() }}
        </div>

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

</div>
@endsection
