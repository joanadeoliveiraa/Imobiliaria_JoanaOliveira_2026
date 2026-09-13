# Footer e informação legal — 13 de setembro de 2026

## Âmbito e auditoria

Implementação dos pontos 25–30 sobre a estrutura existente. Não constitui a auditoria completa dos pontos 1–24 do documento de contexto.

- IMPORTANTE: não existiam páginas nem links legais. Foram criadas três rotas públicas e páginas com layout partilhado.
- IMPORTANTE: não existe identificação legal confirmada da entidade, política de conservação ou inventário dos prestadores de alojamento. Os documentos incluem marcadores `[A PREENCHER]` explícitos; não devem ser considerados documentação empresarial final sem preenchimento e validação.
- IMPORTANTE: o POST de contactos apenas devolve uma mensagem de sucesso; não envia email nem persiste a mensagem. O comportamento foi identificado nas páginas legais, mas não alterado nesta tarefa.
- MELHORIA: páginas antigas Sobre e Contactos têm layouts autónomos. Receberam links legais e o mesmo aviso, preservando os conteúdos e estilos existentes.

## Direitos preservados

Linha original mantida literalmente, agora no componente partilhado `resources/views/layouts/footer.blade.php`:

```blade
<p>&copy; {{ now()->year }} Olive Properties. Projeto desenvolvido em homenagem às raízes da família Oliveira.</p>
```

## Inventário técnico

- Cookie de sessão: nome e duração obtidos de `config/session.php` em tempo de renderização.
- `XSRF-TOKEN`: duração igual ao tempo de sessão, conforme `VerifyCsrfToken::newCookie` do framework instalado.
- `remember_web_*`: apenas mediante opção Lembrar-me, em `LoginRequest`; duração padrão verificada de 576000 minutos (400 dias) no `SessionGuard` instalado. Rever esta documentação se houver alteração da duração no guard/framework.
- `olive-cookie-choice-v1`: novo armazenamento local, validade de 180 dias; sem tracking nem transmissão para terceiros. Preferências expiradas, inválidas ou de outra versão fazem reaparecer o aviso.
- Não foram encontradas integrações de publicidade/analytics. jsDelivr e Bunny Fonts são recursos externos existentes em páginas antigas; a sua utilização é documentada sem presumir cookies de tracking.
- Aceitar necessários e rejeitar não essenciais guardam a configuração efetivamente disponível: apenas necessários. A página de cookies permite reabrir o aviso. Não existem interruptores fictícios para categorias inexistentes.
- Com armazenamento bloqueado, apresenta-se uma mensagem explícita e permite-se fechar o aviso apenas na página atual.

## Verificação automatizada

- `php artisan test --compact`: 38 testes aprovados, 127 asserções.
- `node --test tests/cookie-notice.test.mjs`: 3 testes aprovados (primeira visita/persistência, dados inválidos/expirados, armazenamento bloqueado).
- `npm.cmd run build`: compilação de produção aprovada.
- `php vendor/bin/pint --test routes/web.php tests/Feature/LegalPagesTest.php`: aprovado.
- `git diff --check`: aprovado.
- Rotas legais acessíveis sem autenticação; destinos legais válidos, conteúdo não vazio e ausência de `href="#"` nas três páginas.
- QA no Edge: três páginas legais a 1440, 768, 375 e 320 píxeis, sem overflow horizontal, com botões visíveis e altura mínima de 44 píxeis. Capturas de desktop e mobile inspecionadas.
- Aceitar, rejeitar, recarregar e navegar mantêm a escolha. Reabrir coloca o foco no título do aviso; guardar devolve o foco ao botão de origem.
- Verificadas também as páginas Início, Propriedades, Sobre, Contactos e Login: três links legais e escolha respeitada. Sem exceções JavaScript nas oito páginas verificadas.
- Cookies observados na navegação anónima local: `XSRF-TOKEN` e `laravel-session`. Cookie Lembrar-me confirmado no código; não foi criada uma conta nem iniciada sessão na base de dados local durante este QA.

## Referências de apoio

- RGPD: https://eur-lex.europa.eu/eli/reg/2016/679/oj?locale=pt
- Informação da CNPD sobre cookies: https://www.cnpd.pt/media/x2zdus50/nota-informativa-cnpd_cookies_20210625.pdf
- Direitos dos titulares: https://www.cnpd.pt/cidadaos/direitos/

O inventário cobre o código e o ambiente local. Recursos ou cookies acrescentados pelo alojamento de produção devem ser verificados nesse ambiente.
