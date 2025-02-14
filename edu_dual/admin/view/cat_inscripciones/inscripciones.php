<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarInscripcion() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        inscripciones.idinscripcion,
        inscripciones.fecha_inicio,
        inscripciones.fecha_fin,   
        inscripciones.estatus, 
        alumnos.idalumno,
        alumnos.nombre,
        alumnos.apellidop,
        alumnos.apellidom,
        empresas.idempresa, 
        empresas.nombre_empresa,
        personal_empresas.idpersonal,
        personal_empresas.nombre_personal,
        personal_empresas.papellido_paterno,
        personal_empresas.papellido_materno,
        tutores_academicos.idtutor_academico,
        tutores_academicos.nombre_tutor,
        tutores_academicos.apellido_paterno,
        tutores_academicos.apellido_materno,
        semestres.idSemestre,
        semestres.semestre

       
    FROM inscripciones
    INNER JOIN alumnos ON inscripciones.idalumno = alumnos.idalumno 
    INNER JOIN empresas ON inscripciones.idempresa = empresas.idempresa
    INNER JOIN personal_empresas ON inscripciones.idpersonal = personal_empresas.idpersonal
    INNER JOIN tutores_academicos ON inscripciones.idtutor_academico = tutores_academicos.idtutor_academico
    INNER JOIN semestres ON inscripciones.idSemestre = semestres.idSemestre   
    ");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarInscripcion($id);
            break;
			case 'agregar':
            agregarInscripcion($_POST);
            break;
			case 'editar':
            actualizarInscripcion($id,$_POST);
            break;
			case 'obtenerInscripcion':
            obtenerInscripcion($id);
            break;
			
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerInscripcion($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtInscripcion = $pdo->prepare("SELECT 
            inscripciones.idinscripcion,
            inscripciones.fecha_inicio,
            inscripciones.fecha_fin,   
            inscripciones.estatus, 
            alumnos.idalumno,
            alumnos.nombre,
            alumnos.apellidop,
            alumnos.apellidom,
            empresas.idempresa, 
            empresas.nombre_empresa,
            personal_empresas.idpersonal,
            personal_empresas.nombre_personal,
            personal_empresas.papellido_paterno,
            personal_empresas.papellido_materno,
            tutores_academicos.idtutor_academico,
            tutores_academicos.nombre_tutor,
            tutores_academicos.apellido_paterno,
            tutores_academicos.apellido_materno,
            semestres.idSemestre,
            semestres.semestre
        FROM inscripciones
        INNER JOIN alumnos ON inscripciones.idalumno = alumnos.idalumno 
        INNER JOIN empresas ON inscripciones.idempresa = empresas.idempresa
        INNER JOIN personal_empresas ON inscripciones.idpersonal = personal_empresas.idpersonal
        INNER JOIN tutores_academicos ON inscripciones.idtutor_academico = tutores_academicos.idtutor_academico
        INNER JOIN semestres ON inscripciones.idSemestre = semestres.idSemestre   
        WHERE idinscripcion = :id");

        $stmtInscripcion->execute(['id' => $id]);
        $inscripcion = $stmtInscripcion->fetch();

        // Obtener todas los alumnos
        $stmtAlumnos = $pdo->prepare("SELECT * FROM alumnos");
        $stmtAlumnos->execute();
        $alumnos = $stmtAlumnos->fetchAll();

        // Obtener todas las empresas
        $stmtEmpresas = $pdo->prepare("SELECT * FROM empresas");
        $stmtEmpresas->execute();
        $empresas = $stmtEmpresas->fetchAll();

        // Obtener todo el personal de empresa
        $stmtPersonales = $pdo->prepare("SELECT * FROM personal_empresas");
        $stmtPersonales->execute();
        $personales = $stmtPersonales->fetchAll();

        // Obtener todo el tutor academico
        $stmtTutores = $pdo->prepare("SELECT * FROM tutores_academicos");
        $stmtTutores->execute();
        $tutores = $stmtTutores->fetchAll();

        // Obtener todas los semestres
        $stmtSemestres = $pdo->prepare("SELECT * FROM semestres");
        $stmtSemestres->execute();
        $semestres = $stmtSemestres->fetchAll();

        if ($inscripcion) {
            echo json_encode([
                'success' => true, 
                'inscripcion' => $inscripcion, 
                'alumnos' => $alumnos,
                'empresas' => $empresas, 
                'personales' => $personales,
                'tutores' => $tutores,
                'semestres' => $semestres
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Alumno no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarInscripcion($id, $data) {
    $pdo = DBC::get();

    // Convertir los datos a mayúsculas si es necesario
    $data['fecha_inicio'] = mb_strtoupper($data['fecha_inicio'], 'UTF-8');
    $data['fecha_fin'] = mb_strtoupper($data['fecha_fin'], 'UTF-8');
    $data['estatus'] = mb_strtoupper($data['estatus'], 'UTF-8');
    try {
        // Preparar la consulta
        $stmt = $pdo->prepare("UPDATE inscripciones SET 
            idalumno = :idalumno, 
            idempresa = :idempresa, 
            idpersonal = :idpersonal,
            idtutor_academico = :idtutor_academico,
            idSemestre = :idSemestre,
            fecha_inicio = :fecha_inicio, 
            fecha_fin = :fecha_fin, 
            estatus = :estatus
        WHERE idinscripcion = :idinscripcion");

        // Ejecutar la consulta con los valores
        $stmt->execute([
            ':idinscripcion' => $data['id_inscripcion'],
            ':idalumno' => $data['idalumno'],
            ':idempresa' => $data['idempresa'],
            ':idpersonal' => $data['idpersonal'],
            ':idtutor_academico' => $data['idtutor_academico'],
            ':idSemestre' => $data['idSemestre'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            ':estatus' => $data['estatus']
        ]);

        echo json_encode(['success' => true, 'message' => 'Alumno actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}




// Función para eliminar un alumno
function eliminarInscripcion($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de alumno no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el alumno existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscripciones WHERE idinscripcion = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'No existe ningun registro']);
            return;
        }

        // Eliminar el alumno
        $stmt = $pdo->prepare("DELETE FROM inscripciones WHERE idinscripcion = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Alumno eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el alumno: ' . $e->getMessage()]);
    }
}




function agregarInscripcion($data) {
    $pdo = DBC::get();
	$data['fecha_inicio'] = mb_strtoupper($data['fecha_inicio'], 'UTF-8');
    $data['fecha_fin'] = mb_strtoupper($data['fecha_fin'], 'UTF-8');
    $data['estatus'] = mb_strtoupper($data['estatus'], 'UTF-8');
   
    try {
       

        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO inscripciones (fecha_inicio, fecha_fin, estatus, idalumno, idempresa, idpersonal, idtutor_academico, idSemestre) 
                               VALUES (:fecha_inicio, :fecha_fin, :estatus, :idalumno, :idempresa, :idpersonal, :idtutor_academico, :idSemestre)");
        $stmt->execute([
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'],
            ':estatus' => $data['estatus'],
            ':idalumno' => $data['idalumno'],
            ':idempresa' => $data['idempresa'],
            ':idpersonal' => $data['idpersonal'],
            ':idtutor_academico' => $data['idtutor_academico'],
            ':idSemestre' => $data['idSemestre']
           
        ]);

        echo json_encode(['success' => true, 'message' => 'Alumno agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el alumno: ' . $e->getMessage()]);
    }
}



?>