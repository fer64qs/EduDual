<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../class/DataSource.php";
require_once "../class/Carrera.php";

use Phppot\Carrera;

header('Content-Type: application/json');

$carrera = new Carrera();
$carreras = $carrera->getAllCarreras();

if ($carreras) {
    echo json_encode(["status" => "success", "carreras" => $carreras]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron cargar las carreras."]);
}
?>
