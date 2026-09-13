@extends('layouts.public')
@section('title', 'A minha conta — Olive Properties')
@section('content')
    @include('layouts.account-navigation')
    <div class="management-area">
        <div class="site-container management-main account-page">
            @isset($header)
                <header class="account-page__heading">{{ $header }}</header>
            @endisset
            {{ $slot }}
        </div>
    </div>
@endsection
