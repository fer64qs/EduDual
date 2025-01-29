<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarPlanteles() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        planteles.idplantel, 
        planteles.nombre_plantel,
        planteles.ubicacion_plantel
    FROM planteles");
    
    return $stmt->fetchAll();
}
// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarPlantel($id);
            break;
			case 'agregar':
            agregarPlantel($_POST);
            break;
			case 'editar':
            actualizarPlantel($id,$_POST);
            break;
			case 'obtenerPlantel':
            obtenerPlantel($id);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerPlantel($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtPlantel = $pdo->prepare("SELECT 
        planteles.idplantel, 
        planteles.nombre_plantel,
        planteles.ubicacion_plantel
        FROM planteles
        WHERE planteles.idplantel = :idplantel");
        $stmtPlantel->execute([':idplantel' => $id]);

        $plantel = $stmtPlantel->fetch();

       

        if ($plantel) {
            echo json_encode([
                'success' => true, 
                'plantel' => $plantel,
                
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Carrera no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarPlantel($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre_plantel'] = mb_strtoupper($data['nombre_plantel'], 'UTF-8');
    $data['ubicacion_plantel'] = mb_strtoupper($data['ubicacion_plantel'], 'UTF-8');
  

    try {
        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE planteles SET 
            nombre_plantel = :nombre_plantel, 
            ubicacion_plantel = :ubicacion_plantel
        WHERE idplantel = :idplantel");

        $stmt->execute([
            ':idplantel' => $data['id_plantel'],
            ':nombre_plantel' => $data['nombre_plantel'],
            ':ubicacion_plantel' => $data['ubicacion_plantel']
           
        ]);

        echo json_encode(['success' => true, 'message' => 'Plantel actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un alumno
function eliminarPlantel($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de la carrera no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM planteles WHERE idplantel = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'Plantel no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM planteles WHERE idplantel = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Plantel eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar plantel: ' . $e->getMessage()]);
    }
}
function agregarPlantel($data) {
    $pdo = DBC::get();
	
	$data['nombre_plantel'] = mb_strtoupper($data['nombre_plantel'], 'UTF-8');
    $data['ubicacion_plantel'] = mb_strtoupper($data['ubicacion_plantel'], 'UTF-8');
  
    try {
        // Verificar si ya existe una carrera con el mismo id
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM planteles WHERE nombre_plantel = :nombre_plantel");
        $stmt->execute([':nombre_plantel' => $data['nombre_plantel']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un plantel igual.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO planteles (nombre_plantel, ubicacion_plantel) 
                               VALUES (:nombre_plantel, :ubicacion_plantel)");
        $stmt->execute([
            ':nombre_plantel' => $data['nombre_plantel'],
            ':ubicacion_plantel' => $data['ubicacion_plantel'],
            
        ]);
        echo json_encode(['success' => true, 'message' => 'Plantel agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar a el plantel: ' . $e->getMessage()]);
    }
}

?>