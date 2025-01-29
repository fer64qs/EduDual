<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarCarreras() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        carreras.idcarrera, 
        carreras.nombre_carrera,
        carreras.abreviatura
    FROM carreras");
    
    return $stmt->fetchAll();
}
// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarCarrera($id);
            break;
			case 'agregar':
            agregarCarrera($_POST);
            break;
			case 'editar':
            actualizarCarrera($id,$_POST);
            break;
			case 'obtenerCarrera':
            obtenerCarrera($id);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerCarrera($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtCarrera = $pdo->prepare("SELECT 
        carreras.idcarrera, 
        carreras.nombre_carrera, 
        carreras.abreviatura
        FROM carreras
        WHERE carreras.idcarrera = :idcarrera");
        $stmtCarrera->execute([':idcarrera' => $id]);

        $carrera = $stmtCarrera->fetch();

       

        if ($carrera) {
            echo json_encode([
                'success' => true, 
                'carrera' => $carrera,
                
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Carrera no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarCarrera($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre_carrera'] = mb_strtoupper($data['nombre_carrera'], 'UTF-8');
    $data['abreviatura'] = mb_strtoupper($data['abreviatura'], 'UTF-8');
  

    try {
        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE carreras SET 
            nombre_carrera = :nombre_carrera, 
            abreviatura = :abreviatura
        WHERE idcarrera = :idcarrera");

        $stmt->execute([
            ':idcarrera' => $data['id_carrera'],
            ':nombre_carrera' => $data['nombre_carrera'],
            ':abreviatura' => $data['abreviatura']
           
        ]);

        echo json_encode(['success' => true, 'message' => 'Carrera actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un alumno
function eliminarCarrera($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de la carrera no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM carreras WHERE idcarrera = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'Carrera no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM carreras WHERE idcarrera = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Carrera eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar a la carrera: ' . $e->getMessage()]);
    }
}
function agregarCarrera($data) {
    $pdo = DBC::get();
	
	$data['nombre_carrera'] = mb_strtoupper($data['nombre_carrera'], 'UTF-8');
    $data['abreviatura'] = mb_strtoupper($data['abreviatura'], 'UTF-8');
  
    try {
        // Verificar si ya existe una carrera con el mismo id
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM carreras WHERE nombre_carrera = :nombre_carrera");
        $stmt->execute([':nombre_carrera' => $data['nombre_carrera']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe una carrera igual.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO carreras (nombre_carrera, abreviatura) 
                               VALUES (:nombre_carrera, :abreviatura)");
        $stmt->execute([
            ':nombre_carrera' => $data['nombre_carrera'],
            ':abreviatura' => $data['abreviatura'],
            
        ]);
        echo json_encode(['success' => true, 'message' => 'Carrera agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar a la carrera: ' . $e->getMessage()]);
    }
}

?>