<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarConfiguracion() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        configuracion.id_configuracion, 
        configuracion.nombre_director
    FROM configuracion");
    
    return $stmt->fetchAll();
}
// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
			case 'editar':
            actualizarConfiguracion($id,$_POST);
            break;
			case 'obtenerConfiguracion':
            obtenerConfiguracion($id);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerConfiguracion($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtConfiguracion = $pdo->prepare("SELECT 
        configuracion.id_configuracion, 
        configuracion.nombre_director
        FROM configuracion
        WHERE configuracion.id_configuracion = :id_configuracion");
        $stmtConfiguracion->execute([':id_configuracion' => $id]);

        $configuracion = $stmtConfiguracion->fetch();

       

        if ($configuracion) {
            echo json_encode(value: [
                'success' => true, 
                'configuracion' => $configuracion,
                
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Carrera no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarConfiguracion($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre_director'] = mb_strtoupper($data['nombre_director'], 'UTF-8');

  

    try {
        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE configuracion SET 
            nombre_director = :nombre_director 
        WHERE id_configuracion = :id_configuracion");

        $stmt->execute([
            ':id_configuracion' => $data['id_configuracion'],
            ':nombre_director' => $data['nombre_director']
           
        ]);

        echo json_encode(['success' => true, 'message' => 'Nombre del director actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

