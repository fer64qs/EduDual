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

// Generar QR
$qrOptions = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel' => QRCode::ECC_L,
    'scale' => 5,
    'imageBase64' => false
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

// Guardar y leer QR como base64
$tempFile = tempnam(sys_get_temp_dir(), 'qr_');
file_put_contents($tempFile, $qrImage);
$qrBase64 = base64_encode(file_get_contents($tempFile));

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
        .firmas-container { margin-top: 60px; width: 100%; display: block; overflow: hidden; }
        .firma { display: inline-block; width: 28%; text-align: center; margin: 0 11px; font-size: 8px; }
        .subrayado { border-top: 1px solid black; margin: 11px auto; width: 80%; }
        .qr-container { margin: 20px auto; text-align: center; }
    </style>
</head>
<body>
<div style="padding: 40px; font-size: 14px; text-align: justify;">
    <p style="text-align: right;"><strong>ASUNTO:</strong> Asesor interno de Residencias Profesionales.</p>
    <br>
    <br>
    <p>C. <strong>$nombreAsesor</strong></p>
    <br>
    <br>
    <p style="text-align: center;">P r e s e n t e</p>
    <br>
    <p>
        Por este conducto informo a usted que ha sido asignado para fungir como Tutor en el proceso de educación dual 
        del alumno que cuenta con los siguientes datos:
    </p>
    <br>
    <br>
    <!-- Tabla con bordes -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; border: 1px solid #000;">
        <tr>
            <td style="padding: 5px; border: 1px solid #000;"><strong>a)</strong> Nombre del Residente:</td>
            <td style="padding: 5px; border: 1px solid #000;">$nombreAlumno</td>
        </tr>
        <tr>
            <td style="padding: 5px; border: 1px solid #000;"><strong>b)</strong> Carrera:</td>
            <td style="padding: 5px; border: 1px solid #000;">Técnico en programación</td>
        </tr>
        <tr>
            <td style="padding: 5px; border: 1px solid #000;"><strong>c)</strong> Fecha inicio:</td>
            <td style="padding: 5px; border: 1px solid #000;">$fecha_inicio</td>
        </tr>
        <tr>
            <td style="padding: 5px; border: 1px solid #000;"><strong>d)</strong> Fecha fin:</td>
            <td style="padding: 5px; border: 1px solid #000;">$fecha_fin</td>
        </tr>
        <tr>
            <td style="padding: 5px; border: 1px solid #000;"><strong>e)</strong> Empresa:</td>
            <td style="padding: 5px; border: 1px solid #000;">$nombreEmpresa</td>
        </tr>
    </table>
    <br>
    <br>
    <p>
        Así mismo, le solicito dar el seguimiento pertinente los avances desarrollados por el alumno durante su proceso de Educación dual
        para que este pueda desenvolverse correctamente durante ese periodo, asi como brindarle apoyo cuando este lo necesite.
    </p>
    <br>
    <br>
    <p>
        Agradezco de antemano su valioso apoyo en esta importante actividad para la formación profesional de nuestro 
        estudiantado.
    </p>
    <br><br><br>
    <br>
    <p style="text-align: center;">A t e n t a m e n t e.</p>
    <br><br><br>
    <p style="text-align: center;">_________________________________</p>
    <p style="text-align: center;">$nombreDirector<br>Director</p>
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

// Agregar encabezado y pie de página con imágenes y texto
$canvas = $dompdf->getCanvas();
$canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
    $imagePath = __DIR__ . '/alumno/view/images/encabezado.jpg'; 
    $footerPath = __DIR__ . '/alumno/view/images/piepagina.jpg';
    $font = $fontMetrics->get_font("Arial", "bold");

    if (file_exists($imagePath)) {
        $canvas->image($imagePath, 10, 10, 275, 50);
    }
    if (file_exists($footerPath)) {
        $canvas->image($footerPath, 5, 785, 575, 60);
    }

    $canvas->text(380, 10, "Subsecretaría de Educación Media Superior", $font, 10, [0, 0, 0]);
    $canvas->text(340, 20, "Dirección General de Educación Tecnológica Industrial y Servicios", $font, 8, [0, 0, 0]);
    $canvas->text(310, 30, "Centro de Bachillerato Tecnológico industrial y de servicios No. 193", $font, 9, [0, 0, 0]);
    $canvas->text(460, 40, "“José María Morelos y Pavón”", $font, 9, [0, 0, 0]);

    $canvas->text(200, 805, "cbtis193.docentes@dgeti.sems.gob.mx", $font, 7, [0, 0, 0]);
    $canvas->text(195, 795, "e-mail: cbtis193.dir@dgeti.sems.gob.mx,", $font, 7, [0, 0, 0]);
    $canvas->text(210, 785, "C.P. 97970 Tel y Fax (997)9740780", $font, 7, [0, 0, 0]);
    $canvas->text(170, 775, "Prolongación de la calle 53 oriente s/n Tekax Yucatán", $font, 7, [0, 0, 0]);
});

// Agregar la fecha en el pie de página
/*
$pageHeight = $canvas->get_height();
$pageWidth = $canvas->get_width();
$fechaActual = date('d') . ' de ' . 
               ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'][date('n')-1] . 
               ' de ' . date('Y');

$footerText = "Certificado realizado el: $fechaActual";
$font = $dompdf->getOptions()->getDefaultFont();
$fontSize = 12;
$textWidth = $dompdf->getFontMetrics()->getTextWidth($footerText, $font, $fontSize);
$x = $pageWidth - $textWidth - 40;
$y = $pageHeight - 30;
$canvas->text($x, $y, $footerText, $font, $fontSize);
*/
// Mostrar el PDF en el navegador
$dompdf->stream("Certificado_$nombreAlumno.pdf", ["Attachment" => false]);