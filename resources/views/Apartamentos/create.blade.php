@extends('layouts.admin')

@section('title', 'Adicionar propriedade')

@section('content')
    <div class="admin-page-heading">
        <div><p class="eyebrow">Propriedades</p><h1>Adicionar propriedade</h1><p>Registe uma nova propriedade no portefólio.</p></div>
    </div>
    <div class="form-panel">
        <form action="{{ route('apartamentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('Apartamentos._form')
        </form>
    </div>
@endsection
