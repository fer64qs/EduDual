<?php
require_once('DBC.php');

header('Content-Type: application/json');

// Inicializa un array para almacenar los mensajes
$responseMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos enviados por POST
    $idinscripcion = $_POST['idinscripcion'];
    $no_semana = $_POST['no_semana'];
    $fecha1 = $_POST['fecha1'];
    $descripcion1 = $_POST['descripcion1'] ?? '';
    $fecha2 = $_POST['fecha2'];
    $descripcion2 = $_POST['descripcion2'] ?? '';
    $fecha3 = $_POST['fecha3'];
    $descripcion3 = $_POST['descripcion3'] ?? '';
    $fecha4 = $_POST['fecha4'];
    $descripcion4 = $_POST['descripcion4'] ?? '';
    $fecha5 = $_POST['fecha5'];
    $descripcion5 = $_POST['descripcion5'] ?? '';
    $vobo_empresa = $_POST['vobo_empresa'] ?? 'NO AUTORIZADO'; // Valor por defecto
    $observaciones_empresa = $_POST['observaciones_empresa'] ?? '';
    $indicador_empresa = $_POST['indicador_empresa'] ?? 'NO DEFINIDO'; // Valor por defecto
    $vobo_tutordual = $_POST['vobo_tutordual'] ?? 'NO AUTORIZADO'; // Valor por defecto
    $observaciones_tutor = $_POST['observaciones_tutor'] ?? '';
    $indicador_tutor = $_POST['indicador_tutor'] ?? 'NO DEFINIDO'; // Valor por defecto
    $dias_trabajados = $_POST['dias_trabajados'] ?? 0; // Valor por defecto
	$puesto = $_POST['puesto'] ?? 'NO DEFINIDO'; // Valor por defecto
	$observaciones_alumno = $_POST['observaciones_alumno'] ?? '';
	$estatus_semana = $_POST['estatus_semana'] ?? 'PENDIENTE';

    // Consulta para insertar los datos
    $query = "
        INSERT INTO bitacoras 
        (idinscripcion, no_semana, fecha1, descripcion1, fecha2, descripcion2, 
        fecha3, descripcion3, fecha4, descripcion4, fecha5, descripcion5, 
        vobo_empresa, observaciones_empresa, indicador_empresa, vobo_tutordual, 
        observaciones_tutor, indicador_tutor, dias_trabajados,puesto,observaciones_alumno,estatus_semana) 
        VALUES 
        (:idinscripcion, :no_semana, :fecha1, :descripcion1, :fecha2, :descripcion2, 
        :fecha3, :descripcion3, :fecha4, :descripcion4, :fecha5, :descripcion5, 
        :vobo_empresa, :observaciones_empresa, :indicador_empresa, :vobo_tutordual, 
        :observaciones_tutor, :indicador_tutor, :dias_trabajados, :puesto, :observaciones_alumno, :estatus_semana)
    ";

    try {
        $stmt = DBC::get()->prepare($query);
        $stmt->bindValue(':idinscripcion', $idinscripcion, PDO::PARAM_INT);
        $stmt->bindValue(':no_semana', $no_semana, PDO::PARAM_INT);
        $stmt->bindValue(':fecha1', $fecha1);
        $stmt->bindValue(':descripcion1', $descripcion1);
        $stmt->bindValue(':fecha2', $fecha2);
        $stmt->bindValue(':descripcion2', $descripcion2);
        $stmt->bindValue(':fecha3', $fecha3);
        $stmt->bindValue(':descripcion3', $descripcion3);
        $stmt->bindValue(':fecha4', $fecha4);
        $stmt->bindValue(':descripcion4', $descripcion4);
        $stmt->bindValue(':fecha5', $fecha5);
        $stmt->bindValue(':descripcion5', $descripcion5);
        $stmt->bindValue(':vobo_empresa', $vobo_empresa);
        $stmt->bindValue(':observaciones_empresa', $observaciones_empresa);
        $stmt->bindValue(':indicador_empresa', $indicador_empresa);
        $stmt->bindValue(':vobo_tutordual', $vobo_tutordual);
        $stmt->bindValue(':observaciones_tutor', $observaciones_tutor);
        $stmt->bindValue(':indicador_tutor', $indicador_tutor);
        $stmt->bindValue(':dias_trabajados', $dias_trabajados, PDO::PARAM_INT);
		$stmt->bindValue(':puesto', $puesto);
		$stmt->bindValue(':observaciones_alumno', $observaciones_alumno);
		$stmt->bindValue(':estatus_semana', $estatus_semana);

        if ($stmt->execute()) {
            $responseMessages[] = "Bitácora de la semana $no_semana insertada correctamente.";
        } else {
            $responseMessages[] = "Error al insertar la bitácora de la semana $no_semana.";
        }
    } catch (Exception $e) {
        $responseMessages[] = "Error: " . $e->getMessage();
    }
} else {
    $responseMessages[] = "Solicitud no válida.";
}

// Enviar la respuesta como JSON
echo json_encode(['messages' => $responseMessages]);
?>
