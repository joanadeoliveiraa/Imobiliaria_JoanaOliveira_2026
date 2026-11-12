# Pedidos de contacto

O formulário público em `/contactos` guarda pedidos em `pedidos_contacto`. A administração consulta-os em `/backoffice/contactos`, protegida por `auth` e `admin`. O histórico de alterações e as respostas enviadas ficam nas tabelas `eventos_contacto` e `respostas_contacto`. Não há eliminação permanente na interface; arquivar conserva o pedido.

Para atualizar uma instalação existente, execute `php artisan migrate`. O formulário usa CSRF, validação do Laravel, limites de caracteres e um limite de cinco submissões por dez minutos por endereço IP. Após gravação, redireciona para a página de contactos, evitando repetição pelo refresh. As mensagens e notas são apresentadas como texto escapado.

## Email simulado e real

O `.env` local usa `MAIL_MAILER=log`. Nesse modo, o backoffice permite responder e guarda a resposta como **email simulado**, atualizando o pedido para `Respondido`. A interface identifica claramente que se trata de um teste e que a mensagem não foi entregue ao destinatário.

Configure um serviço de envio real no `.env`, por exemplo SMTP:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=servidor-do-provedor
MAIL_PORT=587
MAIL_USERNAME=utilizador-do-provedor
MAIL_PASSWORD=segredo-do-provedor
MAIL_FROM_ADDRESS=remetente-verificado@dominio.pt
MAIL_FROM_NAME="Olive Properties"
```

Use os valores do provedor, um endereço remetente verificado e `php artisan config:clear` após alterar a configuração. O sistema envia de forma síncrona e só guarda uma resposta real após o transporte aceitar o email. Se o envio real falhar, conserva o estado e apresenta um erro. Os transportes `log` e `array` são sempre marcados como simulação. Uma aceitação pelo servidor de email não garante entrega na caixa de entrada; confirme a entregabilidade no provedor.

No ambiente atual não há SMTP configurado, pelo que não é feito um envio externo real. Os testes validam o registo do email simulado e simulam também uma falha de transporte real para confirmar que o histórico não regista um envio inexistente.
