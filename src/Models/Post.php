<?php

namespace Models;

use PDO;

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los posts
    public function getAll() {
        $stmt = $this->db->query("
            SELECT p.*, u.username 
            FROM posts p 
            INNER JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    // Obtener un post por ID
    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username 
            FROM posts p 
            INNER JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Crear nuevo post
    public function create($userId, $title, $content, $image = null) {
        // Validar datos
        $title = trim($title);
        $content = trim($content);
        
        if (empty($title) || empty($content)) {
            return ['success' => false, 'message' => 'El título y contenido son obligatorios'];
        }
        
        // Validar longitud máxima
        if (strlen($title) > 100) {
            return ['success' => false, 'message' => 'El título no puede exceder 100 caracteres'];
        }
        
        if (strlen($content) > 5000) {
            return ['success' => false, 'message' => 'El contenido no puede exceder 5000 caracteres'];
        }

        $stmt = $this->db->prepare("
            INSERT INTO posts (user_id, title, content, image) 
            VALUES (?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$userId, $title, $content, $image])) {
            return ['success' => true, 'message' => 'Post creado exitosamente', 'id' => $this->db->lastInsertId()];
        }
        
        return ['success' => false, 'message' => 'Error al crear el post'];
    }

    // Actualizar post
    public function update($id, $title, $content, $image = null) {
        $title = trim($title);
        $content = trim($content);
        
        if (empty($title) || empty($content)) {
            return ['success' => false, 'message' => 'El título y contenido son obligatorios'];
        }
        
        // Validar longitud máxima
        if (strlen($title) > 100) {
            return ['success' => false, 'message' => 'El título no puede exceder 100 caracteres'];
        }
        
        if (strlen($content) > 5000) {
            return ['success' => false, 'message' => 'El contenido no puede exceder 5000 caracteres'];
        }

        if ($image) {
            $stmt = $this->db->prepare("
                UPDATE posts 
                SET title = ?, content = ?, image = ? 
                WHERE id = ?
            ");
            $result = $stmt->execute([$title, $content, $image, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE posts 
                SET title = ?, content = ? 
                WHERE id = ?
            ");
            $result = $stmt->execute([$title, $content, $id]);
        }

        if ($result) {
            return ['success' => true, 'message' => 'Post actualizado exitosamente'];
        }
        
        return ['success' => false, 'message' => 'Error al actualizar el post'];
    }

    // Eliminar post
    public function delete($id) {
        // Obtener la imagen antes de eliminar
        $post = $this->findById($id);
        
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            // Eliminar imagen si existe
            if ($post && $post['image'] && file_exists(__DIR__ . '/../../public/' . $post['image'])) {
                unlink(__DIR__ . '/../../public/' . $post['image']);
            }
            
            return ['success' => true, 'message' => 'Post eliminado exitosamente'];
        }
        
        return ['success' => false, 'message' => 'Error al eliminar el post'];
    }

    // Obtener posts por usuario
    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username 
            FROM posts p 
            INNER JOIN users u ON p.user_id = u.id 
            WHERE p.user_id = ? 
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Verificar si el usuario es dueño del post
    public function isOwner($postId, $userId) {
        $stmt = $this->db->prepare("SELECT user_id FROM posts WHERE id = ?");
        $stmt->execute([$postId]);
        $post = $stmt->fetch();
        
        return $post && $post['user_id'] == $userId;
    }
}
