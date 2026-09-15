@extends('legal.layout')
@section('title', 'Termos e Condições — Olive Properties')
@section('legal_title', 'Termos e Condições')
@section('legal_intro', 'Os presentes Termos e Condições regulam a utilização do website e das áreas reservadas da plataforma Olive Properties.')
@section('legal_content')
<p>Ao utilizar a plataforma, o utilizador compromete-se a fazê-lo de forma responsável e de acordo com as funcionalidades e condições aqui descritas.</p>
<section>
    <h2>1. Identificação e objeto</h2>
    <p>A Olive Properties é a designação utilizada nesta plataforma demonstrativa para apresentação e gestão de propriedades destinadas a estadias no Algarve.</p>
    <p>Dados de contacto:</p>
    <address>Olive Properties<br>Rua das Oliveiras, 25<br>8200-000 Albufeira<br>Portugal</address>
    <p>Telefone: <a href="tel:+351289000000">+351 289 000 000</a><br>Email: <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a></p>
    <p>O website permite:</p>
    <ul><li>consultar propriedades e a informação de cada propriedade;</li><li>pesquisar e filtrar o catálogo;</li><li>consultar informação de disponibilidade apresentada pela plataforma;</li><li>consultar informações institucionais e de contacto;</li><li>enviar pedidos de contacto;</li><li>aceder às funcionalidades reservadas aos utilizadores autenticados.</li></ul>
    <p>A plataforma dispõe ainda de funcionalidades administrativas destinadas exclusivamente a utilizadores autorizados.</p>
</section>
<section>
    <h2>2. Utilização da plataforma</h2>
    <p>O utilizador compromete-se a utilizar a Olive Properties de forma adequada, lícita e de acordo com as funcionalidades disponibilizadas.</p>
    <p>O utilizador não deve:</p>
    <ul><li>fornecer intencionalmente informações falsas ou enganosas;</li><li>utilizar dados pertencentes a terceiros sem autorização;</li><li>tentar aceder a contas, reservas, mensagens ou informação pertencente a outros utilizadores;</li><li>tentar aceder a funcionalidades administrativas sem autorização;</li><li>contornar mecanismos de autenticação ou controlo de acesso;</li><li>interferir com o funcionamento ou segurança da plataforma;</li><li>utilizar a plataforma para transmitir conteúdo ilícito, malicioso ou abusivo.</li></ul>
    <p>A utilização abusiva ou não autorizada poderá justificar a limitação ou bloqueio do acesso às funcionalidades afetadas.</p>
</section>
<section>
    <h2>3. Contas de utilizador</h2>
    <p>Determinadas funcionalidades da Olive Properties exigem autenticação. O utilizador é responsável por fornecer informação correta, manter os seus dados atualizados, proteger as suas credenciais de acesso, não partilhar a palavra-passe com terceiros e terminar a sessão quando utilizar um dispositivo partilhado ou público.</p>
    <p>A criação de uma conta de cliente não concede acesso às funcionalidades administrativas. Os diferentes perfis possuem permissões distintas: a gestão de propriedades, clientes, reservas e pedidos de contacto encontra-se reservada aos administradores.</p>
</section>
<section>
    <h2>4. Área reservada do cliente</h2>
    <p>Na versão atual, um utilizador autenticado com perfil de cliente pode consultar e atualizar o seu perfil de utilizador. Ainda não existe uma Área de Cliente com consulta das próprias reservas, histórico de estadias, criação ou cancelamento de reservas, consulta de pedidos de contacto ou respostas da equipa.</p>
    <p>Essas operações de reserva e acompanhamento de comunicações são efetuadas através da área administrativa, por utilizadores autorizados. Informação administrativa interna e dados de outros clientes não são disponibilizados às contas de cliente.</p>
</section>
<section>
    <h2>5. Informação sobre propriedades</h2>
    <p>O catálogo poderá apresentar referência, designação, localização, tipologia, área, preço, fotografias, descrição, características e informação de disponibilidade das propriedades.</p>
    <p>A Olive Properties procura manter a informação apresentada atualizada e coerente com os dados existentes na plataforma. As fotografias e elementos visuais destinam-se à apresentação das propriedades.</p>
    <p>A simples consulta de uma propriedade não constitui uma reserva. A disponibilidade para o período solicitado é novamente validada no momento da criação da reserva, para evitar conflitos com reservas entretanto registadas.</p>
</section>
<section>
    <h2>6. Reservas</h2>
    <p>As reservas são criadas e geridas por administradores autorizados, na área de gestão. A versão atual não permite a um cliente iniciar ou confirmar uma reserva através da sua conta.</p>
    <p>Para criar a reserva são utilizados a identificação do cliente registado, a propriedade selecionada, as datas de entrada e saída, o número de noites e o valor da estadia. Antes da confirmação, a aplicação verifica o estado da propriedade e a sobreposição de datas com outras reservas.</p>
    <p>O estado apresentado é derivado das datas da reserva: confirmada, em curso ou concluída, conforme o período da estadia. O histórico de reservas por cliente está disponível apenas na área de administração.</p>
</section>
<section>
    <h2>7. Preços</h2>
    <p>Os preços apresentados correspondem aos valores registados para as propriedades demonstradas no sistema. No processo administrativo de reserva, o valor da estadia é calculado a partir do preço configurado para a propriedade e do número de noites, sendo apresentado antes da simulação do pagamento.</p>
    <p>O preço e a disponibilidade são novamente verificados antes da confirmação. A plataforma não apresenta encargos adicionais não indicados no processo.</p>
</section>
<section>
    <h2>8. Pagamentos simulados</h2>
    <p>A versão atual da Olive Properties utiliza um processo de pagamento exclusivamente simulado para fins de demonstração das funcionalidades da aplicação. Não são processados pagamentos bancários reais nem recolhidos números reais de cartões de pagamento, códigos CVV/CVC, credenciais bancárias ou dados destinados à execução de uma transação financeira real.</p>
    <p>O administrador pode selecionar um método demonstrativo e simular a aprovação ou recusa da operação. Uma recusa não cria a reserva. Qualquer confirmação ou documento gerado tem natureza exclusivamente demonstrativa: não constitui fatura, recibo fiscal, comprovativo bancário ou prova da realização de um pagamento real. Nenhum valor monetário real é transferido através desta funcionalidade.</p>
</section>
<section>
    <h2>9. Cancelamentos e alterações</h2>
    <p>Na versão atual, apenas administradores autorizados podem editar ou cancelar reservas na área de gestão. O cliente não dispõe de um controlo de cancelamento ou alteração na sua conta.</p>
    <p>As alterações de datas são verificadas contra reservas sobrepostas. O cancelamento administrativo elimina o registo da reserva; não existe um estado de cancelamento apresentado ao cliente. Como não existem pagamentos reais, a plataforma não executa reembolsos bancários.</p>
</section>
<section>
    <h2>10. Pedidos de contacto e comunicações</h2>
    <p>O utilizador pode contactar a Olive Properties através dos meios disponibilizados no website. O formulário público envia um pedido que é guardado na plataforma para acompanhamento e resposta.</p>
    <p>Os administradores podem consultar o pedido, registar estado e notas internas, e responder por email quando o serviço de envio estiver configurado. Na versão atual, o utilizador não pode consultar os seus pedidos, as respostas ou as notas administrativas através da sua conta.</p>
    <p>Os dados pessoais associados às comunicações são tratados nos termos da <a href="{{ route('legal.privacy') }}">Política de Privacidade</a>.</p>
</section>
<section>
    <h2>11. Disponibilidade da plataforma</h2>
    <p>A Olive Properties procura manter a plataforma disponível e funcional. Contudo, poderão ocorrer interrupções temporárias decorrentes de manutenção, atualizações, problemas técnicos, falhas de infraestrutura, situações de segurança ou circunstâncias fora do controlo da aplicação.</p>
    <p>Não é garantida a disponibilidade permanente e ininterrupta de todas as funcionalidades. Sempre que possível, os problemas técnicos identificados deverão ser corrigidos de forma a restabelecer o funcionamento normal da plataforma.</p>
</section>
<section>
    <h2>12. Segurança</h2>
    <p>O utilizador não deverá tentar comprometer os mecanismos de segurança da aplicação ou obter acesso não autorizado a recursos protegidos. A plataforma utiliza autenticação e controlo de acesso para separar as funcionalidades disponíveis aos diferentes tipos de utilizador. O acesso administrativo encontra-se reservado aos perfis autorizados.</p>
    <p>A existência destas medidas não elimina todos os riscos inerentes à utilização de sistemas informáticos. Caso o utilizador identifique uma falha de segurança ou comportamento inesperado, poderá comunicá-lo através dos contactos disponibilizados pela Olive Properties.</p>
</section>
<section>
    <h2>13. Propriedade intelectual</h2>
    <p>Os textos, elementos gráficos, fotografias, logótipos, design, estrutura e restantes conteúdos apresentados através da plataforma poderão encontrar-se protegidos por direitos de propriedade intelectual dos respetivos titulares.</p>
    <p>A disponibilização destes conteúdos no website não concede ao utilizador autorização para reprodução comercial, distribuição não autorizada, alteração, exploração ou utilização fora dos limites permitidos pela legislação aplicável. A utilização de conteúdos pertencentes a terceiros deverá respeitar os direitos dos respetivos titulares.</p>
</section>
<section>
    <h2>14. Responsabilidade</h2>
    <p>A Olive Properties procura assegurar que a informação apresentada na plataforma é correta e que as funcionalidades operam de acordo com o comportamento previsto. Contudo, poderão ocorrer erros técnicos, informação temporariamente desatualizada ou indisponibilidade de determinadas funcionalidades.</p>
    <p>Sempre que seja identificada informação incorreta ou uma falha, o utilizador poderá contactar a Olive Properties para solicitar esclarecimentos.</p>
    <p>Nada nos presentes Termos e Condições pretende excluir ou limitar direitos que sejam imperativamente reconhecidos ao utilizador pela legislação aplicável, nem responsabilidades que legalmente não possam ser excluídas ou limitadas.</p>
</section>
<section>
    <h2>15. Privacidade e proteção de dados</h2>
    <p>O tratamento dos dados pessoais realizado através da Olive Properties encontra-se descrito na <a href="{{ route('legal.privacy') }}">Política de Privacidade</a>. A utilização de cookies e tecnologias semelhantes encontra-se descrita na <a href="{{ route('legal.cookies') }}">Política de Cookies</a>.</p>
</section>
<section>
    <h2>16. Reclamações e resolução de questões</h2>
    <p>Para questões relacionadas com a utilização da plataforma, reservas, pedidos de contacto ou outras funcionalidades, o utilizador poderá contactar:</p>
    <address>Olive Properties<br>Rua das Oliveiras, 25<br>8200-000 Albufeira<br>Portugal</address>
    <p>Telefone: <a href="tel:+351289000000">+351 289 000 000</a><br>Email: <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a></p>
    <p>Os utilizadores poderão ainda recorrer aos meios de reclamação e resolução de litígios que sejam legalmente aplicáveis à situação concreta.</p>
</section>
<section>
    <h2>17. Alterações aos Termos e Condições</h2>
    <p>Os presentes Termos e Condições poderão ser atualizados quando ocorram alterações relevantes nas funcionalidades da plataforma, condições de utilização, processo de reservas, métodos de pagamento, regras aplicáveis aos utilizadores ou exigências legais.</p>
    <p>As alterações não prejudicam direitos ou compromissos anteriormente constituídos quando estes devam ser respeitados nos termos da legislação aplicável. A versão atualizada será disponibilizada nesta página.</p>
</section>
<section>
    <h2>18. Versão dos Termos</h2>
    <p>Última atualização: 15 de setembro de 2026.</p>
</section>
@endsection
