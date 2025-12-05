<?php

namespace Models;

use PDO;

class User {
    private $db;
    private $id;
    private $username;
    private $email;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    // Registrar nuevo usuario
    public function register($username, $email, $password) {
        // Validar datos
        $username = trim($username);
        $email = trim($email);
        
        if (strlen($username) < 3) {
            return ['success' => false, 'message' => 'El usuario debe tener al menos 3 caracteres'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email inválido'];
        }
        
        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'];
        }

        // Verificar si el usuario ya existe
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'El usuario o email ya existe'];
        }

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar usuario
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            return ['success' => true, 'message' => 'Usuario registrado exitosamente'];
        }
        
        return ['success' => false, 'message' => 'Error al registrar el usuario'];
    }

    // Login
    public function login($username, $password) {
        $username = trim($username);
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            
            return ['success' => true, 'user' => $user];
        }

        return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
    }

    // Buscar usuario por ID
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if ($user) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            return $user;
        }

        return null;
    }
}
