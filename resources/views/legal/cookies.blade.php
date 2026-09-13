@extends('legal.layout')
@section('title', 'Política de Cookies — Olive Properties')
@section('legal_title', 'Política de Cookies')
@section('legal_intro', 'Utilizamos cookies técnicos para manter a sessão e proteger a utilização da plataforma.')
@section('legal_content')
<section>
    <h2>1. O que são cookies?</h2>
    <p>São pequenos ficheiros guardados pelo navegador e enviados ao website nos pedidos seguintes. Permitem, por exemplo, reconhecer uma sessão autenticada. O armazenamento local do navegador é uma tecnologia distinta, usada aqui para recordar a sua escolha sobre este aviso.</p>
</section>
<section>
    <h2>2. Cookies utilizados pela aplicação</h2>
    <p>Na versão atual foram identificados os seguintes cookies próprios. Não estão integradas ferramentas de publicidade ou analytics.</p>
    <dl class="cookie-inventory">
        <div><dt>Sessão — <code>{{ config('session.cookie') }}</code></dt><dd>Mantém a sessão, autenticação e mensagens entre páginas. Estritamente necessário. Duração: @if(config('session.expire_on_close')) até fechar o navegador @else {{ config('session.lifetime') }} minutos, renovados com a atividade @endif.</dd></div>
        <div><dt>Segurança — <code>XSRF-TOKEN</code></dt><dd>Ajuda a proteger os formulários contra pedidos forjados. Estritamente necessário. Duração: {{ config('session.lifetime') }} minutos, renovados com a atividade.</dd></div>
        <div><dt>Lembrar-me — <code>{{ auth()->guard('web')->getRecallerName() }}</code></dt><dd>Mantém a autenticação entre visitas apenas quando escolhe «Lembrar-me» no início de sessão. Duração máxima configurada: 400 dias. Pode terminar a sessão para remover este cookie.</dd></div>
    </dl>
</section>
<section>
    <h2>3. Escolha guardada neste dispositivo</h2>
    <p>A chave <code>olive-cookie-choice-v1</code> no armazenamento local guarda a opção «apenas necessários» durante 180 dias, sem enviar essa preferência para um serviço externo. Depois desse período, o aviso volta a aparecer. Se apagar os dados do website, a escolha também é removida.</p>
    <p>Os botões «Aceitar necessários» e «Rejeitar não essenciais» guardam a mesma configuração, porque não existem categorias opcionais ativas. Não é necessário autorizar os cookies indispensáveis ao funcionamento do serviço solicitado.</p>
</section>
<section>
    <h2>4. Gerir as preferências</h2>
    <p>Pode voltar a abrir o aviso neste dispositivo. Não existem atualmente categorias opcionais para configurar.</p>
    <button type="button" class="button button--outline" x-data @click="$dispatch('open-cookie-notice')">Rever escolha de cookies</button>
    <p>Nas definições de privacidade do navegador pode consultar, bloquear ou apagar cookies e armazenamento local. Bloquear os cookies técnicos pode impedir o início de sessão ou o envio de formulários. Para deixar de usar «Lembrar-me», termine a sessão e volte a entrar sem selecionar essa opção.</p>
    <noscript><p>O aviso interativo requer JavaScript. Pode gerir os dados deste website nas definições do navegador.</p></noscript>
</section>
<section>
    <h2>5. Recursos externos e alterações</h2>
    <p>O dashboard utiliza a biblioteca de gráficos Chart.js, carregada através de jsDelivr. Este pedido externo não constitui, por si só, prova da instalação de cookies de analytics. A configuração do alojamento e quaisquer integrações futuras devem ser verificadas antes da publicação.</p>
    <p>Se forem introduzidos cookies opcionais, esta política e o mecanismo de preferências terão de ser atualizados antes da sua ativação. Para questões sobre dados pessoais, consulte a <a href="{{ route('legal.privacy') }}">Política de Privacidade</a>.</p>
</section>
@endsection
