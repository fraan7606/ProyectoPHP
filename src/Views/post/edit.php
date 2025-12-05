<?php 
use Models\Post;

$postId = $_GET['id'] ?? 1;
$postModel = new Post();
$post = $postModel->findById($postId);

if (!$post) {
    header('Location: /Blog/public/posts');
    exit;
}

// Verificar que el usuario sea dueño del post
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $post['user_id']) {
    $_SESSION['error'] = 'No tienes permiso para editar este post';
    header('Location: /Blog/public/post/' . $postId);
    exit;
}

$title = 'Editar Post';
require __DIR__ . '/../layout/header.php'; 
?>

<div class="page-header">
    <h1>Editar jugador</h1>
</div>

<form class="form-post" method="POST" action="/Blog/public/post/edit/<?= $post['id'] ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Título del Post</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required maxlength="100">
        <small>Máximo 100 caracteres</small>
    </div>
    
    <div class="form-group">
        <label for="content">Contenido</label>
        <textarea id="content" name="content" rows="10" required maxlength="5000"><?= htmlspecialchars($post['content']) ?></textarea>
        <small>Máximo 5000 caracteres</small>
    </div>
    
    <?php if ($post['image']): ?>
    <div class="form-group">
        <label>Imagen actual</label><br>
        <img src="/Blog/public/<?= htmlspecialchars($post['image']) ?>" alt="Imagen actual" style="max-width: 200px; border-radius: 8px;">
    </div>
    <?php endif; ?>
    
    <div class="form-group">
        <label for="image">Cambiar imagen</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="/Blog/public/post/<?= $post['id'] ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
