<?php
// Incluir archivo de la clase DBC
include_once($_SERVER['DOCUMENT_ROOT'].'/edu_dual/admin/view/DBC.php');

// Establecer el encabezado para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Obtener la instancia de la conexión a la base de datos
$db = DBC::get();

// Crear la consulta SQL para obtener las carreras
$sql = "SELECT idpersonal, papellido_paterno, papellido_materno, nombre_personal FROM personal_empresas ";

// Preparar y ejecutar la consulta
$stmt = $db->prepare($sql);
$stmt->execute();

// Obtener los resultados
$personales = $stmt->fetchAll();

// Verificar si hay resultados
if (count($personales) > 0) {
    // Devolver las carreras en formato JSON
    echo json_encode($personales);
} else {
    // Si no hay carreras, devolver un array vacío
    echo json_encode([]);
}
?>
