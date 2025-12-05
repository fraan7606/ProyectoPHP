<?php 
$title = 'Iniciar Sesión';
require __DIR__ . '/../layout/header.php'; 
?>

<div class="auth-container">
    <div class="auth-box">
        <h1>Iniciar Sesión</h1>
        
        <form class="auth-form" method="POST" action="/Blog/public/login">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required placeholder="Tu nombre de usuario">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Tu contraseña">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>
        
        <p class="auth-link">
            ¿No tienes cuenta? <a href="/Blog/public/register">Regístrate aquí</a>
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
