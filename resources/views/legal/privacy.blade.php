@extends('legal.layout')
@section('title', 'Política de Privacidade — Olive Properties')
@section('legal_title', 'Política de Privacidade')
@section('legal_intro', 'Informação sobre os dados pessoais tratados através desta plataforma.')
@section('legal_content')
<aside class="legal-pending">Informação em preparação: os campos identificados como [A PREENCHER] devem ser completados e validados pelo responsável antes da publicação definitiva desta política.</aside>
<section>
    <h2>1. Responsável pelo tratamento</h2>
    <p>Olive Properties é o nome apresentado nesta plataforma de consulta de propriedades e gestão de clientes e reservas.</p>
    <p class="legal-pending">[A PREENCHER: identificação da entidade responsável, sede e contacto para proteção de dados; contacto do encarregado de proteção de dados, se aplicável.]</p>
    <p>Contacto atualmente apresentado no website: <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a>. A entidade responsável deve confirmar a sua utilização para pedidos relativos a dados pessoais.</p>
</section>
<section>
    <h2>2. Dados pessoais recolhidos</h2>
    <ul>
        <li>Conta de utilizador: nome, email, palavra-passe guardada sob a forma de hash e dados técnicos de autenticação.</li>
        <li>Registos de clientes introduzidos na área de gestão: nome, email, telefone, morada e NIF.</li>
        <li>Reservas: cliente associado, referência da propriedade, datas de entrada e saída e valor total.</li>
        <li>Formulário de contacto: nome, email, telefone opcional, assunto e mensagem transmitidos ao servidor. Na versão atual, o formulário não tem envio de email nem gravação da mensagem implementados.</li>
        <li>Dados técnicos de sessão, incluindo identificador de sessão e, conforme o armazenamento configurado, endereço IP e identificação do navegador.</li>
    </ul>
</section>
<section>
    <h2>3. Finalidades e fundamento do tratamento</h2>
    <p>Os dados permitem gerir contas e acessos, clientes e reservas, e proteger as operações da plataforma. As diligências pré-contratuais solicitadas pelo titular e a execução de contratos podem fundamentar os tratamentos necessários à prestação do serviço. Obrigações legais podem justificar a conservação de determinados registos.</p>
    <p class="legal-pending">[A PREENCHER: confirmar a base jurídica de cada finalidade, as obrigações legais concretas e, se invocado interesse legítimo para segurança, identificar esse interesse e a respetiva avaliação.]</p>
    <p>Os campos assinalados como obrigatórios são necessários para concluir a operação correspondente. Não foi identificado tratamento para publicidade, definição de perfis ou decisões automatizadas na aplicação.</p>
</section>
<section>
    <h2>4. Conservação dos dados</h2>
    <p>Os dados devem ser conservados apenas pelo período necessário à finalidade e às obrigações aplicáveis. A aplicação não define atualmente uma política automática de eliminação dos registos de clientes e reservas.</p>
    <p class="legal-pending">[A PREENCHER: prazos ou critérios de conservação por categoria, incluindo contas, clientes, reservas, registos técnicos e cópias de segurança.]</p>
    <p>A duração dos cookies está descrita na <a href="{{ route('legal.cookies') }}">Política de Cookies</a>.</p>
</section>
<section>
    <h2>5. Acesso e partilha de dados</h2>
    <p>A área de gestão está reservada a utilizadores com perfil de administrador. O dashboard carrega a biblioteca de gráficos Chart.js através de jsDelivr; esse pedido comunica dados técnicos, como o endereço IP, ao fornecedor do recurso.</p>
    <p class="legal-pending">[A PREENCHER: prestadores de alojamento, manutenção e email efetivamente contratados, destinatários, localização do tratamento e eventuais transferências internacionais e garantias aplicáveis.]</p>
</section>
<section>
    <h2>6. Direitos dos titulares</h2>
    <p>Nos termos aplicáveis, pode pedir acesso, retificação, apagamento, limitação e portabilidade dos dados, bem como opor-se ao tratamento. Quando o tratamento se basear no consentimento, pode retirá-lo sem afetar a licitude do tratamento anterior.</p>
    <p>Pode apresentar reclamação à <a href="https://www.cnpd.pt/cidadaos/direitos/">Comissão Nacional de Proteção de Dados</a>. Para exercer os seus direitos junto da entidade responsável, utilize o contacto indicado nesta política, após a sua confirmação.</p>
</section>
<section>
    <h2>7. Segurança</h2>
    <p>A aplicação utiliza autenticação, restrições de acesso à gestão, proteção dos formulários contra pedidos forjados e hash de palavras-passe. Estas medidas não eliminam todos os riscos.</p>
    <p class="legal-pending">[A PREENCHER: confirmar medidas operacionais de alojamento, HTTPS, cópias de segurança, controlo de acessos e resposta a incidentes.]</p>
</section>
<section>
    <h2>8. Alterações à política</h2>
    <p>Esta página deve ser atualizada quando se alterarem as finalidades, os dados tratados ou os prestadores envolvidos.</p>
    <p class="legal-pending">[A PREENCHER: data de aprovação e de entrada em vigor.]</p>
</section>
@endsection
