<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php');
header('Content-Type: text/html; charset=utf-8');

// Cargar todas las noticias
function cargarNoticias() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT
    noticias.id_noticia,
    noticias.titulo,
    noticias.subtitulo,
    noticias.fecha,
    noticias.descripcion,
    noticias.imagen
    FROM noticias");
    
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'agregar':
            agregarNoticia($_POST);
            break;
        case 'eliminar':
            eliminarNoticia($id);
            break;
        case 'editar':
            actualizarNoticia($id, $_POST);
            break;
        case 'obtenerNoticia':
            obtenerNoticia($id);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}

// agregar noticia
function agregarNoticia($data) {
    $pdo = DBC::get();

    $titulo = $data['titulo'];
    $subtitulo = $data['subtitulo'];
    $fecha = $data['fecha'];
    $descripcion = $data['descripcion'];
    $imagen = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
        $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/uploads/' . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = '/edu_dual/admin/uploads/' . $nombreArchivo;

        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen.']);
            return;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO noticias (titulo, subtitulo, fecha, descripcion, imagen)
                               VALUES (:titulo, :subtitulo, :fecha, :descripcion, :imagen)");
        $stmt->execute([
            ':titulo' => $titulo,
            ':subtitulo' => $subtitulo,
            ':fecha' => $fecha,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen
        ]);

        echo json_encode(['success' => true, 'message' => 'Noticia agregada correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la noticia: ' . $e->getMessage()]);
    }
}


// Obtener una noticia específica
function obtenerNoticia($id) {
    $pdo = DBC::get();
    $pdo->exec("SET NAMES 'utf8mb4'");

    try {
        $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id_noticia = :id");
        $stmt->execute([':id' => $id]);
        $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($noticia) {
            echo json_encode([
                'success' => true,
                'noticia' => $noticia
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Noticia no encontrada']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener la noticia: ' . $e->getMessage()]);
    }
}

// Eliminar una noticia
function eliminarNoticia($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de noticia no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Obtener la imagen actual de la noticia
        $stmt = $pdo->prepare("SELECT imagen FROM noticias WHERE id_noticia = :id");
        $stmt->execute([':id' => $id]);
        $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($noticia && !empty($noticia['imagen'])) {
            $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/' . $noticia['imagen'];
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen); // Eliminar imagen del servidor
            }
        }

        // Eliminar noticia de la base de datos
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Noticia eliminada exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la noticia: ' . $e->getMessage()]);
    }
}

// Actualizar una noticia
function actualizarNoticia($id, $data) {
    // Conexión a la base de datos
    $pdo = DBC::get();

    // Obtiene la noticia actual (para verificar si la imagen se mantiene o se reemplaza)
    $stmt = $pdo->prepare("SELECT imagen FROM noticias WHERE id_noticia = :id");
    $stmt->execute([':id' => $id]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se ha subido una nueva imagen, conservamos la imagen actual
    $imagen = $noticia['imagen'];

    // Si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Genera un nombre único para la nueva imagen
        $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
        $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/uploads/' . $nombreArchivo;

        // Intenta mover la nueva imagen al directorio de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            // Si ya había una imagen, elimina la imagen anterior del servidor
            if (!empty($imagen)) {
                $rutaImagenAnterior = $_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/' . $imagen;
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior); // Elimina la imagen anterior
                }
            }
            // Asigna el nombre de la nueva imagen a la variable $imagen
            $imagen = 'uploads/' . $nombreArchivo; // Actualiza la ruta de la imagen
        } else {
            // Si ocurre un error al guardar la nueva imagen
            echo json_encode(['success' => false, 'message' => 'Error al guardar la nueva imagen.']);
            return;
        }
    }

    // Intentar actualizar la noticia en la base de datos
    try {
        $stmt = $pdo->prepare("UPDATE noticias SET 
            titulo = :titulo,
            subtitulo = :subtitulo,
            fecha = :fecha,
            descripcion = :descripcion,
            imagen = :imagen
            WHERE id_noticia = :id");

        // Ejecutar la actualización con los datos proporcionados
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':subtitulo' => $data['subtitulo'],
            ':fecha' => $data['fecha'],
            ':descripcion' => $data['descripcion'],
            ':imagen' => $imagen, // Aquí se usa la nueva imagen o la anterior si no se subió una nueva
            ':id' => $id
        ]);

        // Responder con éxito
        echo json_encode(['success' => true, 'message' => 'Noticia actualizada correctamente']);
    } catch (Exception $e) {
        // En caso de error en la actualización, devolver el mensaje de error
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la noticia: ' . $e->getMessage()]);
    }
}
?>
