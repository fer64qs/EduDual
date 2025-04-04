<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');

// Función para cargar alumnos con sus carreras
function cargarTutoresDual() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT tutores_academicos.idtutor_academico,
tutores_academicos.apellido_paterno,
tutores_academicos.apellido_materno,
tutores_academicos.nombre_tutor,
tutores_academicos.sexo,
tutores_academicos.num_celular,
tutores_academicos.email,
tutores_academicos.titulo_academico,
tutores_academicos.especialidad,
tutores_academicos.curp from tutores_academicos ORDER BY tutores_academicos.apellido_paterno ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarTutor($id);
            break;
			case 'agregar':
            agregarTutor($_POST);
            break;
			case 'editar':
            actualizarTutorAcademico($id,$_POST);
            break;
			case 'obtenerTutor':
            obtenerTutorDual($id);
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

/*
function obtenerTutorDual($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtAlumno = $pdo->prepare("SELECT tutores_academicos.idtutor_academico,
tutores_academicos.apellido_paterno,
tutores_academicos.apellido_materno,
tutores_academicos.nombre_tutor,
tutores_academicos.curp,
tutores_academicos.sexo,
tutores_academicos.num_celular,
tutores_academicos.email,
tutores_academicos.titulo_academico,
tutores_academicos.especialidad from tutores_academicos  
         WHERE tutores_academicos.idtutor_academico = :id");
        $stmtAlumno->execute([':id' => $id]);
        $alumno = $stmtAlumno->fetch();

        

        if ($alumno) {
			
            echo json_encode([
                'success' => true, 
                'alumno' => $alumno
            ]);
			
        } else {
            echo json_encode(['success' => false, 'message' => 'Tutor Dual no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}
*/
function obtenerTutorDual($id) {
    $pdo = DBC::get();
	$pdo->exec("SET NAMES 'utf8mb4'"); /*ESTO PASA EN UTF8 LOS CARACTERES*/
    try {
        // Obtener los datos del tutor
        $stmtAlumno = $pdo->prepare("SELECT tutores_academicos.idtutor_academico,
            tutores_academicos.apellido_paterno,
            tutores_academicos.apellido_materno,
            tutores_academicos.nombre_tutor,
            tutores_academicos.curp,
            tutores_academicos.sexo,
            tutores_academicos.num_celular,
            tutores_academicos.email,
            tutores_academicos.titulo_academico,
            tutores_academicos.especialidad 
            FROM tutores_academicos  
            WHERE tutores_academicos.idtutor_academico = :id");
        $stmtAlumno->execute([':id' => $id]);
        $alumno = $stmtAlumno->fetch(PDO::FETCH_ASSOC);

        if ($alumno) {
            // Construir manualmente el JSON
            $jsonResponse = '{';
            $jsonResponse .= '"success": true,';
            $jsonResponse .= '"alumno": {';
            foreach ($alumno as $key => $value) {
                $sanitizedValue = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $jsonResponse .= '"' . $key . '": "' . $sanitizedValue . '",';
            }
            $jsonResponse = rtrim($jsonResponse, ','); // Eliminar la última coma
            $jsonResponse .= '}';
            $jsonResponse .= '}';

            header('Content-Type: application/json; charset=utf-8');
            echo $jsonResponse;
        } else {
            echo json_encode(['success' => false, 'message' => 'Tutor Dual no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}


function actualizarTutorAcademico($id, $data) {
    $pdo = DBC::get();

    // Ajustar los datos a los formatos requeridos
	/*
    $data['nombre_tutor'] = mb_strtoupper($data['nombre_tutor'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['titulo'] = mb_strtoupper($data['titulo'], 'UTF-8');
    $data['especialidad'] = mb_strtoupper($data['especialidad'], 'UTF-8');
    $data['curp'] = mb_strtoupper($data['curp'], 'UTF-8');
	*/
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['titulo'] = mb_strtoupper($data['titulo'], 'UTF-8');
	$data['especialidad'] = mb_strtoupper($data['especialidad'], 'UTF-8');
	$data['curp'] = mb_strtoupper($data['curp'], 'UTF-8');

    try {
        $stmt = $pdo->prepare("UPDATE tutores_academicos SET 
            nombre_tutor = :nombre_tutor, 
            apellido_paterno = :apellido_paterno, 
            apellido_materno = :apellido_materno, 
            email = :email, 
            curp = :curp, 
            sexo = :sexo, 
            titulo_academico = :titulo_academico, 
            num_celular = :num_celular, 
            especialidad = :especialidad
        WHERE idtutor_academico = :id");

        $stmt->execute([
            ':nombre_tutor' => $data['nombre'],
            ':apellido_paterno' => $data['apellidop'],
            ':apellido_materno' => $data['apellidom'],
            ':email' => $data['correo'],
            ':curp' => $data['curp'],
            ':sexo' => $data['sexo'],
            ':titulo_academico' => $data['titulo'],
            ':num_celular' => $data['celular'],
            ':especialidad' => $data['especialidad'],
            ':id' => $id
        ]);

        echo json_encode(['success' => true, 'message' => 'Tutor académico actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}



// Función para eliminar un alumno
function eliminarTutor($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de Tut@r no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tutores_academicos WHERE idtutor_academico = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El Tut@r no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM  tutores_academicos  WHERE idtutor_academico = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Tut@r eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar al Tut@r: ' . $e->getMessage()]);
    }
}




function agregarTutor($data) {
    $pdo = DBC::get();
	
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['titulo'] = mb_strtoupper($data['titulo'], 'UTF-8');
	$data['especialidad'] = mb_strtoupper($data['especialidad'], 'UTF-8');
	$data['curp'] = mb_strtoupper($data['curp'], 'UTF-8');


    try {
        // Verificar si ya existe un alumno con el mismo CURP
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tutores_academicos WHERE curp = :curp");
        $stmt->execute([':curp' => $data['curp']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un Tut@r con la misma CURP.']);
            return;
        }

        // Verificar si ya existe un alumno con el mismo correo
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tutores_academicos WHERE email = :correo");
        $stmt->execute([':correo' => $data['correo']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un Tut@r con el mismo correo.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO tutores_academicos (apellido_paterno, apellido_materno, nombre_tutor, sexo, num_celular, email, titulo_academico, especialidad, curp) 
                               VALUES ( :apellidop, :apellidom, :nombre, :sexo, :celular, :correo, :titulo,  :especialidad, :curp)");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellidop' => $data['apellidop'],
            ':apellidom' => $data['apellidom'],
            ':correo' => $data['correo'],
            ':curp' => $data['curp'],
            ':sexo' => $data['sexo'],
            ':titulo' => $data['titulo'],
            ':celular' => $data['celular'],
            ':especialidad' => $data['especialidad']
        ]);

        echo json_encode(['success' => true, 'message' => 'Tut@r agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar al Tut@r: ' . $e->getMessage()]);
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
            echo json_encode(['success' => true, 'message' => 'El Tut@r ya tiene una cuenta de Usuario. Para gestionarla deberá hacerlo directamente desde el Catálogo de Tut@res Académicos.']);
        } else {
            // Alumno no tiene cuenta
            echo json_encode(['success' => false, 'message' => 'El Tut@r no tiene una cuenta de Usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar: ' . $e->getMessage()]);
    }
}




?>