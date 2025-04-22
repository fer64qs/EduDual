<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php');
$pdo = DBC::get();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id_noticia = ?");
    $stmt->execute([$id]);
    $noticia = $stmt->fetch();

    if (!$noticia) {
        echo "Noticia no encontrada.";
        exit;
    }
} else {
    echo "No se especificó el ID de la noticia.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    // Procesar la imagen
    $imagen = $noticia['imagen']; // Mantener la imagen existente
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagenTmp = $_FILES['imagen']['tmp_name'];
        $imagenName = $_FILES['imagen']['name'];
        $imagenPath = 'uploads/' . basename($imagenName);

        // Mover la nueva imagen al directorio de destino
        if (move_uploaded_file($imagenTmp, $_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/uploads/' . $imagenName)) {
            $imagen = $imagenPath;
        }
    }

    // Actualizar la noticia con la nueva imagen (si se ha cambiado)
    $stmt = $pdo->prepare("UPDATE noticias SET titulo = ?, subtitulo = ?, descripcion = ?, fecha = ?, imagen = ? WHERE id_noticia = ?");
    $stmt->execute([$titulo, $subtitulo, $descripcion, $fecha, $imagen, $id]);

    // Redirigir a la lista de noticias después de guardar
    header('Location: ../formcat_noticias.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Noticia</h2>
    <form action="editar_noticia.php?id=<?= $noticia['id_noticia'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control" value="<?= htmlspecialchars($noticia['titulo'], ENT_QUOTES) ?>" required>
        </div>
        <div class="mb-3">
            <label for="subtitulo" class="form-label">Subtítulo</label>
            <input type="text" id="subtitulo" name="subtitulo" class="form-control" value="<?= htmlspecialchars($noticia['subtitulo'], ENT_QUOTES) ?>">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required><?= htmlspecialchars($noticia['descripcion'], ENT_QUOTES) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="<?= $noticia['fecha'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
            <?php if ($noticia['imagen']): ?>
                <p><img src="<?= $noticia['imagen'] ?>" alt="Imagen actual" style="max-width: 100px;"></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

</body>
</html>