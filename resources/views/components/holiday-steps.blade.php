@php
    $steps = [
        ['label' => 'Escolher', 'title' => 'Encontre a sua casa de férias.', 'text' => 'Explore a nossa seleção no Algarve e descubra o espaço que combina com os seus dias de descanso. Localização, conforto e privacidade, ao seu ritmo.', 'link' => route('apartamentos.index'), 'action' => 'Explorar casas'],
        ['label' => 'Planear', 'title' => 'Escolha os seus dias no Algarve.', 'text' => 'Defina as datas de chegada e partida e partilhe connosco o que procura para a sua estadia. Fale com a equipa para verificar a disponibilidade da casa escolhida.', 'link' => route('contactos'), 'action' => 'Planear a estadia'],
        ['label' => 'Confirmar', 'title' => 'Tudo claro, antes de chegar.', 'text' => 'Reveja os detalhes da casa, as datas e o valor da estadia com a nossa equipa. Confirme as condições da reserva e os próximos passos antes de finalizar.', 'link' => route('contactos'), 'action' => 'Falar com a equipa'],
        ['label' => 'Desfrutar', 'title' => 'Chegue. Desligue. Sinta-se em casa.', 'text' => 'Com a reserva confirmada, combine os detalhes da chegada com a equipa. Depois, é tempo de descobrir o Algarve e desfrutar da sua casa de férias.', 'link' => route('apartamentos.index'), 'action' => 'Descobrir a coleção'],
    ];
@endphp
<section id="como-reservar" class="section holiday-journey" aria-labelledby="holiday-title" x-data="{ current: 0 }">
    <div class="site-container">
        <div class="holiday-journey__heading"><div><p class="eyebrow">A sua próxima estadia</p><h2 id="holiday-title" class="section-title">As suas férias, passo a passo.</h2></div><p>Casas de férias de luxo no Algarve.<br>Da escolha à chegada, com atenção a cada detalhe.</p></div>
        <div class="holiday-journey__card">
            <div class="holiday-journey__image"><img src="{{ asset('images/Alg011.png') }}" alt="Casa de férias com piscina e vista sobre o Algarve ao pôr do sol" loading="lazy" width="1476" height="841"><span>O Algarve, ao seu ritmo.</span></div>
            <div class="holiday-journey__body" role="region" aria-roledescription="carrossel" aria-label="Como reservar a sua estadia" @keydown.right.prevent="current = Math.min(3, current + 1)" @keydown.left.prevent="current = Math.max(0, current - 1)">
                <div class="holiday-journey__tabs" aria-label="Escolher um passo">
                    @foreach($steps as $index => $step)
                        <button type="button" @click="current = {{ $index }}" :aria-current="current === {{ $index }} ? 'step' : null" :class="{ 'is-active': current === {{ $index }} }" aria-controls="holiday-slide-{{ $index }}"><span>0{{ $index + 1 }}</span>{{ $step['label'] }}</button>
                    @endforeach
                </div>
                <div class="holiday-journey__viewport">
                    <div class="holiday-journey__track" :style="'transform: translateX(-' + current * 100 + '%)'">
                        @foreach($steps as $index => $step)
                            <article id="holiday-slide-{{ $index }}" class="holiday-journey__slide" role="group" aria-roledescription="slide" aria-label="{{ $index + 1 }} de 4" :aria-hidden="current !== {{ $index }}" :inert="current !== {{ $index }}">
                                <p class="eyebrow">Passo 0{{ $index + 1 }}</p><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p><a href="{{ $step['link'] }}" class="holiday-journey__link">{{ $step['action'] }} <span aria-hidden="true">↗</span></a>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="holiday-journey__controls"><span aria-live="polite" aria-atomic="true" x-text="'Passo 0' + (current + 1) + ' de 04'">Passo 01 de 04</span><div><button type="button" @click="current--" :disabled="current === 0" aria-label="Passo anterior">←</button><button type="button" @click="current++" :disabled="current === 3" aria-label="Passo seguinte">→</button></div></div>
            </div>
        </div>
    </div>
</section>
