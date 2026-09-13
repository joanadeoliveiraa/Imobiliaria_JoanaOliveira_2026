<footer class="public-footer">
    <div class="site-container public-footer__main">
        <div class="public-footer__brand">
            <a href="{{ route('home') }}" class="footer-wordmark" aria-label="Olive Properties — início">
                <img src="{{ asset('images/folhas_brancas.png') }}" class="footer-wordmark__logo" alt="" width="64" height="64">
                <div class="footer-wordmark__text"><strong>Olive</strong><span>Properties</span></div>
            </a>
            <address class="public-footer__contact">
                <a href="tel:+351289000000">+351 289 000 000</a>
                <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a>
            </address>
        </div>
        <div class="public-footer__column">
            <h2 class="public-footer__heading">Explorar</h2>
            <nav class="public-footer__nav" aria-label="Navegação do rodapé">
                <a href="{{ route('apartamentos.index') }}">Propriedades</a>
                <a href="{{ route('sobre') }}">Sobre nós</a>
                <a href="{{ route('contactos') }}">Contactos</a>
            </nav>
        </div>
        <div class="public-footer__column public-footer__legal">
            <h2 class="public-footer__heading">Informação legal</h2>
            @include('legal.links')
        </div>
    </div>
    <div class="site-container public-footer__bottom">
        <p>&copy; {{ now()->year }} Olive Properties. Projeto desenvolvido em homenagem às raízes da família Oliveira.</p>
    </div>
</footer>
