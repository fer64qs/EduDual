<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarAsignaturas() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        asignaturas.idasignatura, 
        asignaturas.nombre_asignatura,
        asignaturas.clave,
        asignaturas.creditos
    FROM asignaturas");
    
    return $stmt->fetchAll();
}
// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarAsignatura($id);
            break;
			case 'agregar':
            agregarAsignatura($_POST);
            break;
			case 'editar':
            actualizarAsignatura($id,$_POST);
            break;
			case 'obtenerAsignatura':
            obtenerAsignatura($id);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerAsignatura($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtAsignatura = $pdo->prepare("SELECT 
        asignaturas.idasignatura, 
        asignaturas.nombre_asignatura, 
        asignaturas.clave,
        asignaturas.creditos
        FROM asignaturas
        WHERE asignaturas.idasignatura = :idasignatura");
        $stmtAsignatura->execute([':idasignatura' => $id]);

        $asignatura = $stmtAsignatura->fetch();

       

        if ($asignatura) {
            echo json_encode([
                'success' => true, 
                'asignatura' => $asignatura,
                
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Asignatura no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarAsignatura($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre_asignatura'] = mb_strtoupper($data['nombre_asignatura'], 'UTF-8');
    $data['clave'] = mb_strtoupper($data['clave'], 'UTF-8');
    $data['creditos'] = mb_strtoupper($data['creditos'], 'UTF-8');
  

    try {
        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE asignaturas SET 
            nombre_asignatura = :nombre_asignatura, 
            clave = :clave,
            creditos = :creditos,
            idasignatura = :idasignatura
            
        WHERE idasignatura = :idasignatura");

        $stmt->execute([
            ':idasignatura' => $data['id_asignatura'],
            ':nombre_asignatura' => $data['nombre_asignatura'],
            ':clave' => $data['clave'],
            ':creditos' => $data['creditos']
        ]);

        echo json_encode(['success' => true, 'message' => 'Asignatura actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un alumno
function eliminarAsignatura($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de la asignatura no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM asignaturas WHERE idasignatura = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'asignatura no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM asignaturas WHERE idasignatura = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Asignatura eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar a la asignatura: ' . $e->getMessage()]);
    }
}
function agregarAsignatura($data) {
    $pdo = DBC::get();
	
	$data['nombre_asignatura'] = mb_strtoupper($data['nombre_asignatura'], 'UTF-8');
    $data['clave'] = mb_strtoupper($data['clave'], 'UTF-8');
    $data['creditos'] = mb_strtoupper($data['creditos'], 'UTF-8');
  
    try {
        // Verificar si ya existe una carrera con el mismo id
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM asignaturas WHERE nombre_asignatura = :nombre_asignatura");
        $stmt->execute([':nombre_asignatura' => $data['nombre_asignatura']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe una asignatura igual.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO asignaturas (nombre_asignatura, clave, creditos) 
                               VALUES (:nombre_asignatura, :clave, :creditos)");
        $stmt->execute([
            ':nombre_asignatura' => $data['nombre_asignatura'],
            ':clave' => $data['clave'],
            ':creditos' => $data['creditos'],
            
        ]);
        echo json_encode(['success' => true, 'message' => 'Asignatura agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar a la carrera: ' . $e->getMessage()]);
    }
}

?>