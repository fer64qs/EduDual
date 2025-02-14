<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');

// Función para cargar alumnos con sus carreras
function cargarPersonal() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        personal_empresas.idpersonal,
        personal_empresas.nombre_personal,
        personal_empresas.papellido_paterno,
        personal_empresas.papellido_materno,
        personal_empresas.correo,
        personal_empresas.sexo,
        personal_empresas.cargo_empresa,
        personal_empresas.telefono,
        personal_empresas.idempresa,
        empresas.idempresa,
        empresas.nombre_empresa
    FROM personal_empresas
    INNER JOIN empresas ON personal_empresas.idempresa = empresas.idempresa order by personal_empresas.nombre_personal ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarPersonal($id);
            break;
			case 'agregar':
            agregarPersonal($_POST);
            break;
			case 'editar':
            actualizarPersonal($id,$_POST);
            break;
			case 'obtenerPersonal':
            obtenerPersonal($id);
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


function obtenerPersonal($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del tutor
        $stmtAlumno = $pdo->prepare("SELECT 
            personal_empresas.idpersonal,
            personal_empresas.nombre_personal,
            personal_empresas.papellido_paterno,
            personal_empresas.papellido_materno,
            personal_empresas.correo,
            personal_empresas.sexo,
            personal_empresas.cargo_empresa,
            personal_empresas.telefono,
            personal_empresas.idempresa,
            empresas.idempresa AS empresa_id,
            empresas.nombre_empresa
        FROM personal_empresas  
        INNER JOIN empresas 
        ON personal_empresas.idempresa = empresas.idempresa WHERE idpersonal = :id");
        $stmtAlumno->execute([':id' => $id]);
        $alumno = $stmtAlumno->fetch();

// Obtener todas las carreras
        $stmtEmpresas = $pdo->prepare("SELECT * FROM empresas");
        $stmtEmpresas->execute();
        $empresas = $stmtEmpresas->fetchAll();

        if ($alumno) {
            echo json_encode([
                'success' => true, 
                'alumno' => $alumno, 
                'empresas' => $empresas
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Personal no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}


function actualizarPersonal($id, $data) {
    $pdo = DBC::get();
    
	$data['nombre_personal'] = mb_strtoupper($data['nombre_personal'], 'UTF-8');
    $data['papellido_paterno'] = mb_strtoupper($data['papellido_paterno'], 'UTF-8');
    $data['papellido_materno'] = mb_strtoupper($data['papellido_materno'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['cargo_empresa'] = mb_strtoupper($data['cargo_empresa'], 'UTF-8');

    try {
        // Actualizar los datos del tutor académico en la base de datos
        $stmt = $pdo->prepare("UPDATE personal_empresas SET 
            nombre_personal = :nombre_personal, 
            papellido_paterno = :papellido_paterno, 
            papellido_materno = :papellido_materno, 
            correo = :correo,
            sexo = :sexo,
            cargo_empresa = :cargo_empresa, 
            telefono = :telefono,
            idempresa = :idempresa,
            idpersonal = :idpersonal

        WHERE idpersonal = :idpersonal");

        $stmt->execute([
            ':idpersonal' => $data['id_personal'],
            ':nombre_personal' => $data['nombre_personal'],
            ':papellido_paterno' => $data['papellido_paterno'],
            ':papellido_materno' => $data['papellido_materno'],
            ':correo' => $data['correo'],
            ':sexo' => $data['sexo'],
            ':telefono' => $data['telefono'],
            ':cargo_empresa' => $data['cargo_empresa'],
            ':idempresa' => $data['idempresa']
        ]);

        echo json_encode(['success' => true, 'message' => 'Docente actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}



// Función para eliminar un alumno
function eliminarPersonal($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID del personal no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM personal_empresas WHERE idpersonal = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El Personal no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM personal_empresas  WHERE idpersonal = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Personal eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar al Personal: ' . $e->getMessage()]);
    }
}




function agregarPersonal($data) {
    $pdo = DBC::get();
	
    $data['nombre_personal'] = mb_strtoupper($data['nombre_personal'], 'UTF-8');
    $data['papellido_paterno'] = mb_strtoupper($data['papellido_paterno'], 'UTF-8');
    $data['papellido_materno'] = mb_strtoupper($data['papellido_materno'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['cargo_empresa'] = mb_strtoupper($data['cargo_empresa'], 'UTF-8');

    try {

        // Verificar si ya existe un alumno con el mismo correo
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM personal_empresas WHERE correo = :correo");
        $stmt->execute([':correo' => $data['correo']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe alguien del personal con el mismo correo.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO personal_empresas (nombre_personal, papellido_paterno, papellido_materno, sexo, telefono, correo, cargo_empresa, idempresa)
                               VALUES (:nombre_personal, :papellido_paterno, :papellido_materno, :sexo, :telefono, :correo, :cargo_empresa, :idempresa)");
        $stmt->execute([
            ':nombre_personal' => $data['nombre_personal'],
            ':papellido_paterno' => $data['papellido_paterno'],
            ':papellido_materno' => $data['papellido_materno'],
            ':correo' => $data['correo'],
            ':sexo' => $data['sexo'],
            ':telefono' => $data['telefono'],
            ':cargo_empresa' => $data['cargo_empresa'],
            ':idempresa' => $data['idempresa']
        ]);

        echo json_encode(['success' => true, 'message' => 'Personal agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar al docente: ' . $e->getMessage()]);
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
            echo json_encode(['success' => true, 'message' => 'El Personal ya tiene una cuenta de Usuario. Para gestionarla deberá hacerlo directamente desde el Catálogo de Docentes.']);
        } else {
            // Alumno no tiene cuenta
            echo json_encode(['success' => false, 'message' => 'El Personal no tiene una cuenta de Usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar: ' . $e->getMessage()]);
    }
}




?>