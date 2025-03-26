<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Configuración de DomPDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Obtener parámetros
$nombreAlumno = isset($_GET['nombreAlumno']) ? urldecode($_GET['nombreAlumno']) : 'Nombre Alumno';
$nombreEmpresa = isset($_GET['nombreEmpresa']) ? urldecode($_GET['nombreEmpresa']) : 'Empresa';
$nombreAsesor = isset($_GET['nombreAsesor']) ? urldecode($_GET['nombreAsesor']) : 'Asesor Dual';
$nombreDirector = isset($_GET['nombreDirector']) ? urldecode($_GET['nombreDirector']) : 'Director';
$responsableEmpresa = isset($_GET['responsableEmpresa']) ? urldecode($_GET['responsableEmpresa']) : 'Responsable Empresa';
$numControl = isset($_GET['numControl']) ? urldecode($_GET['numControl']) : 'No Control';
$curp = isset($_GET['curp']) ? urldecode($_GET['curp']) : 'curp';
$fecha_inicio = isset($_GET['fecha_inicio']) ? urldecode($_GET['fecha_inicio']) : 'fecha de inicio';
$fecha_fin = isset($_GET['fecha_fin']) ? urldecode($_GET['fecha_fin']) : 'fecha de fin';

// Generar QR como imagen PNG (más compatible)
$qrOptions = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel' => QRCode::ECC_L,
    'scale' => 5,
    'imageBase64' => false // Generar como binario en lugar de base64

]);

$urlAlumno = "http://".$_SERVER['HTTP_HOST']."/edu_dual/consultas/consultaCertificado.php?" . http_build_query([
    'alumno' => $nombreAlumno,
    'empresa' => $nombreEmpresa,
    'asesor' => $nombreAsesor,
    'responsable' => $responsableEmpresa,
    'numControl' => $numControl,
    'curp' => $curp,
    'fecha_inicio' => $fecha_inicio,
    'fecha_fin' => $fecha_fin

    
]);

$qrCode = new QRCode($qrOptions);
$qrImage = $qrCode->render($urlAlumno);

// Guardar temporalmente la imagen QR
$tempFile = tempnam(sys_get_temp_dir(), 'qr_');
file_put_contents($tempFile, $qrImage);

// Leer la imagen como base64
$qrBase64 = base64_encode(file_get_contents($tempFile));

// Plantilla HTML con el QR correctamente integrado
$html = <<<HTML
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
        .firmas-container { 
            margin-top: 60px; 
            width: 100%;
            display: block;
            overflow: hidden;
        }
        .firma { 
            display: inline-block;
            width: 28%;
            text-align: center;
            margin: 0 11px;
            font-size: 8px;
        }
        .subrayado { 
            border-top: 1px solid black;
            margin: 11px auto;
            width: 80%;
        }
        .qr-container {
            margin: 20px auto;
            text-align: center;
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
            "José María Morelos y Pavón".
        </p>
        
        <p class='certificado'>Bajo la tutoría del asesor académico:</p>
        <h2>$nombreAsesor</h2>
        <p class='certificado'>Y la supervisión por parte del personal de la empresa:</p>
        <h2>$responsableEmpresa</h2>
        <br>

        <div class='firmas-container'>
            <div class='firma'>
                <div class='subrayado'></div>
                <p>$nombreAsesor</p>
                <p>Asesor Académico</p>
            </div>

            <div class='firma'>
                <div class='subrayado'></div>
                <p>$nombreDirector</p>
                <p>Director</p>
            </div>

            <div class='firma'>
                <div class='subrayado'></div>
                <p>$responsableEmpresa</p>
                <p>Responsable Empresa</p>
            </div>
        </div>

        <div class='qr-container'>
            <img src='data:image/png;base64,$qrBase64' width='120' height='120' alt='Código QR' />
        </div>

        <br><br><br><br><br><br>
    </div>
</body>
</html>
HTML;

// Limpiar archivo temporal
unlink($tempFile);

// Generar PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Agregar logos (asegúrate de que las rutas sean correctas)
$canvas = $dompdf->getCanvas();
$logoIzq = realpath(__DIR__ . '/alumno/view/img/dgeti.jpg');
$logoDer = realpath(__DIR__ . '/alumno/view/img/cbtis_logo.jpg');

if ($logoIzq && $logoDer) {
    $canvas->image($logoIzq, 38, 40, 100, 100);
    $canvas->image($logoDer, 458, 40, 100, 100);
}

// Pie de página
$pageHeight = $canvas->get_height();
$pageWidth = $canvas->get_width();
$fechaActual = date('d') . ' de ' . 
               ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'][date('n')-1] . 
               ' de ' . date('Y');

$footerText = "Certificado realizado el: $fechaActual";
$font = $dompdf->getOptions()->getDefaultFont();
$fontSize = 12;  
$textWidth = $dompdf->getFontMetrics()->getTextWidth($footerText, $font, $fontSize);
$x = $pageWidth - $textWidth - 40; 
$y = $pageHeight - 30;

$canvas->text($x, $y, $footerText, $font, $fontSize);

// Descargar o mostrar el PDF
$dompdf->stream("Certificado_$nombreAlumno.pdf", ["Attachment" => false]);