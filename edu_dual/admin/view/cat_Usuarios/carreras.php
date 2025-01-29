<?php
// Incluir archivo de la clase DBC
include_once($_SERVER['DOCUMENT_ROOT'].'/edu_dual/admin/view/DBC.php');

// Establecer el encabezado para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Obtener la instancia de la conexión a la base de datos
$db = DBC::get();

// Crear la consulta SQL para obtener las carreras
$sql = "SELECT idcarrera, nombre_carrera FROM carreras";

// Preparar y ejecutar la consulta
$stmt = $db->prepare($sql);
$stmt->execute();

// Obtener los resultados
$carreras = $stmt->fetchAll();

// Verificar si hay resultados
if (count($carreras) > 0) {
    // Devolver las carreras en formato JSON
    echo json_encode($carreras);
} else {
    // Si no hay carreras, devolver un array vacío
    echo json_encode([]);
}
?>
