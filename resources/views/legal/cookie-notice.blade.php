<section class="cookie-notice" x-data="cookieNotice" x-show="visible" x-cloak
    @open-cookie-notice.window="open($event)" aria-labelledby="cookie-notice-title" aria-label="Preferências de cookies">
    <div>
        <h2 id="cookie-notice-title" tabindex="-1" x-ref="heading">A sua privacidade</h2>
        <p>Usamos apenas cookies necessários à sessão e à segurança. Não usamos cookies de publicidade ou analytics.</p>
        <a href="{{ route('legal.cookies') }}">Consultar a Política de Cookies</a>
    </div>
    <div class="cookie-notice__actions">
        <button type="button" class="button button--outline" @click="save()">Aceitar necessários</button>
        <button type="button" class="button button--outline" @click="save()">Rejeitar não essenciais</button>
    </div>
    <p x-show="storageFailed" role="status">O navegador não permite guardar a escolha. Pode continuar a navegar; este aviso poderá reaparecer.</p>
    <button type="button" x-show="storageFailed" @click="visible = false">Fechar aviso nesta página</button>
</section>
