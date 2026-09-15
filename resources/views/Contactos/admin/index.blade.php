@extends('layouts.admin')
@section('title', 'Pedidos de contacto — Olive Properties')
@section('admin_content')
<div class="management-page contact-admin-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada</p><h1>Pedidos de contacto</h1><p>Mensagens recebidas pelo formulário público.</p></div></header>
    @include('layouts.management-feedback')
    <form method="get" action="{{ route('admin.contactos.index') }}" class="contact-admin-filters">
        <div><label for="contact-search" class="form-label">Pesquisar</label><input id="contact-search" class="form-control" type="search" name="pesquisa" value="{{ $pesquisa }}" placeholder="Nome, email, assunto ou mensagem"></div>
        <div><label for="contact-status" class="form-label">Estado</label><select id="contact-status" class="form-select" name="estado"><option value="">Todos</option>@foreach(\App\Models\PedidoContacto::ESTADOS as $value => $label)<option value="{{ $value }}" @selected($estado === $value)>{{ $label }}</option>@endforeach</select></div>
        <div><label for="contact-order" class="form-label">Ordenar</label><select id="contact-order" class="form-select" name="ordem"><option value="recentes" @selected($ordem === 'recentes')>Mais recentes</option><option value="antigos" @selected($ordem === 'antigos')>Mais antigos</option></select></div>
        <div class="contact-admin-filter-actions"><button class="button button--primary" type="submit">Pesquisar</button><a class="button button--outline" href="{{ route('admin.contactos.index') }}">Limpar</a></div>
    </form>
    <div class="data-table-wrap"><table class="table contact-admin-table"><thead><tr><th>Data</th><th>Nome</th><th>Email</th><th>Assunto</th><th>Estado</th><th>Ação</th></tr></thead><tbody>
        @forelse($pedidos as $pedido)<tr @class(['contact-unread' => ! $pedido->lido_em])>
            <td><time datetime="{{ $pedido->created_at->toIso8601String() }}">{{ $pedido->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</time>@if(! $pedido->lido_em)<small class="contact-unread-label">Não lido</small>@endif</td>
            <td>{{ $pedido->nome }}</td><td>{{ $pedido->email }}</td><td>{{ $pedido->assunto }}</td>
            <td><span class="contact-status contact-status--{{ $pedido->estado }}">{{ $pedido->estado_texto }}</span></td>
            <td><a class="button button--outline button--small" href="{{ route('admin.contactos.show', $pedido) }}">Ver pedido</a></td>
        </tr>@empty<tr><td colspan="6">{{ $pesquisa || $estado ? 'Não foram encontrados pedidos com estes critérios.' : 'Ainda não existem pedidos de contacto.' }}</td></tr>@endforelse
    </tbody></table></div>
    @if($pedidos->hasPages())<div class="pagination-wrap">{{ $pedidos->links() }}</div>@endif
</div>
@endsection
