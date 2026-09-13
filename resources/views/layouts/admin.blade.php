@extends('layouts.public')
@section('content')
    @include('layouts.account-navigation')
    <div class="management-area">
        <div class="site-container management-main">
            @yield('admin_content')
        </div>
    </div>
    @include('layouts.delete-confirmation')
@endsection
