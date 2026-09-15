@auth
<div class="account-navigation no-print">
    <div class="site-container account-navigation__inner">
        <nav aria-label="Área reservada">
            @if(auth()->user()->tipo === 'administrador')
                <a href="{{ route('dashboard') }}" @class(['is-active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('admin.apartamentos.index') }}" @class(['is-active' => request()->routeIs('admin.apartamentos.*', 'apartamentos.create', 'apartamentos.edit')])>Propriedades</a>
                <a href="{{ route('clientes.index') }}" @class(['is-active' => request()->routeIs('clientes.*')])>Clientes</a>
                <a href="{{ route('vendas.index') }}" @class(['is-active' => request()->routeIs('vendas.*')])>Reservas</a>
                <a href="{{ route('admin.contactos.index') }}" @class(['is-active' => request()->routeIs('admin.contactos.*')])>Pedidos de contacto @if($novosContactosMenu = \App\Models\PedidoContacto::whereNull('lido_em')->count())<span class="account-navigation__count">{{ $novosContactosMenu }}</span>@endif</a>
            @endif
            <a href="{{ route('profile.edit') }}" @class(['is-active' => request()->routeIs('profile.*')])>O meu perfil</a>
        </nav>
        <div class="account-navigation__user">
            <span>{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Terminar sessão</button>
            </form>
        </div>
    </div>
</div>
@endauth
