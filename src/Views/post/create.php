<?php 
$title = 'Crear Nueva Publicación';
require __DIR__ . '/../layout/header.php'; 
?>

<div class="page-header">
    <h1>Añadir Nuevo Jugador</h1>
</div>

<form class="form-post" method="POST" action="/Blog/public/post/create" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Nombre del jugador</label>
        <input type="text" id="title" name="title" required placeholder="Ingresa el nombre del jugador" maxlength="100">
        <small>Máximo 100 caracteres</small>
    </div>
    
    <div class="form-group">
        <label for="content">Contenido</label>
        <textarea id="content" name="content" rows="10" required placeholder="Escribe la frase del jugador..." maxlength="5000"></textarea>
        <small>Máximo 5000 caracteres</small>
    </div>
    
    <div class="form-group">
        <label for="image">Imagen del jugador</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Publicar</button>
        <a href="/Blog/public/posts" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
3
