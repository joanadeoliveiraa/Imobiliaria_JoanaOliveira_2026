@extends('layouts.client')
@section('title', 'Nova reserva — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Nova reserva · passo 1 de 4</p><h1>Escolha a sua estadia</h1><p>Selecione a propriedade e as datas. A disponibilidade e o valor serão confirmados no servidor.</p></header>
@include('layouts.management-feedback')
<form class="client-panel client-booking-form" method="POST" action="{{ route('client.reservations.start') }}">
    @csrf
    <div class="field"><label for="apartamento_id">Propriedade *</label><select id="apartamento_id" name="apartamento_id" required>
        <option value="">Selecione uma propriedade</option>
        @foreach($apartamentos as $apartamento)<option value="{{ $apartamento->id }}" @selected(old('apartamento_id', request('apartamento')) == $apartamento->id)>{{ $apartamento->referencia }} · {{ $apartamento->tipologia }} · {{ $apartamento->morada }}</option>@endforeach
    </select>@error('apartamento_id')<span class="field-error">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="data_entrada">Check-in *</label><input id="data_entrada" type="date" name="data_entrada" value="{{ old('data_entrada') }}" min="{{ today()->toDateString() }}" required>@error('data_entrada')<span class="field-error">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="data_saida">Check-out *</label><input id="data_saida" type="date" name="data_saida" value="{{ old('data_saida') }}" required>@error('data_saida')<span class="field-error">{{ $message }}</span>@enderror</div>
    <button class="button button--primary" type="submit">Consultar resumo</button>
</form>
@endsection
