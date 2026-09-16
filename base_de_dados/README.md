# Base de dados do site

`olive_properties.sql` contém a estrutura e todos os registos da base de dados MySQL configurada no site no momento da exportação, incluindo utilizadores, clientes, apartamentos, vendas, atividades e pagamentos simulados. Inclui também tabelas internas do Laravel, triggers, rotinas e eventos existentes.

## Restaurar

1. No MySQL 8.4 ou compatível, crie uma base de dados vazia chamada `olive_properties` com codificação `utf8mb4` (ou escolha outro nome).
2. No phpMyAdmin, selecione essa base de dados, abra **Importar** e escolha `olive_properties.sql`.
3. Configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` no `.env` do projeto para a base de dados de destino.
4. Execute `php artisan config:clear`.

Em alternativa ao phpMyAdmin, abra o cliente MySQL na raiz do projeto:

```text
mysql -u root -p olive_properties
```

E execute no cliente:

```sql
SOURCE base_de_dados/olive_properties.sql;
```

A importação substitui tabelas com o mesmo nome: use uma base de dados vazia para preservar dados existentes. Não execute `migrate:fresh` após importar, pois elimina os dados restaurados.

## Atualizar a cópia

Na raiz do projeto, com PHP e `mysqldump` disponíveis no PATH:

```text
php base_de_dados/exportar.php
```

O script usa a configuração do Laravel e substitui o SQL apenas depois de uma exportação bem-sucedida. O ficheiro é uma cópia pontual, não uma sincronização automática.

O SQL contém dados pessoais e dados de autenticação; fica excluído do Git pelo `.gitignore` desta pasta, mas está disponível localmente para copiar junto com o projeto. Guarde-o num local privado.

As fotografias dos imóveis são ficheiros em `storage/app/public` e não fazem parte do SQL. Para transferir o site com essas imagens, copie também essa pasta e execute `php artisan storage:link` no destino.
