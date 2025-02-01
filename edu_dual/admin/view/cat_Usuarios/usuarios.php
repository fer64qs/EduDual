<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');

// Función para cargar alumnos con sus carreras
function cargarUsuarios() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
    usuarios.idusuario,
    usuarios.nombres,
    usuarios.apellidos,
    usuarios.clave_sie,
    usuarios.contrasenia,
    usuarios.email,
    usuarios.telefono,
    usuarios.foto,
    usuarios.idperfil,
    perfiles_usuarios.idperfil AS perfiles_usuarios_id,
    perfiles_usuarios.nombre_perfil
    FROM usuarios
    INNER JOIN perfiles_usuarios 
    ON usuarios.idperfil = perfiles_usuarios.idperfil order by usuarios.nombres ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarUsuario($id);
            break;
			case 'editar':
            actualizarUsuario($id,$_POST);
            break;
			case 'obtenerUsuario':
            obtenerUsuario($id);
            break;
            default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerUsuario($id) {
    $pdo = DBC::get();
	$pdo->exec("SET NAMES 'utf8mb4'"); /*ESTO PASA EN UTF8 LOS CARACTERES*/
    try {
        // Obtener los datos del tutor
        $stmtUsuario = $pdo->prepare("SELECT 
        usuarios.idusuario,
        usuarios.nombres,
        usuarios.apellidos,
        usuarios.clave_sie,
        usuarios.contrasenia,
        usuarios.email,
        usuarios.telefono,
        usuarios.foto,
        usuarios.idperfil,
        perfiles_usuarios.idperfil
        perfiles_usuarios.nombre_perfil
        FROM usuarios
        INNER JOIN perfiles_usuarios 
        ON usuarios.idperfil = perfiles_usuarios.idperfil WHERE idusuario = :id");
        $stmtUsuario->execute([':id' => $id]);
        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        // Obtener todas las carreras
        $stmtPerfiles_usuarios = $pdo->prepare("SELECT * FROM perfiles_usuarios");
        $stmtPerfiles_usuarios->execute();
        $perfiles_usuarios = $stmtPerfiles_usuarios->fetchAll();

        if ($usuario) {
            echo json_encode([
                'success' => true, 
                'usuario' => $usuario, 
                'perfiles_usuarios' => $perfiles_usuarios
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un alumno
function eliminarUsuario($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de alumno no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE idusuario = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El alumno no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE idusuario = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
    }
}
?>