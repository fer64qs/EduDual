<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarAlumnos() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        alumnos.idalumno, 
        alumnos.nombre, 
        alumnos.apellidop, 
        alumnos.apellidom, 
        alumnos.correo, 
        alumnos.curp, 
        alumnos.sexo, 
        alumnos.num_control, 
        alumnos.celular, 
        carreras.idcarrera, 
        carreras.nombre_carrera 
    FROM alumnos
    INNER JOIN carreras 
    ON alumnos.idcarrera = carreras.idcarrera order by alumnos.nombre ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarAlumno($id);
            break;
			case 'agregar':
            agregarAlumno($_POST);
            break;
			case 'editar':
            actualizarAlumno($id,$_POST);
            break;
			case 'obtenerAlumno':
            obtenerAlumno($id);
            break;
			case 'verificarcuenta':
			$correo = $_POST['correo'] ?? '';
            $idperfil = $_POST['idperfil'] ?? '';
            verificarSitieneCuenta($correo, $idperfil);
			//echo "algo";
			break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerAlumno($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtAlumno = $pdo->prepare("SELECT 
            alumnos.idalumno, 
            alumnos.nombre, 
            alumnos.apellidop, 
            alumnos.apellidom, 
            alumnos.correo, 
            alumnos.curp, 
            alumnos.sexo, 
            alumnos.num_control, 
            alumnos.celular, 
            alumnos.idcarrera,
            carreras.idcarrera AS carrera_id,
            carreras.nombre_carrera
        FROM alumnos
        INNER JOIN carreras 
        ON alumnos.idcarrera = carreras.idcarrera WHERE idalumno = :id");
        $stmtAlumno->execute([':id' => $id]);
        $alumno = $stmtAlumno->fetch();

        // Obtener todas las carreras
        $stmtCarreras = $pdo->prepare("SELECT * FROM carreras");
        $stmtCarreras->execute();
        $carreras = $stmtCarreras->fetchAll();

        if ($alumno) {
            echo json_encode([
                'success' => true, 
                'alumno' => $alumno, 
                'carreras' => $carreras
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Alumno no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarAlumno($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['num_control'] = mb_strtoupper($data['num_control'], 'UTF-8');
	$data['curp'] = mb_strtoupper($data['curp'], 'UTF-8');

    try {
        // Actualizar los datos del alumno en la base de datos
         // Verificar si ya existe un alumno con el mismo CURP
         $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE curp = :curp");
         $stmt->execute([':curp' => $data['curp']]);
         if ($stmt->fetchColumn() > 0) {
             echo json_encode(['success' => false, 'message' => 'Ya existe un alumno con la misma CURP.']);
             return;
         }
        $stmt = $pdo->prepare("UPDATE alumnos SET 
            nombre = :nombre, 
            apellidop = :apellidop, 
            apellidom = :apellidom, 
            correo = :correo, 
            curp = :curp, 
            sexo = :sexo, 
            num_control = :num_control, 
            celular = :celular, 
            idcarrera = :idcarrera
        WHERE idalumno = :idalumno");

        $stmt->execute([
            ':idalumno' => $data['id_alumno'],
            ':nombre' => $data['nombre'],
            ':apellidop' => $data['apellidop'],
            ':apellidom' => $data['apellidom'],
            ':correo' => $data['correo'],
            ':curp' => $data['curp'],
            ':sexo' => $data['sexo'],
            ':num_control' => $data['num_control'],
            ':celular' => $data['celular'],
            ':idcarrera' => $data['idcarrera']
        ]);

        echo json_encode(['success' => true, 'message' => 'Alumno actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}



// Función para eliminar un alumno
function eliminarAlumno($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de alumno no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE idalumno = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El alumno no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM alumnos WHERE idalumno = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Alumno eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el alumno: ' . $e->getMessage()]);
    }
}




function agregarAlumno($data) {
    $pdo = DBC::get();
	
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['num_control'] = mb_strtoupper($data['num_control'], 'UTF-8');
	$data['curp'] = mb_strtoupper($data['curp'], 'UTF-8');


    try {
        // Verificar si ya existe un alumno con el mismo CURP
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE curp = :curp");
        $stmt->execute([':curp' => $data['curp']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un alumno con la misma CURP.']);
            return;
        }

        // Verificar si ya existe un alumno con el mismo correo
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE correo = :correo");
        $stmt->execute([':correo' => $data['correo']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un alumno con el mismo correo.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO alumnos (nombre, apellidop, apellidom, correo, curp, sexo, num_control, celular, idcarrera) 
                               VALUES (:nombre, :apellidop, :apellidom, :correo, :curp, :sexo, :num_control, :celular, :idcarrera)");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellidop' => $data['apellidop'],
            ':apellidom' => $data['apellidom'],
            ':correo' => $data['correo'],
            ':curp' => $data['curp'],
            ':sexo' => $data['sexo'],
            ':num_control' => $data['num_control'],
            ':celular' => $data['celular'],
            ':idcarrera' => $data['idcarrera']
        ]);

        echo json_encode(['success' => true, 'message' => 'Alumno agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el alumno: ' . $e->getMessage()]);
    }
}


function verificarSitieneCuenta($correo_int, $idperfil_int) {
    $pdo = DBC::get();

    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM usuarios 
            WHERE usuarios.email = :correo 
            AND usuarios.idperfil = :idperfil
        ");
        $stmt->execute([
            ':correo' => $correo_int,
            ':idperfil' => $idperfil_int
        ]);

        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Alumno tiene cuenta
            echo json_encode(['success' => true, 'message' => 'El Alumno ya tiene una cuenta de Usuario. Para gestionarla deberá hacerlo directamente desde el Catálogo de Usuarios.']);
        } else {
            // Alumno no tiene cuenta
            echo json_encode(['success' => false, 'message' => 'El Alumno no tiene una cuenta de Usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar: ' . $e->getMessage()]);
    }
}




?>