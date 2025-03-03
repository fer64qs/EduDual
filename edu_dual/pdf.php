<?php
require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Obtener los datos de la URL
$idinscripcion = $_GET['idinscripcion'];
$idbitacora = $_GET['idbitacora'];
$nombrecompleto_alumno = urldecode($_GET['nombrecompleto_alumno']);
$nombre_empresa = urldecode($_GET['nombre_empresa']);
$nombreasesordual_docente = urldecode($_GET['nombreasesordual_docente']);
$responsable_empresa = urldecode($_GET['responsable_empresa']);
$semana = $_GET['semana'];
$dias_trabajados = urldecode($_GET['dias_trabajados']);
$puesto = urldecode($_GET['puesto']);
$fecha1 = urldecode($_GET['fecha1']);
$descripcion1 = urldecode($_GET['descripcion1']);
$fecha2 = urldecode($_GET['fecha2']);
$descripcion2 = urldecode($_GET['descripcion2']);
$fecha3 = urldecode($_GET['fecha3']);
$descripcion3 = urldecode($_GET['descripcion3']);
$fecha4 = urldecode($_GET['fecha4']);
$descripcion4 = urldecode($_GET['descripcion4']);
$fecha5 = urldecode($_GET['fecha5']);
$descripcion5 = urldecode($_GET['descripcion5']);
$observaciones_alumno = urldecode($_GET['observaciones_alumno']);
$observaciones_tutor = urldecode($_GET['observaciones_tutor']);
$observaciones_empresa = urldecode($_GET['observaciones_empresa']);

// Crear el contenido HTML para el PDF
$html = '
<html>
<head>
    <style>
        .tg {border-collapse:collapse;border-spacing:0;}
        .tg td {border:1px solid black;font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;word-break:normal;}
        .tg th {border:1px solid black;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;word-break:normal;}
        .tg .tg-ddj0 {background-color:#591a1a;color:#ffffff;font-weight:bold;text-align:center;}
        .tg .tg-aw21 {font-weight:bold;text-align:center;}
        .tg .tg-h25s {font-weight:bold;text-align:center;}
        .tg .tg-u3qo {text-decoration:underline;}
        .tg .tg-va5j {background-color:#591a1a;color:#ffffff;text-align:left;}
        .tg .tg-ynxx {background-color:#591a1a;color:#ffffff;text-align:center;}
        .tg .tg-0pky {text-align:left;}
        .tg .tg-c3ow {text-align:center;width:33.33%;}

    
        .comentarios {
            width: 100%; 
            height: 50px; 
            font-size: 14px;
            padding: 10px;
            border: 0px solid #ccc; 
        }

        .firmas {
            width: 100%;
            height: 150px;
            font-size: 16px; 
            text-align: center; 
            padding: 20px; 
        }
    </style>
</head>
<body>
    <table class="tg" style="table-layout: fixed; width: 90%;">
        <thead>
            <tr>
                <th class="tg-ddj0" colspan="3">SISTEMA DE EDUCACIÓN DUAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-aw21" colspan="3">REPORTE SEMANAL</td>
            </tr>
            <tr>
                <td class="tg-0pky"></td>
                <td class="tg-0pky"></td>
                <td class="tg-h25s">Reporte semanal No. ' . $semana . ' &nbsp;&nbsp;&nbsp; Días trabajados: ' . $dias_trabajados . '</td>
            </tr>
            <tr>
                <td class="tg-0pky"></td>
                <td class="tg-h25s"></td>
                <td class="tg-h25s">Puesto de aprendizaje: ' . $puesto . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">Nombre del Alumno:</td>
                <td class="tg-u3qo">' . $nombrecompleto_alumno . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">Empresa:</td>
                <td class="tg-u3qo">' . $nombre_empresa . '</td>
            </tr>
            <tr>
                <td class="tg-va5j">FECHA</td>
                <td class="tg-ynxx" colspan="2">ACTIVIDADES REALIZADAS</td>
            </tr>
            <!-- Aquí puedes agregar las filas para las actividades realizadas -->
            <tr>
                <td class="tg-0pky">' . $fecha1 . '</td>
                <td class="tg-0pky" colspan="2">' . $descripcion1 . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">' . $fecha2 . '</td>
                <td class="tg-0pky" colspan="2">' . $descripcion2 . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">' . $fecha3 . '</td>
                <td class="tg-0pky" colspan="2">' . $descripcion3 . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">' . $fecha4 . '</td>
                <td class="tg-0pky" colspan="2">' . $descripcion4 . '</td>
            </tr>
            <tr>
                <td class="tg-0pky">' . $fecha5 . '</td>
                <td class="tg-0pky" colspan="2">' . $descripcion5 . '</td>
            </tr>
            <tr>
                <td class="tg-ynxx" colspan="3">COMENTARIOS DEL ESTUDIANTE DUAL</td>
            </tr>
            <tr>
                <td class="tg-0pky" colspan="3">
                    <div class="comentarios">' . $observaciones_alumno . '</div>
                </td>
            </tr>
            <tr>
                <td class="tg-ynxx" colspan="3">OBSERVACIONES DEL TUTOR DUAL</td>
            </tr>
            <tr>
                <td class="tg-0pky" colspan="3">
                    <div class="comentarios">' . $observaciones_tutor . '</div>
                </td>
            </tr>
            <tr>
                <td class="tg-ynxx" colspan="3">OBSERVACIONES DEL PERSONAL DE LA EMPRESA</td>
            </tr>
            <tr>
                <td class="tg-0pky" colspan="3">
                    <div class="comentarios">' . $observaciones_empresa . '</div>
                </td>
            </tr>
            <tr>
                <td class="tg-c3ow firmas">_____________________________________<br>Nombre y firma del estudiante<br>' . $nombrecompleto_alumno . '</td>
                <td class="tg-c3ow firmas">_____________________________________<br>Nombre y firma del asesor<br>' . $nombreasesordual_docente . '</td>
                <td class="tg-c3ow firmas">_____________________________________<br>Nombre y firma del personal de la empresa<br>' . strtoupper($responsable_empresa). '</td>
            </tr>
        </tbody>
    </table>
</body>
</html>';

// Configurar dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream("reporte_semanal.pdf", array("Attachment" => false));
?>