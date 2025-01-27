<?php
////**
$nombreCarpeta ="";
$nombreArchivo ="";
if (!isset($_REQUEST["nombre_carpeta"])) {
    die("Error: Falta el parámetro 'nombre_carpeta'.");
} else {$nombreCarpeta = $_REQUEST["nombre_carpeta"];}

if (!isset($_REQUEST["nombre_archivo"])) {
    die("Error: Falta el parámetro 'nombre_archivo'.");
}else {$nombreArchivo = $_REQUEST["nombre_archivo"];}


//$carpetaPath = __DIR__ . '/uploads/dbfs/' . $nombreCarpeta;
///***


$uploadDir = __DIR__ . '/uploads/dbfs/' . $nombreCarpeta.'/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['dbf_files'])) {
    // Copiar los archivos DBF
    foreach ($_FILES['dbf_files']['tmp_name'] as $index => $tmpFilePath) {
        $originalFileName = $_FILES['dbf_files']['name'][$index];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        if (strtolower($fileExtension) === 'dbf') {
            $newFilePath = $uploadDir . basename($originalFileName);
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                echo "<p>Archivo DBF $originalFileName copiado con éxito. <img src='img/ok.png'></p>";
            } else {
                echo "<p>Error al copiar el archivo DBF $originalFileName. <img src='img/error.png'></p>";
            }
        }
    }
} else {
    echo "<p>No se seleccionaron archivos DBF.</p>";
}
?>
