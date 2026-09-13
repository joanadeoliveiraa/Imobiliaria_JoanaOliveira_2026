@props(['labels', 'values', 'money' => false])
<div class="apenas-impressao">
    <table class="table"><thead><tr><th>Designação</th><th>{{ $money ? 'Valor' : 'Reservas' }}</th></tr></thead><tbody>
        @forelse($labels as $index => $label)
            <tr><td>{{ $label }}</td><td>{{ $money ? number_format($values[$index] ?? 0, 2, ',', '.').' €' : ($values[$index] ?? 0) }}</td></tr>
        @empty
            <tr><td colspan="2">Sem dados para apresentar.</td></tr>
        @endforelse
    </tbody></table>
</div>
