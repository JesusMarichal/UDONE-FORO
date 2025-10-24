# API Endpoints - UDONE Foro

Esta es una referencia rápida de los endpoints disponibles en el foro.

## Autenticación

La mayoría de endpoints requieren autenticación. En una implementación futura, se puede usar Laravel Sanctum para autenticación de API.

## Endpoints Públicos

### Home
- `GET /` - Página principal del foro

### Categorías
- `GET /categories` - Listar todas las categorías
- `GET /categories/{slug}` - Ver una categoría específica

### Hilos
- `GET /threads/{slug}` - Ver un hilo específico

### Usuarios
- `GET /users/{id}` - Ver perfil de usuario

## Endpoints Autenticados

Requieren que el usuario esté autenticado.

### Hilos
- `GET /threads/create` - Formulario para crear hilo
- `POST /threads` - Crear nuevo hilo
  - Parámetros: `category_id`, `title`, `body`
- `GET /threads/{id}/edit` - Formulario para editar hilo
- `PUT /threads/{id}` - Actualizar hilo
  - Parámetros: `category_id`, `title`, `body`
- `DELETE /threads/{id}` - Eliminar hilo

### Posts
- `POST /threads/{thread_id}/posts` - Crear respuesta
  - Parámetros: `body`
- `GET /posts/{id}/edit` - Formulario para editar post
- `PUT /posts/{id}` - Actualizar post
  - Parámetros: `body`
- `DELETE /posts/{id}` - Eliminar post
- `POST /posts/{id}/solution` - Marcar como solución

### Perfiles
- `GET /users/{id}/edit` - Formulario para editar perfil
- `PUT /users/{id}` - Actualizar perfil
  - Parámetros: `name`, `email`, `bio`, `career`, `avatar`

## Endpoints de Moderación

Requieren rol de moderador o administrador.

### Hilos
- `POST /threads/{id}/lock` - Bloquear/desbloquear hilo
- `POST /threads/{id}/pin` - Fijar/desfijar hilo

### Categorías (Solo Admin)
- `GET /categories/create` - Formulario para crear categoría
- `POST /categories` - Crear categoría
  - Parámetros: `name`, `description`, `color`, `icon`
- `GET /categories/{id}/edit` - Formulario para editar categoría
- `PUT /categories/{id}` - Actualizar categoría
- `DELETE /categories/{id}` - Eliminar categoría

## Respuestas

### Formato de Respuesta Exitosa (Redirección)
La mayoría de endpoints redirigen con mensajes flash:
```php
redirect()->route('threads.show', $thread)
    ->with('success', 'Hilo creado exitosamente.');
```

### Errores de Validación
Laravel retorna automáticamente con errores de validación:
```php
@error('field_name')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

## Implementación de API REST (Futuro)

Para crear una API REST completa, se puede agregar:

1. **Rutas API** en `routes/api.php`
2. **API Resources** para formatear respuestas
3. **Rate Limiting** para proteger endpoints
4. **Sanctum** para autenticación de API tokens

### Ejemplo de Implementación Futura

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('threads', ThreadController::class);
    Route::apiResource('posts', PostController::class);
    Route::get('categories', [CategoryController::class, 'index']);
});

// Respuesta JSON
{
    "data": {
        "id": 1,
        "title": "Mi hilo",
        "body": "Contenido...",
        "created_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

## Rate Limiting

Laravel incluye rate limiting por defecto:
- 60 peticiones por minuto para API
- Personalizable en `app/Http/Kernel.php`

## CORS

Para permitir peticiones desde otros dominios:
1. Configurar en `config/cors.php`
2. Middleware `\Illuminate\Http\Middleware\HandleCors::class`
