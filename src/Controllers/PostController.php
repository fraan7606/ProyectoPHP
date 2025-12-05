<?php

namespace Controllers;

use Models\Post;

class PostController {
    
    // Procesar creación de post
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Debes iniciar sesión para crear un post';
                header('Location: /Blog/public/login');
                exit;
            }
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $imagePath = null;
            
            // Procesar imagen si fue subida
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = self::uploadImage($_FILES['image']);
                if (!$imagePath) {
                    $_SESSION['error'] = 'Error al subir la imagen';
                    header('Location: /Blog/public/post/create');
                    exit;
                }
            }
            
            $post = new Post();
            $result = $post->create($_SESSION['user_id'], $title, $content, $imagePath);
            
            if ($result['success']) {
                $_SESSION['message'] = $result['message'];
                header('Location: /Blog/public/post/' . $result['id']);
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /Blog/public/post/create');
                exit;
            }
        }
    }
    
    // Procesar edición de post
    public static function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Debes iniciar sesión';
                header('Location: /Blog/public/login');
                exit;
            }
            
            // Verificar que el usuario sea dueño del post
            $postModel = new Post();
            if (!$postModel->isOwner($id, $_SESSION['user_id'])) {
                $_SESSION['error'] = 'No tienes permiso para editar este post';
                header('Location: /Blog/public/post/' . $id);
                exit;
            }
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $imagePath = null;
            
            // Procesar imagen si fue subida
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = self::uploadImage($_FILES['image']);
            }
            
            $result = $postModel->update($id, $title, $content, $imagePath);
            
            if ($result['success']) {
                $_SESSION['message'] = $result['message'];
                header('Location: /Blog/public/post/' . $id);
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /Blog/public/post/edit/' . $id);
                exit;
            }
        }
    }
    
    // Procesar eliminación de post
    public static function delete($id) {
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Debes iniciar sesión';
            header('Location: /Blog/public/login');
            exit;
        }
        
        // Verificar que el usuario sea dueño del post
        $post = new Post();
        if (!$post->isOwner($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'No tienes permiso para eliminar este post';
            header('Location: /Blog/public/post/' . $id);
            exit;
        }
        
        $result = $post->delete($id);
        
        if ($result['success']) {
            $_SESSION['message'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        
        header('Location: /Blog/public/posts');
        exit;
    }
    
    // Subir imagen
    private static function uploadImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        // Validar tipo
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        // Validar tamaño
        if ($file['size'] > $maxSize) {
            return false;
        }
        
        // Generar nombre único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../public/uploads/images/' . $filename;
        
        // Mover archivo
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return 'uploads/images/' . $filename;
        }
        
        return false;
    }
}
