<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');

// Función para cargar alumnos con sus carreras
function cargarDocentes() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT docentes.iddocente,
    docentes.apellido_paterno,
    docentes.apellido_materno,
    docentes.nombre_docente,
    docentes.sexo,
    docentes.rfc,
    docentes.num_celular,
    docentes.email,
    docentes.grado_estudios,
    docentes.titulo from docentes ORDER BY docentes.apellido_paterno ASC");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarDocente($id);
            break;
			case 'agregar':
            agregarDocente($_POST);
            break;
			case 'editar':
            actualizarDocente($id,$_POST);
            break;
			case 'obtenerDocente':
            obtenerDocente($id);
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


function obtenerDocente($id) {
    $pdo = DBC::get();
	$pdo->exec("SET NAMES 'utf8mb4'"); /*ESTO PASA EN UTF8 LOS CARACTERES*/
    try {
        // Obtener los datos del tutor
        $stmtAlumno = $pdo->prepare("SELECT docentes.iddocente,
            docentes.apellido_paterno,
            docentes.apellido_materno,
            docentes.nombre_docente,
            docentes.rfc,
            docentes.sexo,
            docentes.num_celular,
            docentes.email,
            docentes.grado_estudios,
            docentes.titulo 
            FROM docentes  
            WHERE docentes.iddocente = :id");
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


function actualizarDocente($id, $data) {
    $pdo = DBC::get();
    
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['rfc'] = mb_strtoupper($data['rfc'], 'UTF-8');
    $data['estudios'] = mb_strtoupper($data['estudios'], 'UTF-8');
    $data['titulo'] = mb_strtoupper($data['titulo'], 'UTF-8');

    try {
        // Actualizar los datos del tutor académico en la base de datos
        $stmt = $pdo->prepare("UPDATE docentes SET 
            nombre_docente = :nombre_docente, 
            apellido_paterno = :apellido_paterno, 
            apellido_materno = :apellido_materno, 
            email = :email,
            rfc = :rfc,
            sexo = :sexo,
            titulo = :titulo, 
            num_celular = :num_celular, 
            grado_estudios = :grado_estudios 
        WHERE iddocente = :id");

        $stmt->execute([
            ':nombre_docente' => $data['nombre'],
            ':apellido_paterno' => $data['apellidop'],
            ':apellido_materno' => $data['apellidom'],
            ':email' => $data['correo'],
            ':rfc' => $data['rfc'],
            ':sexo' => $data['sexo'],
            ':num_celular' => $data['celular'],
            ':grado_estudios' => $data['estudios'],
            ':titulo' => $data['titulo'],
            ':id' => $id
        ]);

        echo json_encode(['success' => true, 'message' => 'Docente actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}



// Función para eliminar un alumno
function eliminarDocente($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de Docente no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM docentes WHERE iddocente = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'El Docente no existe']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM  docentes  WHERE iddocente = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Docente eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar al Docente: ' . $e->getMessage()]);
    }
}




function agregarDocente($data) {
    $pdo = DBC::get();
	
	$data['nombre'] = mb_strtoupper($data['nombre'], 'UTF-8');
    $data['apellidop'] = mb_strtoupper($data['apellidop'], 'UTF-8');
    $data['apellidom'] = mb_strtoupper($data['apellidom'], 'UTF-8');
    $data['sexo'] = mb_strtoupper($data['sexo'], 'UTF-8');
    $data['rfc'] = mb_strtoupper($data['rfc'], 'UTF-8');
    $data['correo'] = strtolower(trim($data['correo'])); // Opcional: correos en minúsculas
    $data['estudios'] = mb_strtoupper($data['estudios'], 'UTF-8');
	$data['titulo'] = mb_strtoupper($data['titulo'], 'UTF-8');


    try {
        // Verificar si ya existe un alumno con el mismo CURP
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM docentes WHERE rfc = :rfc");
        $stmt->execute([':rfc' => $data['rfc']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un Docente con el mismo rfc.']);
            return;
        }

        // Verificar si ya existe un alumno con el mismo correo
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM docentes WHERE email = :correo");
        $stmt->execute([':correo' => $data['correo']]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya existe un Docente con el mismo correo.']);
            return;
        }

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO docentes (apellido_paterno, apellido_materno, nombre_docente, sexo, rfc, num_celular, email, grado_estudios, titulo) 
                               VALUES ( :apellidop, :apellidom, :nombre, :sexo, :rfc, :celular, :correo, :estudios, :titulo)");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellidop' => $data['apellidop'],
            ':apellidom' => $data['apellidom'],
            ':correo' => $data['correo'],
            ':rfc' => $data['rfc'],
            ':sexo' => $data['sexo'],
            ':titulo' => $data['titulo'],
            ':celular' => $data['celular'],
            ':estudios' => $data['estudios']
        ]);

        echo json_encode(['success' => true, 'message' => 'Docente agregado exitosamente.']);
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
            echo json_encode(['success' => true, 'message' => 'El Docente ya tiene una cuenta de Usuario. Para gestionarla deberá hacerlo directamente desde el Catálogo de Docentes.']);
        } else {
            // Alumno no tiene cuenta
            echo json_encode(['success' => false, 'message' => 'El Docente no tiene una cuenta de Usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar: ' . $e->getMessage()]);
    }
}




?>