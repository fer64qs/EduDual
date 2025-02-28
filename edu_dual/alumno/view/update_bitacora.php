<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/alumno/view/DBC.php'); // Conexión a la base de datos


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idbitacora = $_POST['idbitacora'];
    $puesto = $_POST['puesto'];
    $descripcion1 = $_POST['descripcion1'];
    $descripcion2 = $_POST['descripcion2'];
    $descripcion3 = $_POST['descripcion3'];
    $descripcion4 = $_POST['descripcion4'];
    $descripcion5 = $_POST['descripcion5'];
    $observaciones_alumno = $_POST['observaciones_alumno'];
    $dias_trabajados = $_POST['dias_trabajados'];

    // Preparar la consulta SQL para actualizar la tabla
    $sql = "UPDATE bitacoras SET 
            puesto = ?, 
            descripcion1 = ?, 
            descripcion2 = ?, 
            descripcion3 = ?, 
            descripcion4 = ?, 
            descripcion5 = ?, 
            observaciones_alumno = ?, 
            dias_trabajados = ? 
            WHERE idbitacora = ?";

    // Ejecutar la consulta utilizando un prepared statement con PDO
    $stmt = DBC::get()->prepare($sql);
    $stmt->bindParam(1, $puesto, PDO::PARAM_STR);
    $stmt->bindParam(2, $descripcion1, PDO::PARAM_STR);
    $stmt->bindParam(3, $descripcion2, PDO::PARAM_STR);
    $stmt->bindParam(4, $descripcion3, PDO::PARAM_STR);
    $stmt->bindParam(5, $descripcion4, PDO::PARAM_STR);
    $stmt->bindParam(6, $descripcion5, PDO::PARAM_STR);
    $stmt->bindParam(7, $observaciones_alumno, PDO::PARAM_STR);
    $stmt->bindParam(8, $dias_trabajados, PDO::PARAM_INT);
    $stmt->bindParam(9, $idbitacora, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente";
    } else {
        echo "Error al actualizar datos: " . $stmt->errorInfo()[2];
    }
}
?>
