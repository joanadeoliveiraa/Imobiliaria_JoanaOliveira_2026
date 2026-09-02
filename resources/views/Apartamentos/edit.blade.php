@extends('layouts.admin')

@section('title', 'Editar '.$apartamento->referencia)

@section('content')
    <div class="admin-page-heading">
        <div><p class="eyebrow">Propriedades</p><h1>Editar {{ $apartamento->referencia }}</h1><p>Atualize os dados e a disponibilidade da propriedade.</p></div>
        <a href="{{ route('apartamentos.show', $apartamento) }}" class="button button--outline">Ver página pública</a>
    </div>
    <div class="form-panel">
        <form action="{{ route('apartamentos.update', $apartamento) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('Apartamentos._form', ['apartamento' => $apartamento])
        </form>
    </div>
@endsection
