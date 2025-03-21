<?php
require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar DomPDF para orientación horizontal
$options = new Options();
$options->set('defaultFont', 'Arial');
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
    <title>Certificado de Terminación de educacion dual </title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 95%; padding: 20px; border: 5px solid #000;  }
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
    
    <br>
        
        <h1>Certificado de Terminación de educacion dual</h1>
        <br>
        <p class='certificado'>Se otorga el presente certificado a:</p>
        <h2>$nombreAlumno</h2>
        <p></p>
        <p class='certificado'>Por culminar su estancia en la empresa: $nombreEmpresa obteniendo calificación aprobatoria y el
certificado de terminación tipo Honor otorgado por el Centro de Bachillerato Tecnológico industrial y de servicios No. 193
“José María Morelos y Pavón”
</p>
        <br>
        <p class='certificado'>Bajo la tutoría del asesor académico:</p>
        <h2>$nombreAsesor</h2>
        <p class='certificado'>Y la supervisión de:</p>
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
$dompdf->stream("Certificado_$nombreAlumno.pdf", ["Attachment" => false]);
?>