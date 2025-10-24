# Guía de Contribución - UDONE Foro

¡Gracias por tu interés en contribuir al Foro UDONE! Esta guía te ayudará a empezar.

## 📋 Tabla de Contenidos

1. [Código de Conducta](#código-de-conducta)
2. [¿Cómo Puedo Contribuir?](#cómo-puedo-contribuir)
3. [Estilo de Código](#estilo-de-código)
4. [Proceso de Pull Request](#proceso-de-pull-request)
5. [Convenciones de Commits](#convenciones-de-commits)

## Código de Conducta

Este proyecto se adhiere a un código de conducta. Al participar, se espera que mantengas este código. Por favor, reporta comportamientos inaceptables.

## ¿Cómo Puedo Contribuir?

### Reportar Bugs

Antes de crear un reporte de bug:
- Verifica si el bug ya ha sido reportado
- Asegúrate de usar la última versión
- Recopila información sobre el bug

Cuando crees un reporte de bug, incluye:
- Un título claro y descriptivo
- Pasos para reproducir el problema
- Comportamiento esperado vs. comportamiento actual
- Capturas de pantalla si aplica
- Versión de PHP, Laravel, y navegador

### Sugerir Mejoras

Las sugerencias de mejoras son bienvenidas. Al crear una sugerencia:
- Usa un título claro y descriptivo
- Proporciona una descripción detallada de la mejora
- Explica por qué sería útil para la mayoría de usuarios
- Lista algunos ejemplos de implementaciones similares si existen

### Contribuir con Código

1. **Fork el repositorio**
   ```bash
   git clone https://github.com/TU_USUARIO/UDONE-FORO.git
   cd UDONE-FORO
   ```

2. **Crea una rama para tu feature**
   ```bash
   git checkout -b feature/mi-nueva-funcionalidad
   ```

3. **Instala las dependencias**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

4. **Realiza tus cambios**
   - Sigue el estilo de código del proyecto
   - Añade tests si es posible
   - Actualiza la documentación si es necesario

5. **Commit tus cambios**
   ```bash
   git add .
   git commit -m "feat: agregar nueva funcionalidad"
   ```

6. **Push a tu fork**
   ```bash
   git push origin feature/mi-nueva-funcionalidad
   ```

7. **Abre un Pull Request**

## Estilo de Código

### PHP

Seguimos las guías de estilo de PSR-12:
- Usar 4 espacios para indentación
- Llaves de apertura en nueva línea para clases y funciones
- CamelCase para nombres de clases
- camelCase para nombres de métodos
- snake_case para nombres de propiedades de base de datos

Ejemplo:
```php
class MiClase
{
    public function miMetodo()
    {
        $miVariable = 'valor';
        return $miVariable;
    }
}
```

### Blade Templates

- Usar directivas Blade cuando sea posible
- Mantener la lógica al mínimo en las vistas
- Usar componentes para código reutilizable

```blade
@if($user->isAdmin())
    <div class="admin-panel">
        <!-- Contenido -->
    </div>
@endif
```

### JavaScript

- Usar ES6+ cuando sea posible
- Usar const/let en lugar de var
- Punto y coma al final de las declaraciones

### CSS

- Usar clases de Bootstrap cuando sea posible
- Usar nombres descriptivos para clases personalizadas
- Mantener la especificidad baja

## Proceso de Pull Request

1. **Actualiza tu fork** antes de crear el PR
   ```bash
   git checkout main
   git pull upstream main
   ```

2. **Asegúrate de que tu código:**
   - Sigue el estilo de código del proyecto
   - Incluye tests apropiados
   - No rompe tests existentes
   - Está bien documentado

3. **Descripción del PR:**
   - Describe qué cambia el PR
   - Menciona el issue relacionado si existe
   - Incluye capturas de pantalla para cambios de UI
   - Lista cualquier breaking change

4. **Espera la revisión:**
   - Los mantenedores revisarán tu PR
   - Puede haber comentarios y sugerencias
   - Realiza los cambios solicitados
   - Una vez aprobado, se hará merge

## Convenciones de Commits

Usamos commits semánticos:

- `feat`: Nueva funcionalidad
- `fix`: Corrección de bugs
- `docs`: Cambios en documentación
- `style`: Cambios de formato
- `refactor`: Refactorización de código
- `test`: Agregar o actualizar tests
- `chore`: Tareas de mantenimiento

Ejemplos:
```
feat: agregar sistema de notificaciones
fix: corregir contador de posts
docs: actualizar README con instrucciones
style: formatear código según PSR-12
refactor: mejorar estructura de controladores
test: agregar tests para ThreadController
chore: actualizar dependencias
```

## Áreas donde Puedes Contribuir

### Funcionalidades Pendientes

- [ ] Sistema de autenticación completo
- [ ] Sistema de notificaciones
- [ ] Búsqueda de hilos y posts
- [ ] Sistema de likes/votos
- [ ] Etiquetas para hilos
- [ ] Mensajes privados
- [ ] Panel de administración
- [ ] API REST completa
- [ ] Tests automatizados
- [ ] Modo oscuro

### Mejoras de UI/UX

- [ ] Responsive design mejorado
- [ ] Animaciones y transiciones
- [ ] Mejoras de accesibilidad
- [ ] Optimización de rendimiento
- [ ] Editor de texto enriquecido

### Documentación

- [ ] Guía de instalación detallada
- [ ] Tutoriales en video
- [ ] Documentación de API
- [ ] Ejemplos de uso
- [ ] Traducciones

## Testing

Antes de enviar tu PR, asegúrate de ejecutar los tests:

```bash
# Tests unitarios
php artisan test

# Tests de código estático
./vendor/bin/phpstan analyse

# Formatear código
./vendor/bin/pint
```

## Preguntas

Si tienes preguntas sobre cómo contribuir:
1. Revisa la documentación existente
2. Busca en los issues cerrados
3. Abre un issue con la etiqueta "question"
4. Contacta a los mantenedores

## Reconocimientos

Todos los contribuidores serán reconocidos en el README del proyecto.

## Licencia

Al contribuir, aceptas que tus contribuciones se licenciarán bajo la misma licencia MIT del proyecto.

---

¡Gracias por contribuir al Foro UDONE! 🎓
