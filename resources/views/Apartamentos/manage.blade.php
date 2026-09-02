@extends('layouts.admin')

@section('title', 'Gestão de propriedades')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="eyebrow">Backoffice</p>
            <h1>Propriedades</h1>
            <p>Consulte e mantenha o portefólio Olive Properties.</p>
        </div>
        <a href="{{ route('apartamentos.create') }}" class="button button--primary">Adicionar propriedade</a>
    </div>

    @if(session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.apartamentos.index') }}" method="GET" class="admin-filters">
        <div class="field">
            <label for="pesquisa">Pesquisar</label>
            <input id="pesquisa" type="search" name="pesquisa" value="{{ request('pesquisa') }}" placeholder="Referência, tipologia ou localização">
        </div>
        <div class="field">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="">Todos</option>
                <option value="Disponivel" @selected(request('estado') === 'Disponivel')>Disponível</option>
                <option value="Nao Disponivel" @selected(request('estado') === 'Nao Disponivel')>Indisponível</option>
            </select>
        </div>
        <button class="button button--secondary" type="submit">Aplicar filtros</button>
        @if(request()->hasAny(['pesquisa', 'estado']))
            <a href="{{ route('admin.apartamentos.index') }}" class="button button--ghost">Limpar</a>
        @endif
    </form>

    <div class="data-panel">
        <div class="data-table-wrap">
            <table class="data-table">
                <thead><tr><th>Propriedade</th><th>Localização</th><th>Área</th><th>Preço semanal</th><th>Estado</th><th><span class="sr-only">Ações</span></th></tr></thead>
                <tbody>
                @forelse($apartamentos as $apartamento)
                    <tr>
                        <td><div class="property-cell">
                            @if($apartamento->fotografia)<img src="{{ asset('storage/'.$apartamento->fotografia) }}" alt="">@endif
                            <div><strong>{{ $apartamento->referencia }}</strong><span>{{ $apartamento->tipologia }}</span></div>
                        </div></td>
                        <td>{{ $apartamento->morada }}</td>
                        <td>{{ number_format((float) $apartamento->area, 0, ',', '.') }} m²</td>
                        <td>{{ number_format((float) $apartamento->preco, 2, ',', '.') }} €</td>
                        <td><span class="badge {{ $apartamento->estado === 'Disponivel' ? 'badge--success' : 'badge--neutral' }}">{{ $apartamento->estado === 'Disponivel' ? 'Disponível' : 'Indisponível' }}</span></td>
                        <td><div class="table-actions">
                            <a href="{{ route('apartamentos.show', $apartamento) }}">Ver</a>
                            <a href="{{ route('apartamentos.edit', $apartamento) }}">Editar</a>
                            <form action="{{ route('apartamentos.destroy', $apartamento) }}" method="POST" onsubmit="return confirm('Tem a certeza de que pretende eliminar esta propriedade?')">@csrf @method('DELETE')<button type="submit">Eliminar</button></form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="table-empty"><strong>Nenhuma propriedade encontrada</strong><span>Altere os filtros ou adicione uma nova propriedade.</span></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($apartamentos->hasPages())<div class="pagination-wrap">{{ $apartamentos->links() }}</div>@endif
    </div>
@endsection
