<?php
require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar DomPDF para orientación horizontal
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true); // Habilitar el soporte para HTML5
$options->set('isPhpEnabled', true);         // Habilitar PHP en HTML

$dompdf = new Dompdf($options);

// Obtener parámetros
$nombreAlumno = isset($_GET['nombreAlumno']) ? urldecode($_GET['nombreAlumno']) : 'Nombre Alumno';
$nombreEmpresa = isset($_GET['nombreEmpresa']) ? urldecode($_GET['nombreEmpresa']) : 'Empresa';
$nombreAsesor = isset($_GET['nombreAsesor']) ? urldecode($_GET['nombreAsesor']) : 'Asesor Dual';
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
        .container { width: 95%; padding: 20px; border: 5px solid #000; }
        h1 { font-size: 28px; }
        h2 { font-size: 24px; }
        .certificado { font-size: 20px; margin-top: 20px; }
        .firma { margin-top: 50px; font-size: 18px; display: flex; justify-content: space-around; }
        .firma div { text-align: center; width: 20%; }
        .subrayado { border-top: 1px solid black; width: 80%; margin: 10px auto; }
    </style>
</head>
<body>

    <div class='container'>
        
        <h1>Certificado de Terminación de Educación Dual</h1>
        <br>
        <p class='certificado'>Se otorga el presente certificado a:</p>
        <h2>$nombreAlumno</h2>
        <p></p>
        <p class='certificado'>
            Por culminar su estancia en la empresa: $nombreEmpresa bajo la modalidad dual, obteniendo una calificación aprobatoria y el
            certificado de terminación tipo Honor otorgado por el Centro de Bachillerato Tecnológico Industrial y de Servicios No. 193
            “José María Morelos y Pavón”.
        </p>
        <br>
        <p class='certificado'>Bajo la tutoría del asesor académico:</p>
        <h2>$nombreAsesor</h2>
        <p class='certificado'>Y la supervisión por parte del personal de la empresa:</p>
        <h2>$responsableEmpresa</h2>
        <br><br>
    </div>
</body>
</html>
";

// Cargar HTML en DomPDF y generar PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // Formato horizontal
$dompdf->render();

// Agregar imagen al encabezado y pie de página
$canvas = $dompdf->getCanvas();
$canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
    $imagePath = 'alumno/view/img/dgeti.jpg';
    $imagePath2 = 'alumno/view/img/cbtis_logo.jpg';

    // IMG1
    $canvas->image($imagePath, 50, 50, 100, 100);
    // IMG2
    $canvas->image($imagePath2, 680, 50, 100, 100);

});

// Descargar o mostrar el PDF
$dompdf->stream("Certificado_$nombreAlumno.pdf", ["Attachment" => false]);
?>