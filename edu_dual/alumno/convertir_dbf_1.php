<?php
require 'vendor/autoload.php'; // Asegúrate de tener instalada la librería de RebaseData

use RebaseData\Converter\Converter;
use RebaseData\InputFile\InputFile;

$nombreCarpeta ="";
$nombreArchivo ="";
if (!isset($_REQUEST["nombre_carpeta"])) {
    die("Error: Falta el parámetro 'nombre_carpeta'.");
} else {$nombreCarpeta = $_REQUEST["nombre_carpeta"];}

if (!isset($_REQUEST["nombre_archivo"])) {
    die("Error: Falta el parámetro 'nombre_archivo'.");
}else {$nombreArchivo = $_REQUEST["nombre_archivo"];}
/*
if (!isset($_REQUEST["semestre"])) {
    die("Error: Falta el parámetro 'semestre'.");
}*/



$uploadDir = __DIR__ . '/uploads/dbfs/' . $nombreCarpeta.'/';
if (isset($_FILES['dbf_files'])) {
    foreach ($_FILES['dbf_files']['name'] as $index => $originalFileName) {
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        if (strtolower($fileExtension) === 'dbf') {
            $newFilePath = $uploadDir . basename($originalFileName);

            // Procesar el archivo DBF
            try {
                $inputFiles = [new InputFile($newFilePath)];
                $baseFileName = substr($originalFileName, 0, -4);
                $memoFilePath = $uploadDir . $baseFileName . '.fpt';

                if (file_exists($memoFilePath)) {
                    $inputFiles[] = new InputFile($memoFilePath);
                }

                $converter = new Converter();
                $database = $converter->convertToDatabase($inputFiles);
                $tables = $database->getTables();

  /*              
foreach ($tables as $table) {
    $nombre_tabla = $table->getName();
    echo "<h3>Tabla: $nombre_tabla</h3>";
    $rows = iterator_to_array($table->getRowsIterator()); // Convertir el generador en un array

    // Crear archivo .sql para los inserts
    $sqlFilePath = __DIR__ . "/$nombre_tabla.sql";
    $sqlFile = fopen($sqlFilePath, 'w'); // Abrir el archivo .sql

    echo '<table border="1" cellpadding="5" cellspacing="0">';
    
    if (!empty($rows)) {
        // Obtener los nombres de las columnas del primer registro
        $columns = array_keys($rows[0]);
        
        // Generar los INSERTS
        foreach ($rows as $row) {
            // Limpiar los valores y manejarlos correctamente
            $values = array_map(function ($value) {
                return is_null($value) ? 'NULL' : "'" . addslashes(trim($value)) . "'"; // Elimina los espacios extra y escapa comillas
            }, $row);

            // Generar el INSERT INTO
            $insertSQL = "INSERT INTO $nombre_tabla (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
            fwrite($sqlFile, $insertSQL); // Escribir el INSERT en el archivo .sql
        }

        // Mostrar los datos en la tabla HTML
        echo '<tr>';
        foreach ($columns as $columnName) {
            echo "<th>$columnName</th>";
        }
        echo '</tr>';

        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars(trim($value)) . "</td>"; // Mostrar sin espacios extra
            }
            echo '</tr>';
        }
    }
    
    echo '</table>';

    fclose($sqlFile); // Cerrar el archivo .sql después de generar los inserts
    echo "<p>Archivo SQL creado: <a href='$sqlFilePath'>$sqlFilePath</a></p>"; // Link al archivo generado
}
*/
foreach ($tables as $table) {
    $nombre_tabla = $table->getName();
    $rows = iterator_to_array($table->getRowsIterator()); // Convertir el generador en un array
	
	
	
	//////*****
	// Crear la ruta completa del directorio y del archivo
$carpetaPath = __DIR__ . '/uploads/dbfs/' . $nombreCarpeta.'/';
//echo $carpetaPath;
//esto se ajusta al directorio con una carpeta del semestre activo.
//Para que podamos usar este proceso se debe de haber configurado el semestre activo o en curso

//$carpetaPath = __DIR__ . '/scripts/'.$semestre.'/' . $nombreCarpeta;
$sqlFilePath = $carpetaPath . '/' . $nombre_tabla . '.sql';

// Verificar si el directorio existe; si no, crearlo
if (!is_dir($carpetaPath)) {
    mkdir($carpetaPath, 0755, true); // Crear la carpeta con permisos y en modo recursivo
}
	
	//////*****
	
	

    // Crear archivo .sql para los inserts
    //$sqlFilePath = __DIR__ . "/$nombre_tabla.sql";
    $sqlFile = fopen($sqlFilePath, 'w'); // Abrir el archivo .sql
	
	
	

    if (!empty($rows)) {
        // Obtener los nombres de las columnas del primer registro
        $columns = array_keys($rows[0]);
        
        // Generar los INSERTS
        foreach ($rows as $row) {
            // Limpiar los valores y manejarlos correctamente
            $values = array_map(function ($value) {
                return is_null($value) ? 'NULL' : "'" . addslashes(trim($value)) . "'"; // Elimina los espacios extra y escapa comillas
            }, $row);

            // Generar el INSERT INTO
			//$insertSQL = "INSERT INTO $nombre_tabla (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
            $insertSQL = "INSERT INTO $nombre_tabla (" . implode(", ", $columns) . ", idmaestro) VALUES (" . implode(", ", $values) . ", 137);\n";
            fwrite($sqlFile, $insertSQL); // Escribir el INSERT en el archivo .sql
        }
    }

    fclose($sqlFile); // Cerrar el archivo .sql después de generar los inserts
    echo "<p>Archivo SQL creado: $nombre_tabla".".sql <img src='img/ok.png'></p>"; // Link al archivo generado
	//echo "<p>Archivo SQL creado: <a href='$sqlFilePath'>$sqlFilePath</a> <img src='img/ok.png'></p>"; // Link al archivo generado
}


            } catch (Exception $e) {
                echo "<p>Error al procesar el archivo $originalFileName: " ."<img src='img/error.png'>" . $e->getMessage() . "</p>";
            }
        }
    }
} else {
    echo "<p>No se seleccionaron archivos DBF para procesar.</p>";
}
?>
