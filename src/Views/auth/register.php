<?php 
$title = 'Registro';
require __DIR__ . '/../layout/header.php'; 
?>

<div class="auth-container">
    <div class="auth-box">
        <h1>Crear Cuenta</h1>
        
        <form class="auth-form" method="POST" action="/Blog/public/register">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required placeholder="Elige un nombre de usuario">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirmar Contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm" required placeholder="Repite la contraseña">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
        
        <p class="auth-link">
            ¿Ya tienes cuenta? <a href="/Blog/public/login">Inicia sesión aquí</a>
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
