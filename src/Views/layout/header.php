<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mi Blog' ?></title>
    <link rel="stylesheet" href="/Blog/public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/Blog/public/" class="logo">Mi Blog</a>
            <ul class="nav-menu">
                <li><a href="/Blog/public/">Inicio</a></li>
                <li><a href="/Blog/public/posts">Jugadores</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/Blog/public/post/create">Crear Jugador</a></li>
                    <li><a href="/Blog/public/logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/Blog/public/login">Login</a></li>
                    <li><a href="/Blog/public/register">Registro</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
