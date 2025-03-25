<?php
require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar DomPDF para orientación vertical
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true); // Habilitar soporte para HTML5
$options->set('isPhpEnabled', true);         // Habilitar PHP en HTML
$options->set('isRemoteEnabled', true);      // Permitir acceso a imágenes remotas

$dompdf = new Dompdf($options);

// Rutas absolutas de las imágenes
$logoIzq = realpath(__DIR__ . '/alumno/view/img/dgeti.jpg');
$logoDer = realpath(__DIR__ . '/alumno/view/img/cbtis_logo.jpg');

// Obtener parámetros
$nombreAlumno = isset($_GET['nombreAlumno']) ? urldecode($_GET['nombreAlumno']) : 'Nombre Alumno';
$nombreEmpresa = isset($_GET['nombreEmpresa']) ? urldecode($_GET['nombreEmpresa']) : 'Empresa';
$nombreAsesor = isset($_GET['nombreAsesor']) ? urldecode($_GET['nombreAsesor']) : 'Asesor Dual';
$nombreDirector = isset($_GET['nombreDirector']) ? urldecode($_GET['nombreDirector']) : 'Director';
$responsableEmpresa = isset($_GET['responsableEmpresa']) ? urldecode($_GET['responsableEmpresa']) : 'Responsable Empresa';

// Plantilla del certificado
$html = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Certificado de Terminación de Educación Dual</title>
    <style>
    body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 0; }
    .container { width: 96%; padding: 10px; border: 5px solid #000; box-sizing: border-box; }
    h1 { font-size: 30px; }
    h2 { font-size: 18px; }
    .certificado { font-size: 20px; margin-top: 30px; }
    
    /* Estilo para las firmas al lado de la otra */
    .firmas-container { 
        margin-top: 60px; 
        width: 100%;
        display: block;
        overflow: hidden;
    }
    .firma { 
        display: inline-block;
        width: 28%; /* Ajusta el ancho para que las firmas no se amontonen */
        text-align: center;
        margin: 0 11px;
        font-size: 8px; /* Aquí se reduce el tamaño de la fuente de las firmas */
    }
    .subrayado { 
        border-top: 1px solid black;
        margin: 11px auto;
        width: 80%; /* Ajusta el ancho de la línea */
    }
</style>
</head>
<body>

    <div class='container'>
        
        <h1>Certificado de Terminación</h1>
        <h1>de Educación Dual</h1>
        <p class='certificado'>Se otorga el presente certificado a:</p>
        <h2>$nombreAlumno</h2>
        <p></p>
        <p class='certificado'>
            Por culminar su estancia en la empresa: $nombreEmpresa bajo la modalidad dual, obteniendo una calificación aprobatoria y el
            certificado de terminación tipo Honor otorgado por el Centro de Bachillerato Tecnológico Industrial y de Servicios No. 193
            “José María Morelos y Pavón”.
        </p>
        
        <p class='certificado'>Bajo la tutoría del asesor académico:</p>
        <h2>$nombreAsesor</h2>
        <p class='certificado'>Y la supervisión por parte del personal de la empresa:</p>
        <h2>$responsableEmpresa</h2>
        <br>

        <!-- Contenedor de firmas en fila horizontal (al lado de la otra) -->
        <div class='firmas-container'>
            <div class='firma'>
                <div class='subrayado'></div>
                <p>$nombreAlumno</p>
                <p>Alumno</p>
            </div>

            <div class='firma'>
                <div class='subrayado'></div>
                <p>$nombreAsesor</p>
                <p>Asesor Académico</p>
            </div>

            <div class='firma'>
                <div class='subrayado'></div>
                <p>$responsableEmpresa</p>
                <p>Responsable Empresa</p>
            </div>

            <div class='firma'>
                <div class='subrayado'></div>
                <p>$nombreDirector</p>
                <p>Director</p>
            </div>
        </div>

        <br><br><br><br><br><br><br><br><br><br>
    </div>
</body>
</html>
";

// Cargar HTML en DomPDF y generar PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Formato vertical
$dompdf->render();

// Agregar imágenes al encabezado
$canvas = $dompdf->getCanvas();

// Imagen izquierda (DGETI)
$canvas->image($logoIzq, 38, 40, 100, 100);
// Imagen derecha (CBTis)
$canvas->image($logoDer, 458, 40, 100, 100);

// Descargar o mostrar el PDF
$dompdf->stream("Certificado_$nombreAlumno.pdf", ["Attachment" => false]);
