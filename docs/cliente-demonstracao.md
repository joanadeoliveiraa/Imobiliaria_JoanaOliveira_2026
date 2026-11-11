# Cliente de demonstração

Em ambiente local, definir no `.env` uma palavra-passe aleatória com pelo menos 16 caracteres:

```dotenv
SEED_CLIENT_PASSWORD="colocar-aqui-a-palavra-passe-local"
```

Executar:

```shell
php artisan config:clear
php artisan db:seed --class=ClientDemoSeeder
```

Entrar em `/login` com `joana@oliveproperties.test` e a palavra-passe configurada. O destino é `/minha-area`.

O nome é Joana Oliveira. O perfil `user` corresponde a `tipo=cliente` nesta aplicação. Não existe coluna de estado: a conta está habilitada para autenticação, com email verificado. Não são necessárias migrations.

O Seeder cria também o registo de cliente associado. Pode ser repetido sem duplicar registos ou redefinir palavras-passe. Recusa um email pertencente a outro perfil e não altera administradores. Executar este Seeder individualmente; não depende do Seeder administrativo. Apenas funciona em `local` e `testing`.

Alterar a variável depois da criação não altera a palavra-passe da conta; usar a alteração de palavra-passe no perfil. Não guardar credenciais locais no controlo de versões.

As reservas, histórico, detalhes de pagamento e comprovativos usam a Área de Cliente existente. Os pagamentos atuais são simulados; o comprovativo é uma página de impressão e não uma fatura ou PDF gerado no servidor. O Seeder não cria reservas nem pagamentos.
