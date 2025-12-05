# Blog con PHP - Proyecto Multiplataforma

Blog desarrollado con PHP orientado a objetos, implementando un sistema CRUD completo con autenticación de usuarios y gestión de publicaciones.

 Características

- **Sistema de autenticación** - Registro e inicio de sesión seguro con hash de contraseñas
- **CRUD de publicaciones** - Crear, leer, actualizar y eliminar posts
- **Gestión de imágenes** - Subida y almacenamiento de imágenes para posts
- **URLs amigables** - Sistema de enrutamiento personalizado
- **Programación Orientada a Objetos** - Código estructurado y mantenible
- **Seguridad** - PDO con sentencias preparadas, validación de datos, protección XSS

 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache (XAMPP, WAMP, LAMP, etc.)
- Extensión PDO de PHP habilitada

Instalación

1. **Clonar o descargar el proyecto** en la carpeta de tu servidor web:
   ```
   c:\xampp\htdocs\Blog\
   ```

2. **Crear la base de datos**:
   - Abre phpMyAdmin: `http://localhost/phpmyadmin`
   - Importa el archivo `database.sql` o ejecuta su contenido en la pestaña SQL

3. **Configurar la conexión a la base de datos**:
   - Abre el archivo `config/database.php`
   - Ajusta las credenciales si es necesario:
   ```php
   'host' => 'localhost',
   'dbname' => 'blog_db',
   'username' => 'root',
   'password' => '',
   ```

4. **Configurar Apache** (si usas XAMPP):
   - Asegúrate de que `mod_rewrite` esté habilitado
   - Reinicia Apache

5. **Acceder al blog**:
   ```
   http://localhost/Blog/public/
   ```

Estructura del Proyecto

```
Blog/
├── public/              # Carpeta pública (punto de entrada)
│   ├── index.php       # Router principal
│   ├── .htaccess       # Configuración Apache
│   ├── css/            # Estilos CSS
│   └── uploads/        # Imágenes subidas
├── src/
│   ├── Controllers/    # Controladores (lógica de negocio)
│   ├── Models/         # Modelos (interacción con BD)
│   └── Views/          # Vistas (HTML/PHP)
├── config/             # Configuración
│   └── database.php    # Configuración de BD
├── docs/               # Documentación
│   ├── diagrama-inicial.puml
│   └── diagrama-final.puml
└── database.sql        # Script de base de datos
```

 Uso

 Registro de usuario
1. Ve a `/register`
2. Completa el formulario con tus datos
3. La contraseña será encriptada automáticamente

 Iniciar sesión
1. Ve a `/login`
2. Ingresa tu usuario y contraseña

 Crear una publicación
1. Inicia sesión
2. Haz clic en "Crear Post" en el menú
3. Completa el título, contenido y opcionalmente sube una imagen
4. Haz clic en "Publicar"

Editar/Eliminar publicaciones
- Solo puedes editar o eliminar tus propias publicaciones
- Los botones aparecen dentro de cada post que hayas creado

 Seguridad Implementada

- **Password hashing** - `password_hash()` y `password_verify()`
- **Sentencias preparadas PDO** - Prevención de inyección SQL
- **Validación de datos** - Saneamiento de entradas con `trim()` y `htmlspecialchars()`
- **Control de sesiones** - Verificación de autenticación para acciones protegidas
- **Validación de archivos** - Verificación de tipo y tamaño de imágenes
- **Protección XSS** - Escape de datos en vistas

 Base de Datos

Tabla `users`
- `id` - ID único del usuario
- `username` - Nombre de usuario (único)
- `email` - Correo electrónico (único)
- `password` - Contraseña hasheada
- `created_at` - Fecha de registro

Tabla `posts`
- `id` - ID único del post
- `user_id` - ID del autor (FK a users)
- `title` - Título del post
- `content` - Contenido del post
- `image` - Ruta de la imagen (opcional)
- `created_at` - Fecha de creación
- `updated_at` - Fecha de última actualización

Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de datos**: MySQL
- **Frontend**: HTML5, CSS3
- **Arquitectura**: MVC (Model-View-Controller)
- **Patrón de diseño**: Singleton (conexión a BD)

Conceptos Aplicados

- Programación Orientada a Objetos (POO)
- Namespaces en PHP
- Autoload de clases
- Sistema de enrutamiento personalizado
- Patrón MVC
- Sentencias preparadas con PDO
- Gestión de sesiones
- Subida y validación de archivos
- CRUD completo

Desarrollado por Fran como proyecto educativo para el Grado de Desarrollo de Aplicaciones Multiplataforma (DAM).

