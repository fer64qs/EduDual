<?php
//require_once('DBC.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');


$bitacora_creada="";
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
        inscripciones.idtutor_academico,
        tutores_academicos.apellido_paterno,
        tutores_academicos.apellido_materno,
        tutores_academicos.nombre_tutor,
        inscripciones.idpersonal,
        personal_empresas.nombre_personal,
        personal_empresas.papellido_paterno,
        personal_empresas.papellido_materno,
        inscripciones.idSemestre,
        semestres.semestre,
        inscripciones.fecha_inicio,
        inscripciones.fecha_fin,
        inscripciones.estatus
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

    $fechaInicial = "";
    $fechaFinal = "";
    foreach ($resultados as $fila) {
		$fechaInicial=$fila['fecha_inicio'];
		$fechaFinal=$fila['fecha_fin'];
        //echo "ID Inscripción: " . $fila['idinscripcion'] . "<br>";
		echo "<h2><center><b>Detalle del calendario de actividades</b></center></h2> <br>";
        echo "Alumno: <b>" . $fila['nombre'] . " " . $fila['apellidop'] . " " . $fila['apellidom'] . "</b><br>";
        echo "Número de Control: <b>" . $fila['num_control'] . "</b><br>";
        echo "CURP: <b>" . $fila['curp'] . "</b><br>";
        echo "Empresa: <b>" . $fila['nombre_empresa'] . " (RFC: " . $fila['rfc'] . ", Representante: " . $fila['representante'] . ")</b><br>";
        echo "Ciclo Escolar: <b>" . $fila['semestre'] . "</b><br>";
        echo "Fecha Inicio: <b>" . $fila['fecha_inicio'] . "</b><br>";
        echo "Fecha Finaliza: <b>" . $fila['fecha_fin'] . "</b><br>";
        echo "Estatus: <b>" . $fila['estatus'] . "</b><br>";
        echo "Tutor Dual: <b>" . $fila['nombre_tutor'] . " " . $fila['apellido_paterno'] . " " . $fila['apellido_materno'] . "</b><br>";
        echo "Personal de la empresa: <b>" . $fila['nombre_personal'] . " " . $fila['papellido_paterno'] . " " . $fila['papellido_materno'] . "</b><br>";
        echo "<hr>";
    }
    $bitacora_creada = verificarRegistros($idinscripcion);
}

function verificarRegistros($idInscripcion) {
    $query = "SELECT * FROM bitacoras WHERE idinscripcion = :idinscripcion";
    try {
        $stmt = DBC::get()->prepare($query);
        $stmt->bindValue(':idinscripcion', $idInscripcion, PDO::PARAM_INT);
        $stmt->execute();
        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            echo "<input type='text' id='estatus' name='estatus' value='CREADO' hidden>";
            echo "<div class='alert alert-success' role='alert'> <b>El Calendario de Actividades ya ha sido creado</b></div>
            <script>document.getElementById('insertarBitacoras').style.display = 'none';</script>";
            return "SI";
        } else {
            echo "<input type='text' id='estatus' name='estatus' value='NO CREADO' hidden>";
            echo "<div class='alert alert-danger' role='alert'> <b>El Calendario de Actividades No ha sido creado</b></div>";
            return "NO";
        }
    } catch (Exception $e) {
        echo "Error al verificar los registros: " . $e->getMessage();
        return "ERROR";
    }
}

//echo "la bitacora vale:" . $bitacora_creada;


?>
<link rel="stylesheet" href="alert/style.css" />
     <script src="alert/cute-alert.js"></script>
<div style="text-align: center;">
    <form id="bitacoraForm">
        <input type="hidden" id="idinscripcion" value="<?php echo $idinscripcion; ?>">
		
		
			<button type="button" id="insertarBitacoras" class="btn btn-danger" >Crear Bit&aacute;coras</button>
		
        
    </form>
</div>
<?php

// Función para traducir días y meses al español
function traducirFecha($fecha) {
    $dias = [
        'Monday' => 'lunes',
        'Tuesday' => 'martes',
        'Wednesday' => 'miércoles',
        'Thursday' => 'jueves',
        'Friday' => 'viernes',
        'Saturday' => 'sábado',
        'Sunday' => 'domingo'
    ];

    $meses = [
        'January' => 'ene',
        'February' => 'feb',
        'March' => 'mar',
        'April' => 'abr',
        'May' => 'may',
        'June' => 'jun',
        'July' => 'jul',
        'August' => 'ago',
        'September' => 'sep',
        'October' => 'oct',
        'November' => 'nov',
        'December' => 'dic'
    ];

    $fechaObj = new DateTime($fecha);
    $dia = $fechaObj->format('l');
    $fechaFormateada = $fechaObj->format('j \d\e M Y');
    
    $diaTraducido = $dias[$dia];
    $mes = $fechaObj->format('F');
    $mesTraducido = $meses[$mes];

    return "$diaTraducido {$fechaObj->format('j')} de $mesTraducido {$fechaObj->format('Y')}";
}

// Función para generar las semanas y días laborales (lunes a viernes)
function generarSemanas($fechaInicial, $fechaFinal) {
    $fechaInicio = new DateTime($fechaInicial);
    $fechaFin = new DateTime($fechaFinal);
    
    if ($fechaInicio->format('N') != 1) {
        $diasRetroceso = $fechaInicio->format('N') - 1;
        $fechaInicio->modify("-$diasRetroceso day");
    }
    
    $semanas = [];
    $semanaActual = [];

    while ($fechaInicio <= $fechaFin) {
        if ($fechaInicio->format('N') >= 1 && $fechaInicio->format('N') <= 5) {
            $semanaActual[] = $fechaInicio->format('Y-m-d');
        }
        
        if (count($semanaActual) == 5) {
            $semanas[] = $semanaActual;
            $semanaActual = [];
        }
        
        $fechaInicio->modify('+1 day');
    }

    if (!empty($semanaActual) && count($semanaActual) < 5) {
        $ultimoDia = end($semanaActual);
        $fechaUltima = new DateTime($ultimoDia);
        
        while (count($semanaActual) < 5) {
            $fechaUltima->modify('+1 day');
            if ($fechaUltima->format('N') >= 1 && $fechaUltima->format('N') <= 5) {
                $semanaActual[] = $fechaUltima->format('Y-m-d');
            }
        }
        $semanas[] = $semanaActual;
    }

    return $semanas;
}

//$fechaInicial = '2024-08-23';
//$fechaFinal = '2024-12-31';

$semanas = generarSemanas($fechaInicial, $fechaFinal);
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo "<table class='table table-bordered'>";
echo "<thead class='thead-dark'><tr><th>Semana</th><th colspan='5'>Días</th><th>Total de días</th></tr></thead>";
echo "<tbody>";

foreach ($semanas as $indice => $semana) {
    echo "<tr>";
    echo "<td>Semana " . ($indice + 1) . "</td>";
    
    $fechasFormateadas = array_map('traducirFecha', $semana);
    
    foreach ($fechasFormateadas as $fecha) {
        echo "<td style='background-color: #f8c8dc;'>$fecha</td>";
    }
    
    for ($i = count($semana); $i < 5; $i++) {
        echo "<td style='background-color: #f8c8dc;'></td>";
    }

    echo "<td>" . count($semana) . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";


?>

<div id="messageContainer"></div>


<script>
document.getElementById("insertarBitacoras").addEventListener("click", function() {
	//##
	var estatus = document.getElementById("estatus").value;
    if (estatus == "CREADO") {
        //alert("El Cronograma de Actividades ya ha sido creado para esta modalidad dual");
		 cuteToast({
                        type: "error",
                        message: "El Cronograma de Actividades ya ha sido creado para esta modalidad dual",
                        timer: 4000
                    });
        event.preventDefault(); // Evita que el evento continúe
        return false;
    }
	//###
	
    var semanas = <?php echo json_encode($semanas); ?>;
    var idInscripcion = document.getElementById("idinscripcion").value;

    semanas.forEach(function(semana, index) {
        var datos = {
            idinscripcion: idInscripcion,
            no_semana: index + 1,
            fecha1: semana[0] || null,
            fecha2: semana[1] || null,
            fecha3: semana[2] || null,
            fecha4: semana[3] || null,
            fecha5: semana[4] || null,
            vobo_empresa: 'NO AUTORIZADO',
            vobo_tutordual: 'NO AUTORIZADO',
            dias_trabajados: 0,
            indicador_empresa: 'NO DEFINIDO',
            indicador_tutor: 'NO DEFINIDO',
			puesto: 'NO DEFINIDO'
        };

        insertarBitacora(datos);
		
		
		
    });
	// Esperar 5 segundos antes de redirigir
    setTimeout(function() {
        window.location.href = "formcat_inscripciones.php";
    }, 5000); // 5000 milisegundos = 5 segundos

	
});

function insertarBitacora(datos) {
    $.ajax({
        url: 'insertar_bitacora.php',
        type: 'POST',
        data: datos,
        dataType: 'json',
        success: function(response) {
            console.log(response); // Para depuración

            if (response && response.messages) {
                // Itera sobre cada mensaje y muestra un toast
                response.messages.forEach(function(message) {
                    cuteToast({
                        type: "success",
                        message: "La bitácora de actividades ha sido creada exitosamente",
                        timer: 4000
                    });
                });
            } else {
                $('#messageContainer').html('<p style="color: red;">Respuesta del servidor inválida.</p>');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al crear la bitácora: " + error);
            $('#messageContainer').html('<p style="color: red;">Error al insertar la bitácora.</p>');
        }
    });
}

</script>

