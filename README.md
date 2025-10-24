# UDONE-FORO

Foro Universitario para los Estudiantes de la Universidad de Oriente Núcleo Nueva Esparta.

## 📋 Descripción

UDONE-FORO es una aplicación web de foro desarrollada con Laravel que permite a los estudiantes de la Universidad de Oriente compartir conocimientos, resolver dudas y conectar con otros estudiantes.

## 🚀 Características

- **Categorías organizadas**: Anuncios, ayuda académica, programación, matemáticas, vida universitaria, recursos y más
- **Hilos de discusión**: Crea y participa en discusiones sobre diversos temas
- **Sistema de respuestas**: Responde a hilos y marca soluciones
- **Gestión de usuarios**: Perfiles de estudiantes con información de carrera
- **Sistema de moderación**: Fijar y bloquear hilos
- **Interfaz responsive**: Diseño adaptable para dispositivos móviles y desktop

## 🏗️ Estructura MVC

### Modelos (Models)
Ubicados en `app/Models/`:
- **User.php**: Modelo de usuarios con roles (admin, moderador, estudiante)
- **Category.php**: Modelo de categorías del foro
- **Thread.php**: Modelo de hilos de discusión
- **Post.php**: Modelo de respuestas a hilos

### Controladores (Controllers)
Ubicados en `app/Http/Controllers/`:
- **HomeController.php**: Página principal del foro
- **CategoryController.php**: Gestión de categorías
- **ThreadController.php**: Gestión de hilos de discusión
- **PostController.php**: Gestión de respuestas
- **UserController.php**: Gestión de perfiles de usuario

### Vistas (Views)
Ubicadas en `resources/views/`:
- **layouts/app.blade.php**: Layout principal de la aplicación
- **home.blade.php**: Vista de inicio
- **categories/**: Vistas de categorías
- **threads/**: Vistas de hilos
- **posts/**: Vistas de respuestas
- **users/**: Vistas de perfiles

## 📦 Instalación

### Requisitos Previos
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js y NPM (opcional, para assets)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/JesusMarichal/UDONE-FORO.git
cd UDONE-FORO
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**
Edita el archivo `.env` con tus credenciales de base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=udone_foro
DB_USERNAME=root
DB_PASSWORD=tu_password
```

5. **Crear la base de datos**
```bash
mysql -u root -p
CREATE DATABASE udone_foro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

6. **Ejecutar migraciones**
```bash
php artisan migrate
```

7. **Poblar la base de datos con datos de ejemplo**
```bash
php artisan db:seed
```

8. **Crear enlace simbólico para storage**
```bash
php artisan storage:link
```

9. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 👥 Usuarios de Prueba

Después de ejecutar los seeders, puedes usar estos usuarios:

- **Administrador**
  - Email: `admin@udone.edu.ve`
  - Password: `password`

- **Moderador**
  - Email: `moderador@udone.edu.ve`
  - Password: `password`

- **Usuario Regular**
  - Email: `maria@udone.edu.ve`
  - Password: `password`

## 📂 Estructura de Directorios

```
UDONE-FORO/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Controladores
│   └── Models/              # Modelos Eloquent
├── bootstrap/               # Archivos de arranque
├── config/                  # Configuración
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/             # Seeders de datos
├── public/                  # Archivos públicos
├── resources/
│   └── views/               # Vistas Blade
├── routes/
│   └── web.php              # Rutas web
├── storage/                 # Almacenamiento
└── tests/                   # Tests
```

## 🔧 Base de Datos

### Tablas Principales

1. **users**: Usuarios del sistema
2. **categories**: Categorías del foro
3. **threads**: Hilos de discusión
4. **posts**: Respuestas a hilos

### Relaciones

- Un usuario puede crear múltiples hilos y posts
- Una categoría puede tener múltiples hilos
- Un hilo pertenece a una categoría y un usuario
- Un post pertenece a un hilo y un usuario

## 🛠️ Tecnologías Utilizadas

- **Laravel 11**: Framework PHP
- **MySQL**: Base de datos
- **Bootstrap 5**: Framework CSS
- **Font Awesome**: Iconos
- **Blade**: Motor de plantillas

## 📝 Funcionalidades Principales

### Gestión de Categorías
- Crear, editar y eliminar categorías
- Organizar categorías por orden
- Asignar colores e iconos

### Gestión de Hilos
- Crear nuevos hilos de discusión
- Editar y eliminar hilos propios
- Fijar hilos importantes (moderadores)
- Bloquear hilos (moderadores)
- Contador de vistas

### Sistema de Respuestas
- Responder a hilos
- Editar y eliminar respuestas propias
- Marcar respuestas como solución

### Perfiles de Usuario
- Ver perfil con hilos y posts
- Editar información personal
- Avatar personalizado
- Información de carrera

## 🔐 Roles y Permisos

- **Administrador**: Control total del sistema
- **Moderador**: Gestionar hilos y posts
- **Usuario**: Crear hilos y responder

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 👨‍💻 Autor

**Jesús Marichal**

## 📞 Contacto

Para preguntas o sugerencias sobre el proyecto, por favor abre un issue en GitHub.

---

⭐ Si te gusta este proyecto, dale una estrella en GitHub!
