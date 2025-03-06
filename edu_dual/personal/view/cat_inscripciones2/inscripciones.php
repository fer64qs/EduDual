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
?>