@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-folder-open"></i> Categorías del Foro</h2>
            @can('create', App\Models\Category::class)
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Categoría
                </a>
            @endcan
        </div>

        @forelse($categories as $category)
            <div class="card category-card mb-3" style="border-left-color: {{ $category->color ?? '#0d6efd' }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-2">
                                <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @endif
                                    {{ $category->name }}
                                </a>
                            </h5>
                            @if($category->description)
                                <p class="text-muted mb-0">{{ $category->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="mb-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-comments"></i> {{ $category->threads_count }} hilos
                                </span>
                            </div>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary">
                                Ver Categoría <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4>No hay categorías disponibles</h4>
                    <p class="text-muted">Las categorías aparecerán aquí una vez que sean creadas.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
