@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3">Iniciar Sesión</h3>
                <p class="text-muted">El sistema de autenticación aún no está implementado. Este es un placeholder. Puedes implementar Laravel Breeze, Fortify o un controlador personalizado.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection
