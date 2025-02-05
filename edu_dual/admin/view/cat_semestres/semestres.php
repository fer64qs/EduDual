<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');

function cargarSemestres() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        semestres.idSemestre,
        semestres.semestre,
        semestres.fecha_inicio, 
        semestres.fecha_fin
        FROM semestres");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarSemestre($id);
            break;
			case 'agregar':
            agregarSemestre($_POST);
            break;
			case 'editar':
            actualizarSemestre($id,$_POST);
            break;
			case 'obtenerSemestre':
            obtenerSemestre($id);
            break;
			
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerSemestre($id) {
    $pdo = DBC::get();
    try {
        
        $stmtSemestre = $pdo->prepare("SELECT 
           semestres.idSemestre,
            semestres.semestre,
            semestres.fecha_inicio, 
            semestres.fecha_fin
        FROM semestres
        WHERE semestres.idSemestre = :idSemestre");
        $stmtSemestre->execute([':idSemestre' => $id]);
        $semestre = $stmtSemestre->fetch();

        

        if ($semestre) {
            echo json_encode([
                'success' => true, 
                'semestre' => $semestre,
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Semestre no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarSemestre($id,$data) {
    $pdo = DBC::get();
	
	$data['semestre'] = mb_strtoupper($data['semestre'], 'UTF-8');
    $data['fecha_inicio'] = mb_strtoupper($data['fecha_inicio'], 'UTF-8');
    $data['fecha_fin'] = mb_strtoupper($data['fecha_fin'], 'UTF-8');
  
    try {
        // Actualizar los datos en la base de datos
        $stmt = $pdo->prepare("UPDATE semestres SET 
            semestre = :semestre, 
            fecha_inicio = :fecha_inicio,
            fecha_fin = :fecha_fin
        WHERE idSemestre = :idSemestre");

        $stmt->execute([
            ':idSemestre' => $data['id_Semestre'],
            ':semestre' => $data['semestre'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin']
           
        ]);

        echo json_encode(['success' => true, 'message' => 'Semestre actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}

// Función para eliminar un semestre
function eliminarSemestre($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID del semestre no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el semestre existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM semestres WHERE idSemestre = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'Semestre no existe']);
            return;
        }

        // Eliminar el semestre
        $stmt = $pdo->prepare("DELETE FROM semestres WHERE idSemestre = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Semestre eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar al semestre: ' . $e->getMessage()]);
    }
}
function agregarSemestre($data) {
    $pdo = DBC::get();
	
	$data['semestre'] = mb_strtoupper($data['semestre'], 'UTF-8');
    $data['fecha_inicio'] = mb_strtoupper($data['fecha_inicio'], 'UTF-8');
    $data['fecha_fin'] = mb_strtoupper($data['fecha_fin'], 'UTF-8');
  
    try {
        // Verificar si ya existe una semestre con el mismo id
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM semestres WHERE semestre = :semestre");
        $stmt->execute([':semestre' => $data['semestre']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un semestre igual.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO semestres (semestre, fecha_inicio, fecha_fin) 
                               VALUES (:semestre, :fecha_inicio, :fecha_fin)");
        $stmt->execute([
            ':semestre' => $data['semestre'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            
        ]);
        echo json_encode(['success' => true, 'message' => 'semestre agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar a la semestre: ' . $e->getMessage()]);
    }
}

?>