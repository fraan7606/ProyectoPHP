<?php 
use Models\Post;

$title = 'Ver Post';
require __DIR__ . '/../layout/header.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    ?>
    <div class="auth-required">
        <h2>Debes iniciar sesión para ver este post</h2>
        <p>Regístrate o inicia sesión para acceder al contenido del blog.</p>
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
            <a href="/Blog/public/login" class="btn btn-primary">Iniciar Sesión</a>
            <a href="/Blog/public/register" class="btn btn-secondary">Registrarse</a>
        </div>
    </div>
    <?php
    require __DIR__ . '/../layout/footer.php';
    exit;
}

$postId = $_GET['id'] ?? 1;
$postModel = new Post();
$post = $postModel->findById($postId);

if (!$post) {
    header('Location: /Blog/public/posts');
    exit;
}

$title = $post['title'];
?>

<article class="post-single">
    <div class="post-header">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <p class="post-meta">
            Publicado el <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?> 
            por <strong><?= htmlspecialchars($post['username']) ?></strong>
        </p>
    </div>
    
    <?php if ($post['image']): ?>
    <div class="post-image-full">
        <img src="/Blog/public/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
    </div>
    <?php endif; ?>
    
    <div class="post-body">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
    
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
    <div class="post-actions">
        <a href="/Blog/public/post/edit/<?= $post['id'] ?>" class="btn btn-edit">Editar</a>
        <a href="/Blog/public/post/delete/<?= $post['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este post?')">Eliminar</a>
    </div>
    <?php endif; ?>
</article>

<div class="back-link">
    <a href="/Blog/public/posts">&larr; Volver a todos los jugadores</a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
