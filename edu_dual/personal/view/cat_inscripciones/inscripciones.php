<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la BD
header('Content-Type: text/html; charset=utf-8');

// Verificar si el usuario está autenticado
if (!isset($_SESSION["userId"])) {
    if (isAjax()) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit();
    } else {
        header("Location: /edu_dual/login.php");
        exit();
    }
}

$idusuario = $_SESSION["userId"]; // ID del usuario autenticado

function cargarInscripcion($idusuario) {
    $pdo = DBC::get();
    $stmt = $pdo->prepare("
        SELECT 
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
        INNER JOIN personal_empresas ON inscripciones.idpersonal = personal_empresas.idpersonal
        INNER JOIN empresas ON inscripciones.idempresa = empresas.idempresa
        INNER JOIN tutores_academicos ON inscripciones.idtutor_academico = tutores_academicos.idtutor_academico
        INNER JOIN semestres ON inscripciones.idSemestre = semestres.idSemestre
        INNER JOIN usuarios ON usuarios.email = personal_empresas.correo 
        WHERE usuarios.idusuario = :idusuario
    ");
    $stmt->execute(['idusuario' => $idusuario]);
    return $stmt->fetchAll();
}

function isAjax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Obtener los datos de la inscripción del instructor dual autenticado
$inscripcion = cargarInscripcion($idusuario);

if (isAjax()) {
    if (!empty($inscripcion)) {
        echo json_encode(['success' => true, 'inscripcion' => $inscripcion]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontraron inscripciones para este instructor']);
    }
    exit(); // Salimos para evitar que se cargue el HTML
}
?>
