@extends('legal.layout')
@section('title', 'Política de Cookies — Olive Properties')
@section('legal_title', 'Política de Cookies')
@section('legal_intro', 'A presente Política de Cookies explica a utilização de cookies e tecnologias semelhantes na plataforma Olive Properties.')
@section('legal_content')
<p>Atualmente, a plataforma utiliza apenas cookies técnicos e mecanismos de armazenamento necessários ao funcionamento, segurança e manutenção das preferências do utilizador. Não são utilizados cookies para publicidade, marketing ou análise estatística de utilização.</p>
<section>
    <h2>1. O que são cookies?</h2>
    <p>Cookies são pequenos ficheiros de informação armazenados pelo navegador no dispositivo do utilizador quando visita um website.</p>
    <p>Estes ficheiros permitem, entre outras funcionalidades, manter uma sessão autenticada, garantir o correto funcionamento dos formulários e recordar determinadas opções durante a utilização da plataforma.</p>
    <p>A plataforma poderá também utilizar o armazenamento local do navegador (localStorage). Embora não seja tecnicamente um cookie, esta tecnologia permite guardar determinadas preferências diretamente no dispositivo do utilizador, sem que essas informações tenham necessariamente de ser transmitidas ao servidor.</p>
</section>
<section>
    <h2>2. Cookies utilizados pela plataforma</h2>
    <p>Na versão atual da Olive Properties são utilizados os seguintes cookies próprios necessários ao funcionamento da aplicação. O nome do cookie de sessão depende da configuração da aplicação; o nome apresentado abaixo corresponde à configuração em uso.</p>
    <dl class="cookie-inventory">
        <div>
            <dt>Cookie de sessão — <code>{{ config('session.cookie') }}</code></dt>
            <dd><strong>Finalidade:</strong> Mantém a sessão do utilizador, incluindo autenticação e informações necessárias à navegação entre páginas.</dd>
            <dd><strong>Categoria:</strong> Estritamente necessário.</dd>
            <dd><strong>Duração:</strong> @if(config('session.expire_on_close')) Até fechar o navegador. @else A sessão encontra-se configurada para {{ config('session.lifetime') }} minutos de inatividade, sendo renovada de acordo com a atividade e configuração da aplicação. @endif</dd>
        </div>
        <div>
            <dt>Cookie de segurança — <code>XSRF-TOKEN</code></dt>
            <dd><strong>Finalidade:</strong> Contribui para a proteção dos formulários e pedidos efetuados à aplicação contra ataques de falsificação de pedidos entre sites (CSRF).</dd>
            <dd><strong>Categoria:</strong> Estritamente necessário.</dd>
            <dd><strong>Duração:</strong> Associado à sessão da aplicação e à respetiva configuração, atualmente definida para {{ config('session.lifetime') }} minutos.</dd>
        </div>
        <div>
            <dt>Funcionalidade “Lembrar-me”</dt>
            <dd>Quando o utilizador seleciona a opção “Lembrar-me” durante o início de sessão, a aplicação poderá utilizar um cookie persistente de autenticação para permitir que a sessão seja reconhecida em visitas posteriores.</dd>
            <dd><strong>Categoria:</strong> Funcionalidade de autenticação solicitada pelo utilizador.</dd>
            <dd><strong>Duração máxima configurada:</strong> Até 400 dias.</dd>
            <dd>O utilizador poderá deixar de utilizar esta funcionalidade terminando a sessão e iniciando novamente sem selecionar a opção “Lembrar-me”. O nome técnico deste cookie pode variar em função da configuração da aplicação.</dd>
        </div>
    </dl>
</section>
<section>
    <h2>3. Armazenamento local e preferências</h2>
    <h3>Preferência relativa ao aviso de cookies</h3>
    <p>A chave <code>olive-cookie-choice-v1</code> é utilizada para recordar a escolha efetuada relativamente ao aviso de cookies. A preferência é mantida durante 180 dias. Depois desse período, o aviso poderá voltar a ser apresentado.</p>
    <p>Caso o utilizador elimine os dados do website através das definições do navegador, esta preferência também será removida. Esta informação é armazenada localmente no dispositivo e não é utilizada para publicidade ou análise de comportamento.</p>
    <p>Esta é a única chave de armazenamento local identificada no código atual. Não foi identificada uma preferência de modo claro/escuro nem utilização de sessionStorage.</p>
</section>
<section>
    <h2>4. Cookies estritamente necessários</h2>
    <p>Os cookies técnicos utilizados atualmente são necessários para funcionalidades essenciais da plataforma, nomeadamente:</p>
    <ul><li>autenticação;</li><li>manutenção da sessão;</li><li>segurança;</li><li>proteção dos formulários;</li><li>funcionamento adequado da área reservada.</li></ul>
    <p>Estes cookies não são utilizados para publicidade ou criação de perfis comerciais. A desativação ou bloqueio destes cookies através das configurações do navegador poderá impedir o correto funcionamento de determinadas funcionalidades, incluindo o início de sessão e o envio de formulários.</p>
</section>
<section>
    <h2>5. Cookies opcionais</h2>
    <p>Atualmente, a Olive Properties não utiliza cookies opcionais destinados a publicidade, marketing, personalização publicitária, analytics, acompanhamento do utilizador entre websites ou criação de perfis comerciais.</p>
    <p>Consequentemente, não existem atualmente categorias opcionais que necessitem de consentimento para serem ativadas.</p>
    <p>Se futuramente forem introduzidas tecnologias opcionais que dependam de consentimento, estas não deverão ser carregadas antes da escolha do utilizador. Nesse caso, deverão ser atualizados o aviso de cookies, o mecanismo de gestão de preferências, esta Política de Cookies e a Política de Privacidade, quando aplicável.</p>
</section>
<section>
    <h2>6. Gestão das preferências</h2>
    <p>O utilizador pode consultar, bloquear ou eliminar cookies e dados armazenados localmente através das definições de privacidade do respetivo navegador. A eliminação dos cookies poderá terminar sessões autenticadas e eliminar preferências anteriormente guardadas. O bloqueio de cookies estritamente necessários poderá impedir o correto funcionamento de determinadas funcionalidades da Olive Properties.</p>
    <button type="button" class="button button--outline" x-data @click="$dispatch('open-cookie-notice')">Rever escolha de cookies</button>
    <p>Este controlo volta a abrir o aviso existente. Como não existem cookies opcionais ativos, os botões “Aceitar necessários” e “Rejeitar não essenciais” guardam a mesma preferência por utilizar apenas os cookies necessários.</p>
    <noscript><p>O aviso interativo requer JavaScript. Pode gerir os dados deste website nas definições do navegador.</p></noscript>
</section>
<section>
    <h2>7. Recursos externos</h2>
    <p>O dashboard administrativo utiliza a biblioteca Chart.js para apresentação de gráficos. Na configuração atual, esta biblioteca é carregada através da infraestrutura jsDelivr.</p>
    <p>O carregamento de um recurso externo poderá implicar a transmissão ao respetivo servidor de dados técnicos necessários à comunicação, como o endereço IP e informações técnicas associadas ao pedido.</p>
    <p>A utilização deste recurso não significa, por si só, que sejam utilizados cookies de publicidade ou analytics pela Olive Properties. Caso futuramente sejam adicionados novos serviços externos com utilização de cookies ou outras tecnologias de acompanhamento, deverá ser avaliada a necessidade de atualizar esta política e o respetivo mecanismo de consentimento antes da sua ativação.</p>
</section>
<section>
    <h2>8. Proteção de dados pessoais</h2>
    <p>Para obter informação adicional sobre o tratamento de dados pessoais realizado através da plataforma, consulte a <a href="{{ route('legal.privacy') }}">Política de Privacidade</a>.</p>
</section>
<section>
    <h2>9. Contactos</h2>
    <p>Para questões relacionadas com a utilização de cookies ou proteção de dados poderá contactar:</p>
    <address>Olive Properties<br>Rua das Oliveiras, 25<br>8200-000 Albufeira<br>Portugal</address>
    <p>Telefone: <a href="tel:+351289000000">+351 289 000 000</a><br>Email: <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a></p>
</section>
<section>
    <h2>10. Alterações à Política de Cookies</h2>
    <p>A presente Política de Cookies poderá ser atualizada sempre que ocorram alterações nas tecnologias utilizadas pela plataforma ou quando sejam introduzidos novos cookies, serviços externos ou funcionalidades relevantes.</p>
    <p>A versão atualizada será disponibilizada nesta página.</p>
    <p>Última atualização: 15 de setembro de 2026.</p>
</section>
@endsection
