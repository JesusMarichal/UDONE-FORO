@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Welcome Section -->
        <div class="card mb-4">
            <div class="card-body bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h2><i class="fas fa-graduation-cap"></i> Bienvenido al Foro UDONE</h2>
                <p class="mb-0">Foro oficial de la Universidad de Oriente Núcleo Nueva Esparta. Comparte conocimientos, resuelve dudas y conecta con otros estudiantes.</p>
            </div>
        </div>

        <!-- Recent Threads -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-fire"></i> Hilos Recientes</h5>
            </div>
            <div class="card-body p-0">
                @forelse($recentThreads as $thread)
                    <div class="thread-item p-3 border-bottom {{ $thread->is_pinned ? 'thread-pinned' : '' }} {{ $thread->is_locked ? 'thread-locked' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    @if($thread->is_pinned)
                                        <i class="fas fa-thumbtack text-warning"></i>
                                    @endif
                                    @if($thread->is_locked)
                                        <i class="fas fa-lock text-muted"></i>
                                    @endif
                                    <a href="{{ route('threads.show', $thread) }}" class="text-decoration-none text-dark">
                                        {{ $thread->title }}
                                    </a>
                                </h6>
                                <div class="text-muted small">
                                    <span class="badge bg-primary">{{ $thread->category->name }}</span>
                                    por <strong>{{ $thread->user->name }}</strong>
                                    <i class="fas fa-clock ms-2"></i> {{ $thread->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="text-end ms-3">
                                <div class="text-muted small">
                                    <i class="fas fa-comment"></i> {{ $thread->posts_count }}
                                    <i class="fas fa-eye ms-2"></i> {{ $thread->view_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No hay hilos recientes todavía.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Categories -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-folder-open"></i> Categorías</h5>
            </div>
            <div class="card-body p-0">
                @forelse($categories as $category)
                    <div class="p-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                                @if($category->icon)
                                    <i class="{{ $category->icon }}"></i>
                                @endif
                                {{ $category->name }}
                            </a>
                        </h6>
                        <div class="text-muted small">
                            <i class="fas fa-comments"></i> {{ $category->threads_count }} hilos
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        No hay categorías disponibles.
                    </div>
                @endforelse
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                    Ver todas las categorías <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Popular Threads -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-star"></i> Hilos Populares</h5>
            </div>
            <div class="card-body p-0">
                @forelse($popularThreads as $thread)
                    <div class="p-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="{{ route('threads.show', $thread) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($thread->title, 50) }}
                            </a>
                        </h6>
                        <div class="text-muted small">
                            <i class="fas fa-eye"></i> {{ $thread->view_count }} vistas
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        No hay hilos populares.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
