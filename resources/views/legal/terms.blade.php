@extends('legal.layout')
@section('title', 'Termos e Condições — Olive Properties')
@section('legal_title', 'Termos e Condições')
@section('legal_intro', 'Condições de utilização do website e da área de gestão Olive Properties.')
@section('legal_content')
<aside class="legal-pending">Documento em preparação. Os pontos [A PREENCHER] dependem de confirmação pela entidade responsável.</aside>
<section>
    <h2>1. Objeto e identificação</h2>
    <p>O website permite consultar propriedades, pesquisar o catálogo e aceder a informações de contacto. A área reservada permite gerir contas e, para administradores, propriedades, clientes e registos de vendas e reservas.</p>
    <p class="legal-pending">[A PREENCHER: denominação legal da entidade exploradora, NIF, sede, registo e licenças aplicáveis à atividade efetivamente exercida.]</p>
</section>
<section>
    <h2>2. Utilização da plataforma</h2>
    <p>O utilizador deve fornecer informação correta, proteger as suas credenciais e respeitar os direitos de terceiros. Não deve tentar aceder a dados ou funções para os quais não tem autorização, nem comprometer a segurança do serviço.</p>
    <p>A criação de uma conta não concede acesso às funções de administração.</p>
</section>
<section>
    <h2>3. Informação sobre propriedades</h2>
    <p>O catálogo apresenta referências, tipologias, localização, áreas, preços, fotografias e estados de disponibilidade. A consulta de uma propriedade não confirma uma reserva. As características, o preço aplicável e a disponibilidade para datas concretas devem ser confirmados com a equipa antes de assumir qualquer compromisso.</p>
</section>
<section>
    <h2>4. Reservas e pagamentos</h2>
    <p>Os registos de reservas são geridos na área de administração. O processo de nova reserva inclui um pagamento exclusivamente simulado: permite escolher um método de demonstração, testar aprovação ou recusa e gerar uma confirmação imprimível. Não são cobrados valores nem recolhidos dados bancários reais; o documento gerado não tem valor fiscal. A aplicação não disponibiliza pagamentos reais ou um processo público de contratação.</p>
    <p class="legal-pending">[A PREENCHER: condições de contratação efetivamente aplicáveis, confirmação, preços e encargos, pagamentos, cancelamentos, reembolsos e regras de estadia, antes de disponibilizar esses serviços.]</p>
</section>
<section>
    <h2>5. Disponibilidade e responsabilidades</h2>
    <p>O serviço pode sofrer interrupções por manutenção ou problemas técnicos. Caso encontre informação incorreta ou uma falha, contacte a equipa. Estes termos não afastam direitos obrigatórios dos utilizadores nem responsabilidades que não possam ser excluídas por lei.</p>
</section>
<section>
    <h2>6. Propriedade intelectual</h2>
    <p>A utilização de textos, fotografias, elementos gráficos e marcas deve respeitar os direitos dos respetivos titulares. A disponibilização de conteúdos no website não concede, por si só, autorização para a sua exploração comercial.</p>
</section>
<section>
    <h2>7. Privacidade e cookies</h2>
    <p>Consulte a <a href="{{ route('legal.privacy') }}">Política de Privacidade</a> e a <a href="{{ route('legal.cookies') }}">Política de Cookies</a> para conhecer o tratamento de dados e o armazenamento no navegador.</p>
</section>
<section>
    <h2>8. Contactos e resolução de litígios</h2>
    <p>O website apresenta o email <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a> e o telefone <a href="tel:+351289000000">+351 289 000 000</a>. A versão atual do formulário de contacto não envia nem guarda mensagens; utilize um contacto direto confirmado pela entidade.</p>
    <p class="legal-pending">[A PREENCHER: validar os contactos publicados e identificar os meios de reclamação, entidade de resolução alternativa de litígios e demais informação obrigatória, conforme aplicável.]</p>
</section>
<section>
    <h2>9. Alterações dos termos</h2>
    <p>Estes termos devem acompanhar alterações às funcionalidades e condições do serviço, respeitando os direitos e compromissos já assumidos.</p>
    <p class="legal-pending">[A PREENCHER: data de aprovação e entrada em vigor.]</p>
</section>
@endsection
