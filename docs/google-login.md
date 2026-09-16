# Contas de cliente e login com Google

O registo em `/register` cria sempre uma conta de cliente, com acesso a reservas e mensagens. O login normal continua disponível para clientes e administradores.

## Ativar Google

1. Na [Google Cloud Console](https://console.cloud.google.com/), configure o ecrã de consentimento OAuth (Google Auth Platform), com os dados da aplicação e o público pretendido. Durante os testes, adicione os utilizadores de teste.
2. Crie um cliente OAuth do tipo aplicação Web. Registe como URI de redirecionamento autorizado `http://127.0.0.1:8000/auth/google/callback` para desenvolvimento. Em produção, use o domínio HTTPS real com `/auth/google/callback`.
3. No `.env` local, preencha `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` e `GOOGLE_REDIRECT_URI`. A URI deve corresponder exatamente à registada na Google. Não coloque o segredo no Git nem no JavaScript.
4. Execute `php artisan migrate` e `php artisan config:clear`.
5. Abra `/login`, escolha **Continuar com Google** e confirme que chega à área de cliente. Termine sessão e repita para verificar o acesso à mesma conta.

Sem credenciais, o botão informa que o serviço ainda não está disponível; o registo com email funciona normalmente. Os testes automatizados simulam a resposta da Google. A validação real exige credenciais e consentimento no navegador.

## Comportamento

- São pedidos apenas os dados básicos de identificação e email. Os tokens Google não são guardados.
- O identificador Google é único e a sessão OAuth é validada pelo Socialite. É exigido email verificado.
- Não há associação automática a contas existentes pelo email, nem login administrativo por Google. Uma conta existente deve usar a palavra-passe ou a recuperação de palavra-passe.
- Para uma conta criada com Google, a recuperação de palavra-passe permite definir uma palavra-passe local.

Referências: [Laravel Socialite](https://laravel.com/docs/12.x/socialite) e [Google OpenID Connect](https://developers.google.com/identity/openid-connect/openid-connect).
