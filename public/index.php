<?php
session_start();

// Autoload simple
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use Controllers\AuthController;
use Controllers\PostController;

// Obtener la URL solicitada
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/Blog/public', '', $request);
$request = strtok($request, '?'); // Eliminar query string

// Rutas simples
switch ($request) {
    case '/':
    case '':
        require __DIR__ . '/../src/Views/home.php';
        break;
    
    case '/posts':
        require __DIR__ . '/../src/Views/post/index.php';
        break;
    
    case '/post/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PostController::create();
        } else {
            require __DIR__ . '/../src/Views/post/create.php';
        }
        break;
    
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AuthController::login();
        } else {
            require __DIR__ . '/../src/Views/auth/login.php';
        }
        break;
    
    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AuthController::register();
        } else {
            require __DIR__ . '/../src/Views/auth/register.php';
        }
        break;
    
    case '/logout':
        AuthController::logout();
        break;
    
    default:
        // Verificar si es un post individual (ej: /post/1)
        if (preg_match('/^\/post\/(\d+)$/', $request, $matches)) {
            $_GET['id'] = $matches[1];
            require __DIR__ . '/../src/Views/post/show.php';
        }
        // Editar post (ej: /post/edit/1)
        elseif (preg_match('/^\/post\/edit\/(\d+)$/', $request, $matches)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                PostController::update($matches[1]);
            } else {
                $_GET['id'] = $matches[1];
                require __DIR__ . '/../src/Views/post/edit.php';
            }
        }
        // Eliminar post (ej: /post/delete/1)
        elseif (preg_match('/^\/post\/delete\/(\d+)$/', $request, $matches)) {
            PostController::delete($matches[1]);
        }
        else {
            http_response_code(404);
            echo "404 - Página no encontrada";
        }
        break;
}
