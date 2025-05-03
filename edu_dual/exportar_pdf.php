<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php');
$pdo = DBC::get(); 


$filtros = isset($_GET['filtros']) ? json_decode($_GET['filtros'], true) : [];

$where = [];
$params = [];
$order = '';

// Filtro del estatus
if (!empty($filtros['estatus']) && $filtros['estatus'] !== 'TODOS') {
    $where[] = "inscripciones.estatus = :estatus";
    $params[':estatus'] = $filtros['estatus'];
}

// Filtro del ciclo escolar 
if (!empty($filtros['ciclo_escolar'])) {
    $where[] = "semestres.semestre = :semestre";
    $params[':semestre'] = $filtros['ciclo_escolar'];
}

// Filtro de la búsqueda por nombre o empresa
if (!empty($filtros['busqueda'])) {
    $where[] = "(CONCAT(alumnos.nombre, ' ', alumnos.apellidop, ' ', alumnos.apellidom) LIKE :busqueda 
                 OR empresas.nombre_empresa LIKE :busqueda)";
    $params[':busqueda'] = '%' . $filtros['busqueda'] . '%';
}

// Filtro del orden
if (!empty($filtros['orden'])) {
    $orden = strtoupper($filtros['orden']) === 'DESC' ? 'DESC' : 'ASC';
    $order = "ORDER BY alumnos.nombre $orden";
}


$sql = "SELECT 
            alumnos.nombre, alumnos.apellidop, alumnos.apellidom,
            empresas.nombre_empresa,
            semestres.semestre,
            inscripciones.estatus
        FROM inscripciones
        INNER JOIN alumnos ON inscripciones.idalumno = alumnos.idalumno
        INNER JOIN empresas ON inscripciones.idempresa = empresas.idempresa
        INNER JOIN semestres ON inscripciones.idSemestre = semestres.idSemestre";

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " $order";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

// Generar HTML para el PDF
$html = '
  <h2 style="text-align: center;">Reporte de Inscripciones</h2>
  <table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead style="background-color: #f2f2f2;">
      <tr>
        <th>Nombre del Alumno</th>
        <th>Empresa</th>
        <th>Ciclo Escolar</th>
        <th>Estatus</th>
      </tr>
    </thead>
    <tbody>';

foreach ($result as $row) {
    $alumno = htmlspecialchars($row['nombre'] . ' ' . $row['apellidop'] . ' ' . $row['apellidom']);
    $empresa = htmlspecialchars($row['nombre_empresa']);
    $semestre = htmlspecialchars($row['semestre']);
    $estatus = htmlspecialchars($row['estatus']);

    $html .= "<tr>
        <td>$alumno</td>
        <td>$empresa</td>
        <td>$semestre</td>
        <td>$estatus</td>
      </tr>";
}

$html .= '</tbody></table>';

// Configurar y generar PDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_inscripciones.pdf", ["Attachment" => false]);
exit;
?>
