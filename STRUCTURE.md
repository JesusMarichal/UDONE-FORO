# Estructura MVC del Foro UDONE

## Introducción

Este documento describe la arquitectura Modelo-Vista-Controlador (MVC) implementada en el Foro Universitario UDONE usando Laravel 11.

## Patrón MVC en Laravel

Laravel sigue el patrón arquitectónico MVC que separa la aplicación en tres componentes principales:

- **Modelo (Model)**: Representa la lógica de negocio y la interacción con la base de datos
- **Vista (View)**: Se encarga de la presentación de datos al usuario
- **Controlador (Controller)**: Maneja las peticiones HTTP y coordina entre modelos y vistas

## Estructura de Directorios

```
UDONE-FORO/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # CONTROLADORES
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ThreadController.php
│   │   │   ├── PostController.php
│   │   │   └── UserController.php
│   │   └── Middleware/         # Middleware
│   └── Models/                 # MODELOS
│       ├── User.php
│       ├── Category.php
│       ├── Thread.php
│       └── Post.php
├── resources/
│   └── views/                  # VISTAS
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── categories/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── threads/
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── users/
├── routes/
│   └── web.php                 # Definición de rutas
├── database/
│   ├── migrations/             # Migraciones de BD
│   └── seeders/                # Datos de prueba
└── config/                     # Configuración
```

## MODELOS (Models)

Los modelos representan las entidades del dominio y su lógica de negocio.

### User (app/Models/User.php)

**Responsabilidades:**
- Autenticación y autorización de usuarios
- Gestión de perfiles de estudiantes
- Roles (admin, moderador, estudiante)

**Atributos principales:**
- `name`: Nombre del usuario
- `email`: Correo electrónico
- `student_id`: Número de estudiante
- `career`: Carrera que estudia
- `is_admin`: Indica si es administrador
- `is_moderator`: Indica si es moderador

**Relaciones:**
- `hasMany(Thread)`: Un usuario puede crear múltiples hilos
- `hasMany(Post)`: Un usuario puede crear múltiples posts

**Métodos destacados:**
- `isAdmin()`: Verifica si el usuario es administrador
- `isModerator()`: Verifica si el usuario es moderador

### Category (app/Models/Category.php)

**Responsabilidades:**
- Organización de hilos en categorías
- Gestión de metadata visual (color, icono)

**Atributos principales:**
- `name`: Nombre de la categoría
- `slug`: URL amigable
- `description`: Descripción de la categoría
- `color`: Color hexadecimal para la UI
- `icon`: Clase del icono (Font Awesome)
- `order`: Orden de visualización

**Relaciones:**
- `hasMany(Thread)`: Una categoría puede tener múltiples hilos

**Métodos destacados:**
- `activeThreadsCount()`: Cuenta hilos activos
- `totalPostsCount()`: Cuenta total de posts en la categoría

### Thread (app/Models/Thread.php)

**Responsabilidades:**
- Gestión de hilos de discusión
- Control de estado (fijado, bloqueado)
- Seguimiento de vistas

**Atributos principales:**
- `title`: Título del hilo
- `slug`: URL amigable
- `body`: Contenido del hilo
- `is_pinned`: Si está fijado en la parte superior
- `is_locked`: Si está bloqueado para respuestas
- `view_count`: Contador de vistas

**Relaciones:**
- `belongsTo(Category)`: Pertenece a una categoría
- `belongsTo(User)`: Creado por un usuario
- `hasMany(Post)`: Puede tener múltiples respuestas

**Métodos destacados:**
- `incrementViewCount()`: Incrementa el contador de vistas
- `latestPost()`: Obtiene la última respuesta

### Post (app/Models/Post.php)

**Responsabilidades:**
- Gestión de respuestas a hilos
- Marcado de soluciones

**Atributos principales:**
- `body`: Contenido de la respuesta
- `is_solution`: Si está marcada como solución

**Relaciones:**
- `belongsTo(Thread)`: Pertenece a un hilo
- `belongsTo(User)`: Creado por un usuario

**Métodos destacados:**
- `markAsSolution()`: Marca el post como solución

## CONTROLADORES (Controllers)

Los controladores manejan las peticiones HTTP y coordinan la lógica de la aplicación.

### HomeController (app/Http/Controllers/HomeController.php)

**Responsabilidad:** Página principal del foro

**Métodos:**
- `index()`: Muestra la página principal con categorías, hilos recientes y populares

### CategoryController (app/Http/Controllers/CategoryController.php)

**Responsabilidad:** CRUD de categorías

**Métodos:**
- `index()`: Lista todas las categorías
- `show(Category)`: Muestra una categoría con sus hilos
- `create()`: Formulario para crear categoría (admin)
- `store(Request)`: Guarda nueva categoría
- `edit(Category)`: Formulario para editar categoría
- `update(Request, Category)`: Actualiza categoría
- `destroy(Category)`: Elimina categoría

### ThreadController (app/Http/Controllers/ThreadController.php)

**Responsabilidad:** CRUD de hilos y moderación

**Métodos:**
- `create()`: Formulario para crear hilo
- `store(Request)`: Guarda nuevo hilo
- `show(Thread)`: Muestra hilo con respuestas
- `edit(Thread)`: Formulario para editar hilo
- `update(Request, Thread)`: Actualiza hilo
- `destroy(Thread)`: Elimina hilo
- `toggleLock(Thread)`: Bloquea/desbloquea hilo
- `togglePin(Thread)`: Fija/desfija hilo

### PostController (app/Http/Controllers/PostController.php)

**Responsabilidad:** CRUD de respuestas

**Métodos:**
- `store(Request, Thread)`: Guarda nueva respuesta
- `edit(Post)`: Formulario para editar respuesta
- `update(Request, Post)`: Actualiza respuesta
- `destroy(Post)`: Elimina respuesta
- `markAsSolution(Post)`: Marca respuesta como solución

### UserController (app/Http/Controllers/UserController.php)

**Responsabilidad:** Gestión de perfiles

**Métodos:**
- `show(User)`: Muestra perfil del usuario
- `edit(User)`: Formulario para editar perfil
- `update(Request, User)`: Actualiza perfil

## VISTAS (Views)

Las vistas son responsables de la presentación de datos usando Blade templates.

### Layout Principal (resources/views/layouts/app.blade.php)

**Responsabilidad:** Plantilla base de la aplicación

**Características:**
- Navbar con navegación principal
- Sistema de mensajes flash
- Footer
- Integración con Bootstrap 5 y Font Awesome
- Estilos personalizados para el foro

### Vistas de Categorías

**categories/index.blade.php**
- Lista todas las categorías
- Muestra contador de hilos por categoría
- Botón para crear nueva categoría (admin)

**categories/show.blade.php**
- Muestra información de la categoría
- Lista hilos de la categoría con paginación
- Botón para crear nuevo hilo

### Vistas de Hilos

**threads/create.blade.php**
- Formulario para crear nuevo hilo
- Selector de categoría
- Campos: título, contenido

**threads/show.blade.php**
- Muestra el hilo completo
- Lista de respuestas con paginación
- Formulario para responder
- Badges para hilos fijados/bloqueados
- Contador de vistas

### Vista Home (resources/views/home.blade.php)

**Responsabilidad:** Página principal

**Muestra:**
- Banner de bienvenida
- Hilos recientes
- Categorías destacadas
- Hilos populares

## RUTAS (Routes)

El archivo `routes/web.php` define todas las rutas de la aplicación:

### Rutas Públicas
```php
GET  /                           -> HomeController@index
GET  /categories                 -> CategoryController@index
GET  /categories/{category}      -> CategoryController@show
GET  /threads/{thread}           -> ThreadController@show
GET  /users/{user}               -> UserController@show
```

### Rutas Autenticadas
```php
GET   /threads/create            -> ThreadController@create
POST  /threads                   -> ThreadController@store
POST  /threads/{thread}/posts    -> PostController@store
PUT   /threads/{thread}          -> ThreadController@update
DELETE /threads/{thread}         -> ThreadController@destroy
```

### Rutas de Moderación
```php
POST /threads/{thread}/lock      -> ThreadController@toggleLock
POST /threads/{thread}/pin       -> ThreadController@togglePin
POST /posts/{post}/solution      -> PostController@markAsSolution
```

## BASE DE DATOS

### Diagrama de Relaciones

```
users (1) -----> (N) threads
users (1) -----> (N) posts
categories (1) -> (N) threads
threads (1) ----> (N) posts
```

### Migraciones

1. **0001_01_01_000000_create_users_table.php**
   - Tabla de usuarios con roles y datos de estudiante

2. **2024_01_01_000003_create_categories_table.php**
   - Tabla de categorías con metadata visual

3. **2024_01_01_000004_create_threads_table.php**
   - Tabla de hilos con flags de estado

4. **2024_01_01_000005_create_posts_table.php**
   - Tabla de respuestas

## Flujo de Datos

### Ejemplo: Ver un Hilo

1. **Usuario** accede a `/threads/mi-hilo`
2. **Router** (`web.php`) dirige la petición a `ThreadController@show`
3. **Controlador** recupera el Thread del modelo
4. **Modelo** consulta la base de datos usando Eloquent
5. **Controlador** carga relaciones (user, category, posts)
6. **Controlador** pasa datos a la vista
7. **Vista** (`threads/show.blade.php`) renderiza HTML
8. **Respuesta** se envía al navegador

### Ejemplo: Crear un Post

1. **Usuario** envía formulario POST a `/threads/{thread}/posts`
2. **Router** dirige a `PostController@store`
3. **Controlador** valida datos del Request
4. **Controlador** crea nuevo Post usando el modelo
5. **Modelo** guarda en la base de datos
6. **Controlador** redirige con mensaje de éxito
7. **Vista** muestra el hilo actualizado con el nuevo post

## Principios de Diseño Aplicados

### Separation of Concerns (Separación de Responsabilidades)
- Modelos: Lógica de negocio y datos
- Controladores: Lógica de aplicación
- Vistas: Presentación

### DRY (Don't Repeat Yourself)
- Layouts reutilizables
- Componentes compartidos
- Métodos de modelo para lógica común

### Convention over Configuration
- Laravel proporciona convenciones que reducen configuración
- Nombres de rutas y métodos consistentes
- Estructura de archivos estándar

### RESTful Design
- Rutas siguen principios REST
- Métodos HTTP apropiados (GET, POST, PUT, DELETE)
- URLs descriptivas

## Extensibilidad

El sistema está diseñado para ser fácilmente extensible:

### Agregar una nueva entidad
1. Crear migración: `php artisan make:migration create_tabla_table`
2. Crear modelo: `php artisan make:model NombreModelo`
3. Crear controlador: `php artisan make:controller NombreController`
4. Definir rutas en `web.php`
5. Crear vistas en `resources/views/`

### Agregar funcionalidad
- **Notificaciones**: Usar sistema de notificaciones de Laravel
- **Búsqueda**: Implementar en controlador y modelo
- **API**: Crear rutas API separadas
- **Permisos**: Implementar Policies de Laravel

## Mejores Prácticas Implementadas

1. **Validación de datos** en controladores
2. **Uso de Eloquent ORM** para queries
3. **Route Model Binding** para simplificar controladores
4. **Blade templates** para vistas limpias
5. **Migraciones** para control de versiones de BD
6. **Seeders** para datos de prueba
7. **Autorización** con policies (preparado para implementar)
8. **CSRF Protection** en formularios
9. **Mass Assignment Protection** en modelos

## Conclusión

Esta estructura MVC proporciona una base sólida y escalable para el foro universitario UDONE. La separación clara de responsabilidades facilita el mantenimiento y la adición de nuevas funcionalidades.
