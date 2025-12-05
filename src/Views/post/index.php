<?php 
use Models\Post;

$title = 'Todos los Posts';
require __DIR__ . '/../layout/header.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    ?>
    <div class="auth-required">
        <h2>Debes iniciar sesión para ver las publicaciones</h2>
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

$postModel = new Post();
$posts = $postModel->getAll();
?>

<div class="page-header">
    <h1>Todas las Publicaciones</h1>
</div>

<div class="posts-grid">
    <?php if (empty($posts)): ?>
        <p>No hay jugadores aún.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
        <article class="post-card">
            <div class="post-image">
                <?php if ($post['image']): ?>
                    <img src="/Blog/public/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                <?php else: ?>
                    <img src="https://via.placeholder.com/400x250" alt="Sin imagen">
                <?php endif; ?>
            </div>
            <div class="post-content">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p class="post-meta">
                    Por <strong><?= htmlspecialchars($post['username']) ?></strong> 
                    el <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                </p>
                <p class="post-excerpt"><?= htmlspecialchars(substr($post['content'], 0, 150)) ?>...</p>
                <a href="/Blog/public/post/<?= $post['id'] ?>" class="btn">Leer más</a>
            </div>
        </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
