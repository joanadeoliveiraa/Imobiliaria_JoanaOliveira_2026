@if(session('success'))
    <div class="alert alert--success no-print" role="status">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert--danger no-print" role="alert">
        <p>Verifique os dados indicados:</p>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
