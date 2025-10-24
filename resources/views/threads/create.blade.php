@extends('layouts.app')

@section('title', 'Crear Hilo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Crear Nuevo Hilo</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('threads.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoría *</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $categoryId) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Título *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}"
                               placeholder="Escribe un título descriptivo para tu hilo"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">Contenido *</label>
                        <textarea name="body" 
                                  id="body" 
                                  rows="10" 
                                  class="form-control @error('body') is-invalid @enderror"
                                  placeholder="Describe tu pregunta o tema de discusión en detalle..."
                                  required>{{ old('body') }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Proporciona toda la información necesaria para que otros puedan ayudarte.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Publicar Hilo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
