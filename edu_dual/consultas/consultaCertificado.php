<?php
// consultas/consultaCertificado.php

// Obtener parámetros
$nombreAlumno = isset($_GET['alumno']) ? urldecode($_GET['alumno']) : 'No especificado';
$nombreEmpresa = isset($_GET['empresa']) ? urldecode($_GET['empresa']) : 'No especificado';
$nombreAsesor = isset($_GET['asesor']) ? urldecode($_GET['asesor']) : 'No especificado';
$responsableEmpresa = isset($_GET['responsable']) ? urldecode($_GET['responsable']) : 'No especificado';
$numControl = isset($_GET['numControl']) ? urldecode($_GET['numControl']) : 'No especificado';
$curp = isset($_GET['curp']) ? urldecode($_GET['curp']) : 'No especificado';
$fecha_inicio = isset($_GET['fecha_inicio']) ? date('d/m/Y', strtotime($_GET['fecha_inicio'])) : 'No especificado';
$fecha_fin = isset($_GET['fecha_fin']) ? date('d/m/Y', strtotime($_GET['fecha_fin'])) : 'No especificado';
$fecha_consulta = date('d/m/Y H:i:s');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Certificado Dual</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }
        .certificado-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
        }
        .certificado-table th {
            background-color: #3498db;
            color: white;
            text-align: left;
            padding: 12px 15px;
            width: 30%;
        }
        .certificado-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        .certificado-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
    
            <h1>Certificado de Educación Dual</h1>
            <div class="subtitle">Centro de Bachillerato Tecnológico Industrial y de Servicios No. 193</div>
            <div class="subtitle">"José María Morelos y Pavón"</div>
        </div>

        <table class="certificado-table">
            <tr>
                <th>Nombre del Alumno:</th>
                <td><?= htmlspecialchars($nombreAlumno) ?></td>
            </tr>
            <tr>
                <th>Número de Control:</th>
                <td><?= htmlspecialchars($numControl) ?></td>
            </tr>
            <tr>
                <th>CURP:</th>
                <td><?= htmlspecialchars($curp) ?></td>
            </tr>
            <tr>
                <th>Empresa:</th>
                <td><?= htmlspecialchars($nombreEmpresa) ?></td>
            </tr>
            <tr>
                <th>Asesor Académico:</th>
                <td><?= htmlspecialchars($nombreAsesor) ?></td>
            </tr>
            <tr>
                <th>Responsable en Empresa:</th>
                <td><?= htmlspecialchars($responsableEmpresa) ?></td>
            </tr>
            <tr>
                <th>Periodo de realización:</th>
                <td>Del <?= htmlspecialchars($fecha_inicio) ?> al <?= htmlspecialchars($fecha_fin) ?></td>
            </tr>
            <tr>
                <th>Modalidad:</th>
                <td>Educación Dual</td>
            </tr>
            
        </table>

      
    </div>
</body>
</html>