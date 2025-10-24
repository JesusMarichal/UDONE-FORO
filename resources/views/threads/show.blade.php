@extends('layouts.app')

@section('title', $thread->title)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Thread Header -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('categories.show', $thread->category) }}">{{ $thread->category->name }}</a></li>
                                <li class="breadcrumb-item active">{{ $thread->title }}</li>
                            </ol>
                        </nav>
                        <h2 class="mb-2">
                            @if($thread->is_pinned)
                                <i class="fas fa-thumbtack text-warning" title="Fijado"></i>
                            @endif
                            @if($thread->is_locked)
                                <i class="fas fa-lock text-muted" title="Bloqueado"></i>
                            @endif
                            {{ $thread->title }}
                        </h2>
                    </div>
                    <div class="text-end">
                        @can('update', $thread)
                            <a href="{{ route('threads.edit', $thread) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        @endcan
                        @can('moderate', $thread)
                            <form method="POST" action="{{ route('threads.lock', $thread) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-{{ $thread->is_locked ? 'unlock' : 'lock' }}"></i>
                                    {{ $thread->is_locked ? 'Desbloquear' : 'Bloquear' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('threads.pin', $thread) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-thumbtack"></i>
                                    {{ $thread->is_pinned ? 'Desfijar' : 'Fijar' }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <!-- Thread Content -->
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <img src="{{ $thread->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($thread->user->name) }}" 
                                     alt="{{ $thread->user->name }}" 
                                     class="rounded-circle" 
                                     width="60" 
                                     height="60">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0">
                                    <a href="{{ route('users.show', $thread->user) }}" class="text-decoration-none">
                                        {{ $thread->user->name }}
                                    </a>
                                </h5>
                                <div class="text-muted small">
                                    <i class="fas fa-clock"></i> {{ $thread->created_at->format('d/m/Y H:i') }}
                                    ({{ $thread->created_at->diffForHumans() }})
                                </div>
                            </div>
                        </div>
                        <div class="thread-body">
                            {!! nl2br(e($thread->body)) !!}
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-muted small">
                    <i class="fas fa-eye"></i> {{ $thread->view_count }} vistas
                    <i class="fas fa-comment ms-3"></i> {{ $posts->total() }} respuestas
                </div>
            </div>
        </div>

        <!-- Responses -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-comments"></i> Respuestas ({{ $posts->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @forelse($posts as $post)
                    <div class="post-card border-bottom p-3 {{ $post->is_solution ? 'solution' : '' }}">
                        <div class="d-flex">
                            <div class="me-3">
                                <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                                     alt="{{ $post->user->name }}" 
                                     class="rounded-circle" 
                                     width="50" 
                                     height="50">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0">
                                            <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">
                                                {{ $post->user->name }}
                                            </a>
                                            @if($post->is_solution)
                                                <span class="solution-badge ms-2">
                                                    <i class="fas fa-check"></i> Solución
                                                </span>
                                            @endif
                                        </h6>
                                        <div class="text-muted small">
                                            <i class="fas fa-clock"></i> {{ $post->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div>
                                        @can('update', $post)
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('markAsSolution', $post)
                                            @if(!$post->is_solution)
                                                <form method="POST" action="{{ route('posts.solution', $post) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Marcar como solución">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('delete', $post)
                                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta respuesta?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                                <div class="post-body">
                                    {!! nl2br(e($post->body)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-comment-slash fa-3x mb-3"></i>
                        <p>No hay respuestas todavía. ¡Sé el primero en responder!</p>
                    </div>
                @endforelse
            </div>
            @if($posts->hasPages())
                <div class="card-footer bg-white">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- Reply Form -->
        @auth
            @if(!$thread->is_locked)
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-reply"></i> Responder</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.store', $thread) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="body" 
                                          rows="5" 
                                          class="form-control @error('body') is-invalid @enderror"
                                          placeholder="Escribe tu respuesta aquí..."
                                          required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Publicar Respuesta
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-lock"></i> Este hilo está bloqueado y no acepta nuevas respuestas.
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <a href="{{ route('login') }}">Inicia sesión</a> o 
                <a href="{{ route('register') }}">regístrate</a> para responder a este hilo.
            </div>
        @endauth
    </div>
</div>
@endsection
