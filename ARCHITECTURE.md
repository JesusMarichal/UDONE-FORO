# Diagrama de Arquitectura MVC - UDONE Foro

## Flujo de Datos General

```
┌─────────────┐
│   Usuario   │
│  (Browser)  │
└──────┬──────┘
       │ HTTP Request
       ▼
┌─────────────────────────────────────────┐
│              Routes (web.php)           │
│  Define qué controlador maneja qué URL  │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│            CONTROLLERS                  │
│  ┌────────────────────────────────┐    │
│  │  CategoryController            │    │
│  │  ThreadController              │    │
│  │  PostController                │    │
│  │  UserController                │    │
│  │  HomeController                │    │
│  └────────────────────────────────┘    │
└────────────┬────────────────────────────┘
             │
             ▼
┌────────────────────────────────────────────────┐
│                   MODELS                       │
│  ┌──────────────────────────────────────┐     │
│  │  User      Category                  │     │
│  │    │           │                      │     │
│  │    │           ▼                      │     │
│  │    │        Thread ◄──────┐          │     │
│  │    │           │           │          │     │
│  │    └───────────┼───────────┘          │     │
│  │                ▼                      │     │
│  │             Post                      │     │
│  └──────────────────────────────────────┘     │
└────────────┬───────────────────────────────────┘
             │ Eloquent ORM
             ▼
┌─────────────────────────────────────────┐
│          DATABASE (MySQL)               │
│  ┌────────────────────────────────┐    │
│  │  users                         │    │
│  │  categories                    │    │
│  │  threads                       │    │
│  │  posts                         │    │
│  └────────────────────────────────┘    │
└───────────────────────────────────────┬─┘
                                        │
                      ┌─────────────────┘
                      │ Data
                      ▼
┌─────────────────────────────────────────┐
│            CONTROLLERS                  │
│  Procesa datos y prepara para vista    │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│               VIEWS                     │
│  ┌────────────────────────────────┐    │
│  │  layouts/app.blade.php         │    │
│  │  home.blade.php                │    │
│  │  categories/index.blade.php    │    │
│  │  categories/show.blade.php     │    │
│  │  threads/create.blade.php      │    │
│  │  threads/show.blade.php        │    │
│  └────────────────────────────────┘    │
└────────────┬────────────────────────────┘
             │ HTML Response
             ▼
┌─────────────┐
│   Usuario   │
│  (Browser)  │
└─────────────┘
```

## Relaciones entre Modelos

```
┌──────────────┐
│    User      │
│  (Usuario)   │
└──┬───────┬───┘
   │       │
   │1      │1
   │       │
   │*      │*
   │       │
┌──▼───┐ ┌─▼────────┐
│Thread│ │   Post   │
│(Hilo)│ │(Respuesta)│
└──┬───┘ └─▲────────┘
   │       │
   │*      │*
   │       │
   │1      │1
   │       │
┌──▼────────┴───┐
│   Category    │
│  (Categoría)  │
└───────────────┘

Relaciones:
- Un Usuario puede crear múltiples Hilos (1:N)
- Un Usuario puede crear múltiples Posts (1:N)
- Una Categoría puede tener múltiples Hilos (1:N)
- Un Hilo pertenece a una Categoría (N:1)
- Un Hilo pertenece a un Usuario (N:1)
- Un Hilo puede tener múltiples Posts (1:N)
- Un Post pertenece a un Hilo (N:1)
- Un Post pertenece a un Usuario (N:1)
```

## Estructura de Base de Datos

```sql
┌─────────────────────────────────────────────────┐
│                    users                        │
├─────────────────────────────────────────────────┤
│ id                  │ bigint                    │
│ name                │ varchar(255)              │
│ email               │ varchar(255) UNIQUE       │
│ password            │ varchar(255)              │
│ student_id          │ varchar(255) UNIQUE       │
│ career              │ varchar(100)              │
│ bio                 │ text                      │
│ avatar              │ varchar(255)              │
│ is_admin            │ boolean                   │
│ is_moderator        │ boolean                   │
│ created_at          │ timestamp                 │
│ updated_at          │ timestamp                 │
└─────────────────────────────────────────────────┘
                      │
                      │ user_id (FK)
                      ▼
┌─────────────────────────────────────────────────┐
│                  categories                     │
├─────────────────────────────────────────────────┤
│ id                  │ bigint                    │
│ name                │ varchar(255)              │
│ slug                │ varchar(255) UNIQUE       │
│ description         │ text                      │
│ color               │ varchar(7)                │
│ icon                │ varchar(50)               │
│ order               │ integer                   │
│ is_active           │ boolean                   │
│ created_at          │ timestamp                 │
│ updated_at          │ timestamp                 │
└─────────────────────────────────────────────────┘
                      │
                      │ category_id (FK)
                      ▼
┌─────────────────────────────────────────────────┐
│                   threads                       │
├─────────────────────────────────────────────────┤
│ id                  │ bigint                    │
│ category_id         │ bigint FK                 │
│ user_id             │ bigint FK                 │
│ title               │ varchar(255)              │
│ slug                │ varchar(255) UNIQUE       │
│ body                │ text                      │
│ is_pinned           │ boolean                   │
│ is_locked           │ boolean                   │
│ view_count          │ integer                   │
│ created_at          │ timestamp                 │
│ updated_at          │ timestamp                 │
└─────────────────────────────────────────────────┘
                      │
                      │ thread_id (FK)
                      ▼
┌─────────────────────────────────────────────────┐
│                    posts                        │
├─────────────────────────────────────────────────┤
│ id                  │ bigint                    │
│ thread_id           │ bigint FK                 │
│ user_id             │ bigint FK                 │
│ body                │ text                      │
│ is_solution         │ boolean                   │
│ created_at          │ timestamp                 │
│ updated_at          │ timestamp                 │
└─────────────────────────────────────────────────┘
```

## Flujo de Ejemplo: Ver un Hilo

```
1. Usuario visita: https://udone-foro.test/threads/mi-hilo

2. Router (web.php)
   Route::get('/threads/{thread:slug}', [ThreadController::class, 'show'])
   ↓
   
3. ThreadController@show(Thread $thread)
   - Laravel automáticamente busca el Thread por slug
   - Incrementa el contador de vistas
   - Carga relaciones: user, category
   - Carga posts con paginación
   ↓
   
4. Thread Model
   - incrementViewCount() actualiza view_count
   - Relación user() carga el autor
   - Relación category() carga la categoría
   - Relación posts() carga las respuestas
   ↓
   
5. Database
   SELECT * FROM threads WHERE slug = 'mi-hilo'
   SELECT * FROM users WHERE id = thread.user_id
   SELECT * FROM categories WHERE id = thread.category_id
   SELECT * FROM posts WHERE thread_id = thread.id
   ↓
   
6. Controller
   return view('threads.show', compact('thread', 'posts'));
   ↓
   
7. View (threads/show.blade.php)
   - Extiende layout principal
   - Renderiza información del hilo
   - Muestra posts con paginación
   - Formulario para responder
   ↓
   
8. HTML Response al navegador
```

## Flujo de Ejemplo: Crear un Post

```
1. Usuario envía formulario POST a: /threads/mi-hilo/posts
   body: "Mi respuesta al hilo"

2. Router
   Route::post('/threads/{thread}/posts', [PostController::class, 'store'])
   ↓
   
3. PostController@store(Request $request, Thread $thread)
   - Valida que el hilo no esté bloqueado
   - Valida el campo 'body'
   - Obtiene user_id del usuario autenticado
   ↓
   
4. Post Model
   Post::create([
       'thread_id' => $thread->id,
       'user_id' => auth()->id(),
       'body' => $validated['body']
   ])
   ↓
   
5. Database
   INSERT INTO posts (thread_id, user_id, body, created_at, updated_at)
   VALUES (1, 2, 'Mi respuesta', NOW(), NOW())
   ↓
   
6. Controller
   return redirect()->route('threads.show', $thread)
       ->with('success', 'Respuesta publicada exitosamente.');
   ↓
   
7. Redirección
   - Usuario es redirigido a la página del hilo
   - Se muestra mensaje de éxito
   - El nuevo post aparece en la lista
```

## Componentes Adicionales

### Middleware
```
┌──────────────────────┐
│   HTTP Request       │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   auth               │ ◄── Verifica autenticación
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   Authorize          │ ◄── Verifica permisos
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   Controller         │
└──────────────────────┘
```

### Providers
```
AppServiceProvider
├── register()      ◄── Registra servicios
└── boot()          ◄── Inicializa aplicación
```

## Resumen de Responsabilidades

| Componente   | Responsabilidad                              |
|--------------|---------------------------------------------|
| Routes       | Mapear URLs a controladores                 |
| Controllers  | Manejar requests, coordinar lógica          |
| Models       | Representar datos, lógica de negocio        |
| Views        | Presentar datos al usuario                  |
| Migrations   | Definir estructura de base de datos         |
| Seeders      | Poblar base de datos con datos de prueba    |
| Middleware   | Filtrar requests HTTP                       |
| Providers    | Configurar servicios de la aplicación       |
