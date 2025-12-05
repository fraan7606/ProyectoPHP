<?php

namespace Controllers;

use Models\User;

class AuthController {
    
    // Procesar login
    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = new User();
            $result = $user->login($username, $password);
            
            if ($result['success']) {
                $_SESSION['user_id'] = $result['user']['id'];
                $_SESSION['username'] = $result['user']['username'];
                $_SESSION['message'] = 'Bienvenido ' . $result['user']['username'];
                header('Location: /Blog/public/');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /Blog/public/login');
                exit;
            }
        }
    }
    
    // Procesar registro
    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            // Validar que las contraseñas coincidan
            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Las contraseñas no coinciden';
                header('Location: /Blog/public/register');
                exit;
            }
            
            $user = new User();
            $result = $user->register($username, $email, $password);
            
            if ($result['success']) {
                $_SESSION['message'] = $result['message'] . '. Ahora puedes iniciar sesión.';
                header('Location: /Blog/public/login');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /Blog/public/register');
                exit;
            }
        }
    }
    
    // Cerrar sesión
    public static function logout() {
        session_destroy();
        header('Location: /Blog/public/');
        exit;
    }
}
