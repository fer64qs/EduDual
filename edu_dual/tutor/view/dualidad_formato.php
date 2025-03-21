<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/alumno/view/DBC.php'); // Conexión a la base de datos

if (isset($_REQUEST["idinscripcion"])) {
    $idinscripcion = $_REQUEST["idinscripcion"];
	
}
if (isset($_REQUEST["idbitacora"])) {
    $idbitacora = $_REQUEST["idbitacora"];
}

if (isset($_REQUEST["nombrecompleto_alumno"])) {
    $nombrecompleto_alumno = $_REQUEST["nombrecompleto_alumno"];
}

if (isset($_REQUEST["nombre_empresa"])) {
    $nombre_empresa = $_REQUEST["nombre_empresa"];
}

if (isset($_REQUEST["nombreasesordual_docente"])) {
    $nombreasesordual_docente = $_REQUEST["nombreasesordual_docente"];
}

if (isset($_REQUEST["responsable_empresa"])) {
    $responsable_empresa = $_REQUEST["responsable_empresa"];
}

?>
<head>
<meta charset="utf-8">
    <title>CKEditor 5 – Classic editor</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
	
	
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

	
</head>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-km2t{border-color:#ffffff;font-weight:bold;text-align:left;vertical-align:top}
.tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-c3ow{text-align:center;vertical-align:top;width: 33.33%;}
.tg .tg-ddj0{background-color:#591a1a;border-color:inherit;color:#ffffff;font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-aw21{border-color:#ffffff;font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-h25s{border-color:#ffffff;font-weight:bold;text-align:right;vertical-align:top}
.tg .tg-u3qo{border-color:#ffffff;text-align:left;text-decoration:underline;vertical-align:top}
.tg .tg-va5j{background-color:#591a1a;border-color:inherit;color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-ynxx{background-color:#591a1a;border-color:inherit;color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
#tabla-firmas {
  border: none !important;
  text-align:center;

}

</style>


<div class="d-flex justify-content-center">
<?php

$semana="";
$fecha1="";
$descripcion1="";
$fecha2="";
$descripcion2="";
$fecha3="";
$descripcion3="";
$fecha4="";
$descripcion4="";
$fecha5="";
$descripcion5="";
$vobo_empresa="";
$observaciones_empresa="";
$indicador_empresa="";
$vobo_tutordual="";
$observaciones_tutor="";
$indicador_tutor="";
$dias_trabajados="";
$puesto="";
$observaciones_alumno="";
$estatus_semana="";
$estatus_semana = "";

	$idbitacora1 = $_REQUEST['idbitacora'];
	$query = "SELECT * FROM bitacoras WHERE idbitacora = :idbitacora1 ORDER BY no_semana";
	//echo $query;
    $resultados="";
try {
    $stmt = DBC::get()->prepare($query);
    $stmt->bindParam(':idbitacora1', $idbitacora1, PDO::PARAM_INT);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
		
		foreach ($resultados as $fila) {
            //echo '<option value="' . htmlspecialchars($fila['idbitacora']) . '">' . htmlspecialchars('Semana '.$fila['no_semana']) . '</option>';
        $semana = $fila["no_semana"];
		$fecha1=$fila["fecha1"];
		$descripcion1=$fila["descripcion1"];
		$fecha2=$fila["fecha2"];
		$descripcion2=$fila["descripcion2"];
		$fecha3=$fila["fecha3"];
		$descripcion3=$fila["descripcion3"];
		$fecha4=$fila["fecha4"];;
		$descripcion4=$fila["descripcion4"];
		$fecha5=$fila["fecha5"];
		$descripcion5=$fila["descripcion5"];
		$vobo_empresa=$fila["vobo_empresa"];
		$observaciones_empresa=$fila["observaciones_empresa"];
		$indicador_empresa=$fila["indicador_empresa"];
		$vobo_tutordual=$fila["vobo_tutordual"];
		$observaciones_tutor=$fila["observaciones_tutor"];
		$indicador_tutor=$fila["indicador_tutor"];
		$dias_trabajados=$fila["dias_trabajados"];
		$puesto=$fila["puesto"];
		$observaciones_alumno=$fila["observaciones_alumno"];
        $observaciones_tutor=$fila["observaciones_tutor"];
        $observaciones_empresa=$fila["observaciones_empresa"];
        $estatus_semana=$fila['estatus_semana'];
        $estatus_semana = $fila["estatus_semana"]; // Asignación inicial

		}
        
    } else {
        echo '<div class="alert alert-warning" role="alert">No se encontraron semanas para esta inscripción dual.</div>';
    }
} catch (Exception $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
}
	?>
</div>
<table class="tg" style="table-layout: fixed; width: 90%;"><colgroup>
<col style="width: 179.2px">
<col style="width: 179.2px">
<col style="width: 582.2px">
</colgroup>
<thead>
  <tr>
    <th class="tg-ddj0" colspan="4">SISTEMA DE EDUACIÓN DUAL</th>
  </tr></thead>
<tbody>
  <tr>
    <td class="tg-aw21" colspan="4">REPORTE SEMANAL</td>
  </tr>
  <tr>
    <td class="tg-zv4m"></td>
    <td class="tg-zv4m"></td>
    <td class="tg-h25s" colspan="2">Reporte semanal No. <?php echo $semana;?> &nbsp;&nbsp;&nbsp; D&iacute;as trabajados:
<input type="text"	id="txtdias_trabajados" name="txtdias_trabajados" value="<?php echo $dias_trabajados;?>" disabled>
	
	</td>
  </tr>
  <tr>
    <td class="tg-zv4m"></td>
    
    <td class="tg-h25s"></td>
	<td class="tg-h25s" colspan="2">Puesto de aprendizaje: 
      <select name="combo_puesto" id="combo_puesto" disabled>
    <option value="NO DEFINIDO" <?php echo $puesto == "NO DEFINIDO" ? 'selected' : ''; ?>>NO DEFINIDO</option>
    <option value="RECLUTAMIENTO" <?php echo $puesto == "RECLUTAMIENTO" ? 'selected' : ''; ?>>RECLUTAMIENTO</option>
    <option value="FORMACION Y DESARROLLO" <?php echo $puesto == "FORMACION Y DESARROLLO" ? 'selected' : ''; ?>>FORMACION Y DESARROLLO</option>
    <option value="ATENCION A COLABORADORES" <?php echo $puesto == "ATENCION A COLABORADORES" ? 'selected' : ''; ?>>ATENCION A COLABORADORES</option>
    <option value="SEGURIDAD E HIGIENE" <?php echo $puesto == "SEGURIDAD E HIGIENE" ? 'selected' : ''; ?>>SEGURIDAD E HIGIENE</option>
    </select>
	
</td>
  </tr>
  <tr>
    <td class="tg-km2t">Nombre del Alumno:</td>
    <td class="tg-u3qo" colspan="2"><?php echo $nombrecompleto_alumno;?></td>
  </tr>
  <tr>
    <td class="tg-km2t">Empresa:</td>
    <td class="tg-u3qo" colspan="2"><?php echo $nombre_empresa;?></td>
    <td class="tg-zv4m"></td>
  </tr>
  <tr>
    <td class="tg-va5j">FECHA</td>
    <td class="tg-ynxx" colspan="3">ACTIVIDADES REALIZADAS</td>
  </tr>

  <tr>
    <td class="tg-0pky">
	<label for="birthday"></label>
<input type="date" id="fecha1" name="fecha1" value="<?php echo $fecha1;?>" disabled>
	</td>
    <td class="tg-0pky" colspan="3">
	<div id="descripcion1" >
    <textarea name="editor1" id="editor1" rows="5">
        <?php 
        if (!empty($descripcion1)) {
            echo $descripcion1;
        }
        ?>
     </textarea>
</div>
    <script>
					ClassicEditor
						.create(document.querySelector('#editor1'), {
						placeholder: 'Describa las actividades que se realizaron en este día...'
							})
							.then(editor => {
								//'Si tiene observaciones con respecto a lo realizado por favor escríbalas.'
								// Aquí se guarda la instancia del editor
								window.editor1 = editor;
                                editor.enableReadOnlyMode('lock-editor1');
								})
									.catch(error => {
										console.error(error);
										});

				</script>
	</td>
  </tr>
  <tr>
    <td class="tg-0pky">
	<label for="birthday"></label>
<input type="date" id="fecha2" name="fecha2" value="<?php echo $fecha2;?>" disabled>
	</td>
    <td class="tg-0pky" colspan="3">
	
	<div id="descripcion2">
     <textarea name="editor2" id="editor2" rows="5">
        <?php 
        if (!empty($descripcion2)) {
            echo $descripcion2;
        }
        ?>
     </textarea>
</div>
    <script>
					ClassicEditor
						.create(document.querySelector('#editor2'), {
						placeholder: 'Describa las actividades que se realizaron en este día...'
							})
							.then(editor => {
								//'Si tiene observaciones con respecto a lo realizado por favor escríbalas.'
								// Aquí se guarda la instancia del editor
								window.editor2 = editor;
                                editor.enableReadOnlyMode('lock-editor2');
								})
									.catch(error => {
										console.error(error);
										});

		</script>
	</td>
  </tr>
  <tr>
    <td class="tg-0pky">
	<label for="birthday">:</label>
<input type="date" id="fecha3" name="fecha3" value="<?php echo $fecha3;?>" disabled>
	</td>
    <td class="tg-0pky" colspan="3">
	
	<div id="descripcion3">
    <textarea name="editor3" id="editor3" rows="5">
        <?php 
        if (!empty($descripcion3)) {
            echo $descripcion3;
        }
        ?>
     </textarea>
</div>
    <script>
					ClassicEditor
						.create(document.querySelector('#editor3'), {
						placeholder: 'Describa las actividades que se realizaron en este día...'
							})
							.then(editor => {
								//'Si tiene observaciones con respecto a lo realizado por favor escríbalas.'
								// Aquí se guarda la instancia del editor
								window.editor3 = editor;
                                editor.enableReadOnlyMode('lock-editor3');
								})
									.catch(error => {
										console.error(error);
										});

				</script>
	</td>
  </tr>
  <tr>
    <td class="tg-0pky">
	<label for="birthday"></label>
<input type="date" id="fecha4" name="fecha4" value="<?php echo $fecha4;?>" disabled>
	</td>
    <td class="tg-0pky" colspan="3">
	
	<div id="descripcion4">
     <textarea name="editor4" id="editor4" rows="5">
        <?php 
        if (!empty($descripcion4)) {
            echo $descripcion4;
        }
        ?>
     </textarea>
</div>
    <script>
					ClassicEditor
						.create(document.querySelector('#editor4'), {
						placeholder: 'Describa las actividades que se realizaron en este día...'
							})
							.then(editor => {
								//'Si tiene observaciones con respecto a lo realizado por favor escríbalas.'
								// Aquí se guarda la instancia del editor
								window.editor4 = editor;
                                editor.enableReadOnlyMode('lock-editor4');
								})
									.catch(error => {
										console.error(error);
										});

				</script>
	
	</td>
  </tr>
  
  <tr>
    <td class="tg-0pky">
	<label for="birthday"></label>
<input type="date" id="fecha5" name="fecha5" value="<?php echo $fecha5;?>" disabled>
	</td>
    <td class="tg-0pky" colspan="3">
	
	<div id="descripcion5">
    <textarea name="editor5" id="editor5" rows="5">
        <?php 
        if (!empty($descripcion5)) {
            echo $descripcion5;
        }
        ?>
     </textarea>
</div>
    <script>
					ClassicEditor
						.create(document.querySelector('#editor5'), {
						placeholder: 'Describa las actividades que se realizaron en este día...'
							})
							.then(editor => {
								//'Si tiene observaciones con respecto a lo realizado por favor escríbalas.'
								// Aquí se guarda la instancia del editor
								window.editor5 = editor;
                                editor.enableReadOnlyMode('lock-editor5');
								})
									.catch(error => {
										console.error(error);
										});

				</script>
	
	</td>
  </tr>
<!-- Comentarios del Estudiante Dual -->
<tr>
    <td class="tg-ynxx" colspan="4">COMENTARIOS DEL ESTUDIANTE DUAL</td>
</tr>
<tr>
    <td class="tg-0pky" colspan="4">
        <div id="editorComentariosAlumno">
            <textarea name="editor6" id="editor6" rows="5">
                <?php echo !empty($observaciones_alumno) ? $observaciones_alumno : ''; ?>
            </textarea>
        </div>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor6'), {
                    placeholder: 'Si tiene observaciones con respecto a lo realizado, por favor escríbalas...'
                })
                .then(editor => {
                    window.editor6 = editor;
                    editor.enableReadOnlyMode('lock-editor6');
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    </td>
</tr>

<!-- Comentarios del Tutor Dual -->
<tr>
    <td class="tg-ynxx" colspan="4">OBSERVACIONES DEL TUTOR DUAL</td>
</tr>
<tr>
    <td class="tg-0pky" colspan="4">
        <div id="editorComentariosTutor">
            <textarea name="editor7" id="editor7" rows="5">
                <?php echo !empty($observaciones_tutor) ? $observaciones_tutor : ''; ?>
            </textarea>
        </div>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor7'), {
                    placeholder: '(Sección para el Tutor Dual). Si tiene observaciones con respecto a lo realizado por el alumn@, por favor escríbalas...'
                })
                .then(editor => {
                    window.editor7 = editor;
                    //editor.enableReadOnlyMode('lock-editor7'); // Bloquear edición
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    </td>
</tr>
<tr>
<td class="tg-zv4m"></td>
    
    <td class="tg-h25s"></td>
	<td class="tg-h25s" colspan="2">Revision del tutor dual: 
      <select name="combo_vtutor" id="combo_vtutor">
    <option value="NO AUTORIZADO" <?php echo $vobo_tutordual == "NO AUTORIZADO" ? 'selected' : ''; ?>>NO AUTORIZADO</option>
    <option value="AUTORIZADO" <?php echo $vobo_tutordual == "AUTORIZADO" ? 'selected' : ''; ?>>AUTORIZADO</option>
    </select>
	
</td>
</tr>

<!-- Comentarios del Personal de la Empresa -->
<tr>
    <td class="tg-ynxx" colspan="4">OBSERVACIONES DEL PERSONAL DE LA EMPRESA</td>
</tr>
<tr>
    <td class="tg-0pky" colspan="4">
        <div id="editorComentariosPersonal">
            <textarea name="editor8" id="editor8" rows="5">
                <?php echo !empty($observaciones_empresa) ? $observaciones_empresa : ''; ?>
            </textarea>
        </div>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor8'), {
                    placeholder: '(Sección para el personal de la empresa). Si tiene observaciones con respecto a lo realizado por el alumn@, por favor escríbalas...'
                })
                .then(editor => {
                    window.editor8 = editor;
                    editor.enableReadOnlyMode('lock-editor8'); 
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    </td>
</tr>
<tr>
<td class="tg-zv4m"></td>
    
    <td class="tg-h25s"></td>
	<td class="tg-h25s" colspan="2">Revision del personal de la empresa: 
      <select name="combo_vempresa" id="combo_vempresa" disabled>
    <option value="NO AUTORIZADO" <?php echo $vobo_empresa == "NO AUTORIZADO" ? 'selected' : ''; ?>>NO AUTORIZADO</option>
    <option value="AUTORIZADO" <?php echo $vobo_empresa == "AUTORIZADO" ? 'selected' : ''; ?>>AUTORIZADO</option>
    </select>
	
</td>
</tr>
</tbody></table>
<table id="tabla-firmas" style="width: 90%; margin-top: 20px;">
  <tr>
    <td class="tg-c3ow">________________________<br>Nombre y firma del estudiante<br><?php echo $nombrecompleto_alumno; ?></td>
    <td class="tg-c3ow">________________________<br>Nombre y firma del asesor<br><?php echo $nombreasesordual_docente; ?></td>
    <td class="tg-c3ow">________________________<br>Nombre y firma del personal <br><?php echo $responsable_empresa; ?></td>
  </tr>
</table>
<br>
<br>
<br>
<!--

-->
<div class="text-center">
<br>
</div>

<div class="fixed-bottom-visible text-center">
  
  <button type="button" class="btn btn-danger" onclick="return actualizarDatos();">Guardar</button>
  <br>
</div>

    </tbody>
    <script>
function probar()
{
	const idbitacora = "<?php echo $idbitacora; ?>";
	
	var puesto = document.getElementById("combo_puesto").value;
	

    var vobo_tutordual = document.getElementById("combo_vtutor").value;
	

    var vobo_empresa = document.getElementById("combo_vempresa").value;
	

		let diasTrabajados = 0;

const descripcion1 = window.editor1.getData(); // Obtener el valor del editor
if (descripcion1.length > 0) {
    diasTrabajados++;
}

const descripcion2 = window.editor2.getData(); // Obtener el valor del editor
if (descripcion2.length > 0) {
    diasTrabajados++;
}

const descripcion3 = window.editor3.getData(); // Obtener el valor del editor
if (descripcion3.length > 0) {
    diasTrabajados++;
}

const descripcion4 = window.editor4.getData(); // Obtener el valor del editor
if (descripcion4.length > 0) {
    diasTrabajados++;
}

const descripcion5 = window.editor5.getData(); // Obtener el valor del editor
if (descripcion5.length > 0) {
    diasTrabajados++;
}

alert("Días trabajados: " + diasTrabajados);

}
</script>

<script>
function actualizarDatos() {
    const idbitacora = "<?php echo $idbitacora; ?>";
    const puesto = document.getElementById("combo_puesto").value;


    let diasTrabajados = 0;

    const descripcion1 = window.editor1.getData();
    if (descripcion1.length > 0) diasTrabajados++;

    const descripcion2 = window.editor2.getData();
    if (descripcion2.length > 0) diasTrabajados++;

    const descripcion3 = window.editor3.getData();
    if (descripcion3.length > 0) diasTrabajados++;

    const descripcion4 = window.editor4.getData();
    if (descripcion4.length > 0) diasTrabajados++;

    const descripcion5 = window.editor5.getData();
    if (descripcion5.length > 0) diasTrabajados++;

    const observaciones_alumno = window.editor6.getData(); // Obtener el valor del editor

    const observaciones_tutor = window.editor7.getData(); // Obtener el valor del editor
    
    const vobo_tutordual = document.getElementById("combo_vtutor").value;

    const observaciones_empresa = window.editor8.getData(); // Obtener el valor del editor

    const vobo_empresa = document.getElementById("combo_vempresa").value;

    // Crear un objeto con los datos a enviar
    const datos = {
        idbitacora: idbitacora,
        puesto: puesto,
        descripcion1: descripcion1,
        descripcion2: descripcion2,
        descripcion3: descripcion3,
        descripcion4: descripcion4,
        descripcion5: descripcion5,
        observaciones_alumno: observaciones_alumno,
        observaciones_tutor: observaciones_tutor,
        vobo_tutordual: vobo_tutordual,
        observaciones_empresa: observaciones_empresa,
        vobo_empresa: vobo_empresa,
        dias_trabajados: diasTrabajados
    };

    // Enviar los datos por AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_bitacora.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert(xhr.responseText); // Mostrar el resultado de la actualización

                // Actualizar el campo de días trabajados
                const txtDiasTrabajados = document.getElementById('txtdias_trabajados');
                txtDiasTrabajados.value = diasTrabajados;

                // Abrir la nueva pestaña con form_datosalumno.php
                window.location.href = "form_datosalumno.php";
        
            } else {
                alert("Ocurrió un error al intentar actualizar los datos");
            }
        }
    };

    xhr.send(new URLSearchParams(datos).toString());
}
</script>


<script>
       
    </script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fixed-bottom-visible {
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1000;
      background-color: #f8f9fa;
      padding: 10px;
      box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
    }
  </style>
<script>
  let lastScrollTop = 0;
  window.addEventListener("scroll", function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop < lastScrollTop) {
      document.getElementById("buttonBar").style.display = "block";
    } else {
      document.getElementById("buttonBar").style.display = "none";
    }
    lastScrollTop = scrollTop;
  });
</script>