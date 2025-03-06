<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/personal/view/DBC.php'); // Conexión a la base de datos

// Inicializar las variables para evitar errores si no están definidas en la solicitud
$nombrecompleto_alumno = isset($_REQUEST["nombrecompleto_alumno"]) ? $_REQUEST["nombrecompleto_alumno"] : '';
$nombre_empresa = isset($_REQUEST["nombre_empresa"]) ? $_REQUEST["nombre_empresa"] : '';
$idasesordual_docente = isset($_REQUEST["idasesordual_docente"]) ? $_REQUEST["idasesordual_docente"] : '';
$nombreasesordual_docente = isset($_REQUEST["nombreasesordual_docente"]) ? $_REQUEST["nombreasesordual_docente"] : '';
$responsable_empresa = isset($_REQUEST["responsable_empresa"]) ? $_REQUEST["responsable_empresa"] : '';

$bitacora_creada = "";

if (isset($_REQUEST['idinscripcion'])) {
    $idinscripcion = $_REQUEST['idinscripcion'];

    $query = "
    SELECT 
        inscripciones.idinscripcion,
        inscripciones.idalumno,
        alumnos.apellidop,
        alumnos.apellidom,
        alumnos.nombre,
        alumnos.num_control,
        alumnos.curp,
        inscripciones.idempresa,
        empresas.nombre_empresa,
        empresas.rfc,
        empresas.representante,
        inscripciones.idSemestre,
        semestres.semestre,
        inscripciones.fecha_inicio,
        inscripciones.fecha_fin,
        inscripciones.estatus,
        inscripciones.idpersonal,
        personal_empresas.papellido_paterno,
        personal_empresas.papellido_materno,
        personal_empresas.nombre_personal,
        inscripciones.idtutor_academico,
        tutores_academicos.apellido_paterno,
        tutores_academicos.apellido_materno,
        tutores_academicos.nombre_tutor
    FROM 
        inscripciones
    JOIN 
        alumnos ON inscripciones.idalumno = alumnos.idalumno
    JOIN 
        empresas ON inscripciones.idempresa = empresas.idempresa
    JOIN 
        semestres ON inscripciones.idSemestre = semestres.idSemestre
    JOIN 
        personal_empresas ON inscripciones.idpersonal = personal_empresas.idpersonal
    JOIN 
       tutores_academicos ON inscripciones.idtutor_academico = tutores_academicos.idtutor_academico
    WHERE 
        inscripciones.idinscripcion = :idinscripcion
    ";

    $stmt = DBC::get()->prepare($query);
    $stmt->bindParam(':idinscripcion', $idinscripcion, PDO::PARAM_INT);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $fila) {
        // Concatenar los nombres completos
        $nombrecompleto_alumno = $fila['nombre'] . ' ' . $fila['apellidop'] . ' ' . $fila['apellidom'];
        $nombre_empresa = $fila['nombre_empresa'];
        $nombreasesordual_docente = $fila['nombre_tutor'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'];
        $responsable_empresa = $fila['nombre_personal'] . ' ' . $fila['papellido_paterno'] . ' ' . $fila['papellido_materno'];

        // Mostrar los detalles del calendario de actividades
        echo "<h2><center><b>Detalle del calendario de actividades</b></center></h2> <br>";
        echo "&nbsp;&nbsp;Alumno: <b>" . htmlspecialchars($nombrecompleto_alumno) . "</b><br>";
        echo "&nbsp;&nbsp;Número de Control: <b>" . htmlspecialchars($fila['num_control']) . "</b><br>";
        echo "&nbsp;&nbsp;CURP: <b>" . htmlspecialchars($fila['curp']) . "</b><br>";
        echo "&nbsp;&nbsp;Empresa: <b>" . htmlspecialchars($fila['nombre_empresa']) . " (RFC: " . htmlspecialchars($fila['rfc']) . ", Representante: " . htmlspecialchars($fila['representante']) . ")</b><br>";
        echo "&nbsp;&nbsp;Ciclo Escolar: <b>" . htmlspecialchars($fila['semestre']) . "</b><br>";
        echo "&nbsp;&nbsp;Fecha Inicio: <b>" . htmlspecialchars($fila['fecha_inicio']) . "</b><br>";
        echo "&nbsp;&nbsp;Fecha Finaliza: <b>" . htmlspecialchars($fila['fecha_fin']) . "</b><br>";
        echo "&nbsp;&nbsp;Estatus: <b>" . htmlspecialchars($fila['estatus']) . "</b><br>";
        echo "&nbsp;&nbsp;Personal Empresa: <b>" . htmlspecialchars($fila['nombre_personal']) . " " . htmlspecialchars($fila['papellido_paterno']) . " " . htmlspecialchars($fila['papellido_materno']) . "</b><br>";
        echo "&nbsp;&nbsp;Tutor Academico: <b>" . htmlspecialchars($fila['nombre_tutor']) . " " . htmlspecialchars($fila['apellido_paterno']) . " " . htmlspecialchars($fila['apellido_materno']) . "</b><br>";
        echo "<hr>";

        // Llamar a la función para verificar y mostrar la bitácora
        verificarRegistros($idinscripcion, $nombrecompleto_alumno, $nombre_empresa, $nombreasesordual_docente, $responsable_empresa);
    }
}

// Función para verificar la existencia de registros
function verificarRegistros($idinscripcion, $nombrecompleto_alumno, $nombre_empresa, $nombreasesordual_docente, $responsable_empresa) {
    $query = "SELECT * FROM bitacoras WHERE idinscripcion = :idinscripcion";

    try {
        $stmt = DBC::get()->prepare($query);
        $stmt->bindValue(':idinscripcion', $idinscripcion, PDO::PARAM_INT);
        $stmt->execute();

        $numRows = $stmt->rowCount();

        if ($numRows > 0) {
            echo "<input type='text' id='estatus' name='estatus' value='CREADO' hidden>";
            echo "<div class='alert alert-success' role='alert'> <b>El Calendario de Actividades ya ha sido creado</b></div>";
            echo "<script>document.getElementById('insertarBitacoras').style.display = 'none';</script>";
            // Mostrar la tabla con la bitácora
            mostrarBitacoras($idinscripcion, $nombrecompleto_alumno, $nombre_empresa, $nombreasesordual_docente, $responsable_empresa);
        } else {
            echo "<input type='text' id='estatus' name='estatus' value='NO CREADO' hidden>";
            echo "<div class='alert alert-danger' role='alert'> <b>El Calendario de Actividades No ha sido creado<b></div>";
        }
    } catch (Exception $e) {
        echo "Error al verificar los registros: " . $e->getMessage();
    }
}

// Función para mostrar las bitácoras en una tabla
function mostrarBitacoras($idinscripcion, $nombrecompleto_alumno, $nombre_empresa, $nombreasesordual_docente, $responsable_empresa) {
    $query = "SELECT * FROM bitacoras WHERE idinscripcion = :idinscripcion ORDER BY bitacoras.no_semana";

    try {
        $stmt = DBC::get()->prepare($query);
        $stmt->bindValue(':idinscripcion', $idinscripcion, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados) {
            echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
            echo '<table class="table table-bordered table-hover">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th>No Semana</th>';
            echo '<th>D&iacute;a 1</th>';
            echo '<th>D&iacute;a 2</th>';
            echo '<th>D&iacute;a 3</th>';
            echo '<th>D&iacute;a 4</th>';
            echo '<th>D&iacute;a 5</th>';
            echo '<th>D&iacute;as Trabajados</th>';
            echo '<th>Puesto</th>';
            echo '<th>Estatus Semana</th>';
            echo '<th>Actividades</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($resultados as $fila) {
                $idbitacora = $fila['idbitacora'];
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['no_semana']) . '</td>';
                echo '<td style="background-color:' . getColor($fila['descripcion1']) . ';">' . htmlspecialchars($fila['fecha1']) . '</td>';
                echo '<td style="background-color:' . getColor($fila['descripcion2']) . ';">' . htmlspecialchars($fila['fecha2']) . '</td>';
                echo '<td style="background-color:' . getColor($fila['descripcion3']) . ';">' . htmlspecialchars($fila['fecha3']) . '</td>';
                echo '<td style="background-color:' . getColor($fila['descripcion4']) . ';">' . htmlspecialchars($fila['fecha4']) . '</td>';
                echo '<td style="background-color:' . getColor($fila['descripcion5']) . ';">' . htmlspecialchars($fila['fecha5']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['dias_trabajados']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['puesto']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['estatus_semana']) . '</td>';
                echo "<td> <a href='#' onclick=\"window.location='dualidad_formato.php?idbitacora=$idbitacora&nombrecompleto_alumno=" . urlencode($nombrecompleto_alumno) . "&nombre_empresa=" . urlencode($nombre_empresa) . "&nombreasesordual_docente=" . urlencode($nombreasesordual_docente) . "&responsable_empresa=" . urlencode($responsable_empresa) . "&idinscripcion=$idinscripcion'; return false;\"><img src='img/write.png'></a></td>";
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<div class='alert alert-warning' role='alert'>No se encontraron registros para mostrar.</div>";
        }
    } catch (Exception $e) {
        echo "Error al mostrar las bitácoras: " . $e->getMessage();
    }
}

// Función para determinar el color de fondo de la celda basado en la descripción
function getColor($descripcion) {
    return $descripcion ? '#A1FF9A' : '#FF9A9A'; // Verde si tiene valor, Rojo si no tiene valor
}
?>