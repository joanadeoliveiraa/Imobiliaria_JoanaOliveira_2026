# Reservas com pagamento simulado

A área administrativa permite escolher cliente, propriedade disponível e datas em `/vendas/create`, rever o total na página de pagamento e simular aprovação ou recusa. Não existe integração bancária nem recolha de dados de cartão. O total corresponde ao preço semanal multiplicado pelas noites e dividido por sete, arredondado aos cêntimos no servidor.

O rascunho fica na sessão durante 30 minutos, associado ao administrador. Uma recusa não cria reserva. A aprovação verifica novamente preço e disponibilidade numa transação, cria a reserva e o registo em `pagamentos_simulados` e marca a propriedade indisponível, mantendo o modelo de disponibilidade existente. Repetir o pagamento do mesmo rascunho não duplica a reserva.

A confirmação contém os dados guardados no momento da aprovação e permite imprimir ou guardar PDF pelo navegador. Pode voltar a abrir-se através de «Confirmação / Imprimir» nos detalhes da reserva. Alterações posteriores à reserva não reescrevem este comprovativo histórico. O documento identifica expressamente a simulação e não tem valor fiscal.

A migração acrescenta apenas a tabela de pagamentos simulados. Não executa seeders nem modifica reservas antigas. Noutros ambientes, aplicar `php artisan migrate` e `npm run build`.

Os testes de checkout cobrem aprovação, recusa e nova tentativa, repetição, concorrência entre rascunhos, preço alterado, expiração, validação, controlo de acesso e preservação do comprovativo. Executar `php artisan test --compact`.
