<ol class="booking-steps no-print" aria-label="Passos da reserva">
    @foreach([1 => 'Reserva', 2 => 'Pagamento simulado', 3 => 'Confirmação'] as $number => $label)
        <li @class(['is-current' => $step === $number, 'is-complete' => $step > $number]) @if($step === $number) aria-current="step" @endif>
            <span>{{ $number }}</span>{{ $label }}
        </li>
    @endforeach
</ol>
