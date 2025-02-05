<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar grupos con sus carreras
function cargarGrupos() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        grupos.idGrupo, 
        grupos.grupo, 
        grupos.folio, 
        carreras.idcarrera, 
        carreras.nombre_carrera 
    FROM grupos
    INNER JOIN carreras 
    ON grupos.idcarrera = carreras.idcarrera order by grupos.grupo ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarGrupo($id);
            break;
			case 'agregar':
            agregarGrupo($_POST);
            break;
			case 'editar':
            actualizarGrupo($id,$_POST);
            break;
			case 'obtenerGrupo':
            obtenerGrupo($id);
            break;
			
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}

function obtenerGrupo($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del grupo y la lista de carreras
        $stmtGrupo = $pdo->prepare("SELECT 
            grupos.idGrupo, 
            grupos.grupo, 
            grupos.folio, 
            grupos.idcarrera,
            carreras.idcarrera AS carrera_id,
            carreras.nombre_carrera
        FROM grupos
        INNER JOIN carreras
        ON grupos.idcarrera = carreras.idcarrera WHERE idGrupo = :id");
        $stmtGrupo->execute([':id' => $id]);
        $grupo = $stmtGrupo->fetch();

        // Obtener todas las carreras
        $stmtCarreras = $pdo->prepare("SELECT * FROM carreras");
        $stmtCarreras->execute();
        $carreras = $stmtCarreras->fetchAll();

        if ($grupo) {
            echo json_encode([
                'success' => true, 
                'grupo' => $grupo, 
                'carreras' => $carreras
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Grupo no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarGrupo($id,$data) {
    $pdo = DBC::get();
	
	$data['grupo'] = mb_strtoupper($data['grupo'], 'UTF-8');
    $data['folio'] = mb_strtoupper($data['folio'], 'UTF-8');
    

    try {
        // Actualizar los datos del grupo en la base de datos
        $stmt = $pdo->prepare("UPDATE grupos SET 
            grupo = :grupo, 
            folio = :folio, 
            idcarrera = :idcarrera
            
        WHERE idGrupo = :idGrupo");

        $stmt->execute([
            ':idGrupo' => $data['id_grupo'],
            ':grupo' => $data['grupo'],
            ':folio' => $data['folio'],
           
            ':idcarrera' => $data['idcarrera']
        ]);

        echo json_encode(['success' => true, 'message' => 'Grupo actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un grupo
function eliminarGrupo($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de grupo no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el grupo existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM grupos WHERE idGrupo = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El grupo no existe']);
            return;
        }

        // Eliminar el grupo
        $stmt = $pdo->prepare("DELETE FROM grupos WHERE idGrupo = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'grupo eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el grupo: ' . $e->getMessage()]);
    }
}

function agregarGrupo($data) {
    $pdo = DBC::get();
	
	$data['grupo'] = mb_strtoupper($data['grupo'], 'UTF-8');
    $data['folio'] = mb_strtoupper($data['folio'], 'UTF-8');
   
    try {
       
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM grupos WHERE grupo = :grupo");
        $stmt->execute([':grupo' => $data['grupo']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un grupo con el mismo nombre.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO grupos (grupo, folio, idcarrera) 
                               VALUES (:grupo, :folio, :idcarrera)");
        $stmt->execute([
            ':grupo' => $data['grupo'],
            ':folio' => $data['folio'],
          
            ':idcarrera' => $data['idcarrera']
        ]);
        echo json_encode(['success' => true, 'message' => 'Grupo agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el grupo: ' . $e->getMessage()]);
    }
}

?>