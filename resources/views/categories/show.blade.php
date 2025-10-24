@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Category Header -->
        <div class="card mb-4" style="border-left: 4px solid {{ $category->color ?? '#0d6efd' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="mb-2">
                            @if($category->icon)
                                <i class="{{ $category->icon }}"></i>
                            @endif
                            {{ $category->name }}
                        </h2>
                        @if($category->description)
                            <p class="text-muted mb-0">{{ $category->description }}</p>
                        @endif
                    </div>
                    <a href="{{ route('threads.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Hilo
                    </a>
                </div>
            </div>
        </div>

        <!-- Threads List -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-comments"></i> Hilos de Discusión</h5>
            </div>
            <div class="card-body p-0">
                @forelse($threads as $thread)
                    <div class="thread-item p-3 border-bottom {{ $thread->is_pinned ? 'thread-pinned' : '' }} {{ $thread->is_locked ? 'thread-locked' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    @if($thread->is_pinned)
                                        <i class="fas fa-thumbtack text-warning" title="Fijado"></i>
                                    @endif
                                    @if($thread->is_locked)
                                        <i class="fas fa-lock text-muted" title="Bloqueado"></i>
                                    @endif
                                    <a href="{{ route('threads.show', $thread) }}" class="text-decoration-none text-dark">
                                        {{ $thread->title }}
                                    </a>
                                </h6>
                                <div class="text-muted small">
                                    por <strong>{{ $thread->user->name }}</strong>
                                    <i class="fas fa-clock ms-2"></i> {{ $thread->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="text-end ms-3">
                                <div class="text-muted small">
                                    <div><i class="fas fa-comment"></i> {{ $thread->posts_count }} respuestas</div>
                                    <div><i class="fas fa-eye"></i> {{ $thread->view_count }} vistas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h5>No hay hilos en esta categoría</h5>
                        <p class="text-muted">Sé el primero en iniciar una discusión.</p>
                        <a href="{{ route('threads.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Primer Hilo
                        </a>
                    </div>
                @endforelse
            </div>
            @if($threads->hasPages())
                <div class="card-footer bg-white">
                    {{ $threads->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
