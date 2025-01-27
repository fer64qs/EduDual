<?php include('cat_tutoresacademicos/tutores_academicos.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Tutor@s Dual</title>
  <!--
 <link href="js/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/axios.min.js"></script>
  <link href="js/all.min.css" rel="stylesheet">
  <script src="js/sweetalert.min.js"></script> 
  -->
  
  <!-- referencias con acceso a CDN online -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
  
  <!-- SweetAlert2 -->
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->



  <style>
    .alert-custom {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
       
<div style="position: sticky; top: 0; background-color: #f4f6f6; z-index: 10; padding: 10px;">
  <h4 class="text-center">Catálogo de Tut@res Acad&eacute;micos</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar Tutor..."
        oninput="filtrarCards()"
      >
    </div>
    <div class="col-3 text-end">
      <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAgregar">Nuevo</button>
    </div>
  </div>
  <!-- Segunda fila con el label -->
  <div class="row mt-2">
    <div class="col-12 text-center">
      <label id="cantidadRegistros" class="form-label" style="font-weight: bold; color: #A57F2C;"><strong>Cantidad de registros: 0</strong></label>
    </div>
  </div>
</div>


    <!--cards begin -->
<div class="row">
  <?php
  $tutores = cargarTutoresDual();
  $totalRegistros = count($tutores); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($tutores as $tutor) {
    // Procesar datos para asegurar codificación UTF-8
    $nombre_tutor = htmlspecialchars(utf8_encode($tutor['nombre_tutor']));
    $apellido_paterno = htmlspecialchars(utf8_encode($tutor['apellido_paterno']));
    $apellido_materno = htmlspecialchars(utf8_encode($tutor['apellido_materno']));
    $sexo = htmlspecialchars(utf8_encode($tutor['sexo']));
    $num_celular = htmlspecialchars(utf8_encode($tutor['num_celular']));
    $email = htmlspecialchars(utf8_encode($tutor['email']));
    $titulo_academico = htmlspecialchars(utf8_encode($tutor['titulo_academico']));
    $especialidad = htmlspecialchars(utf8_encode($tutor['especialidad']));
	$curp = htmlspecialchars(utf8_encode($tutor['curp']));

    $icono = ($sexo == 'HOMBRE') ? 'fa-male' : 'fa-female';
    $color = ($sexo == 'HOMBRE') ? 'black' : '#d093b6';

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$nombre_tutor} {$apellido_paterno} {$apellido_materno}</b></h5>";

    echo "<p class='card-text'>";
	 echo "<b>CURP:</b> {$curp}<br>";
    echo "<b>G&eacute;nero:</b> {$sexo}<br>";
    echo "<b>Celular:</b> {$num_celular}<br>";
    echo "<b>Correo:</b> {$email}<br>";
    echo "<b>Título:</b> {$titulo_academico}<br>";
    echo "<b>Especialidad:</b> {$especialidad}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarAlumno({$tutor['idtutor_academico']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarAlumno({$tutor['idtutor_academico']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    echo "<button class='btn btn-info' onclick='crearCuenta(\"{$tutor['idtutor_academico']}\", \"{$nombre_tutor}\", \"{$apellido_paterno}\", \"{$apellido_materno}\", \"{$email}\", \"{$num_celular}\")' style='font-size: 14px;'>
            <i class='fas fa-user'></i> Acceso
          </button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
?>

</div>



	<!-- cards end-->
  </div>

  <!-- Modal para agregar alumno -->
  <!-- Modal para agregar alumno -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Tut@r</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="nombre" class="form-label"><b>Nombre:</b></label>
              <input type="text" class="form-control" id="nombre" name="nombre" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="apellidop" class="form-label"><b>Apellido Paterno:</b></label>
              <input type="text" class="form-control" id="apellidop" name="apellidop" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="apellidom" class="form-label"><b>Apellido Materno:</b></label>
              <input type="text" class="form-control" id="apellidom" name="apellidom" style="text-transform: uppercase;" required>
            </div>
			
            <div class="mb-3">
              <label for="curp" class="form-label"><b>CURP:</b></label>
              <input type="text" class="form-control" id="curp" name="curp" style="text-transform: uppercase;" required>
            </div>
			
			<div class="mb-3">
              <label for="sexo" class="form-label"><b>G&eacute;nero:</b></label>
              <select class="form-control" id="sexo" name="sexo" required>
                <option value="HOMBRE">HOMBRE</option>
                <option value="MUJER">MUJER</option>
              </select>
            </div>
			<div class="mb-3">
              <label for="celular" class="form-label"><b>Celular:</b></label>
              <input type="number" class="form-control" id="celular" name="celular" required>
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label"><b>Correo:</b></label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
			<div class="mb-3">
              <label for="titulo" class="form-label"><b>T&iacute;tulo:</b></label>
              <input type="text" class="form-control" id="titulo" name="titulo" style="text-transform: uppercase;" placeholder="Ejemplo: Ing., Lic., Dr." required>
            </div>
			<!--
            <div class="mb-3">
              <label for="curp" class="form-label"><b>CURP:</b></label>
              <input type="text" class="form-control" id="curp" name="curp" style="text-transform: uppercase;" required>
            </div>
			-->
            <!--
            <div class="mb-3">
              <label for="num_control" class="form-label"><b>N&uacute;mero de Control:</b></label>
              <input type="text" class="form-control" id="num_control" name="num_control" style="text-transform: uppercase;" required>
            </div>
			-->
			 <div class="mb-3">
              <label for="num_control" class="form-label"><b>Formaci&oacute;n:</b></label>
			<select class="form-control" id="especialidad" name="especialidad" required>
    <option value="ADMINISTRACION DE EMPRESAS">ADMINISTRACION DE EMPRESAS</option>
    <option value="ARQUITECTURA">ARQUITECTURA</option>
    <option value="BIOLOGIA">BIOLOGIA</option>
    <option value="CIENCIAS DE LA COMPUTACION">CIENCIAS DE LA COMPUTACION</option>
    <option value="CIENCIAS POLITICAS">CIENCIAS POLITICAS</option>
    <option value="CONTADURIA PUBLICA">CONTADURIA PUBLICA</option>
    <option value="DERECHO">DERECHO</option>
    <option value="DISEÑO GRAFICO">DISEÑO GRAFICO</option>
    <option value="EDUCACION">EDUCACION</option>
    <option value="ELECTRONICA">ELECTRONICA</option>
    <option value="ENERGIAS RENOVABLES">ENERGIAS RENOVABLES</option>
    <option value="FISICA">FISICA</option>
    <option value="GASTRONOMIA">GASTRONOMIA</option>
    <option value="INGENIERA EN SISTEMAS COMPUTACIONALES">INGENIERA EN SISTEMAS COMPUTACIONALES</option>
    <option value="INGENIERA EN SISTEMAS GESTION EMPRESARIAL">INGENIERA EN SISTEMAS GESTION EMPRESARIAL</option>
    <option value="INGENIERIA">INGENIERIA</option>
    <option value="INGENIERIA DE SOFTWARE">INGENIERIA DE SOFTWARE</option>
    <option value="INTELIGENCIA ARTIFICIAL">INTELIGENCIA ARTIFICIAL</option>
    <option value="MATEMATICAS APLICADAS">MATEMATICAS APLICADAS</option>
    <option value="MECANICA">MECANICA</option>
    <option value="MEDICINA">MEDICINA</option>
    <option value="MERCADOTECNIA">MERCADOTECNIA</option>
    <option value="PEDAGOGIA">PEDAGOGIA</option>
    <option value="PSICOLOGIA">PSICOLOGIA</option>
    <option value="QUIMICA">QUIMICA</option>
    <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
    <option value="RELACIONES INTERNACIONALES">RELACIONES INTERNACIONALES</option>
    <option value="SISTEMAS COMPUTACIONALES">SISTEMAS COMPUTACIONALES</option>
    <option value="TURISMO">TURISMO</option>
</select>
</div>

            <!--
            <div class="mb-3">
  <label for="idcarrera" class="form-label"><b>Carrera:</b></label>
  <select class="form-control" id="idcarrera" name="idcarrera" required>
    <option value="">SELECCIONE UNA CARRERA</option>
  </select>
</div>
-->

            <button type="submit" class="btn btn-success">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Código del modal ya incluido en la pregunta -->
  <!-- Modal para editar Alumno -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Alumn@</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_tutor" name="id_tutor">
                    <div class="mb-3">
                        <label for="nombreEditar" class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" id="nombreEditar" name="nombre" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidopEditar" class="form-label"><b>Apellido Paterno:</b></label>
                        <input type="text" class="form-control" id="apellidopEditar" name="apellidop" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidomEditar" class="form-label"><b>Apellido Materno:</b></label>
                        <input type="text" class="form-control" id="apellidomEditar" name="apellidom" style="text-transform: uppercase;" required>
                    </div>
					<div class="mb-3">
                        <label for="curpEditar" class="form-label"><b>CURP:</b></label>
                        <input type="text" class="form-control" id="curpEditar" name="curp" style="text-transform: uppercase;" required>
                    </div>
					<div class="mb-3">
                        <label for="sexoEditar" class="form-label"><b>G&eacute;nero:</b></label>
                        <select class="form-control" id="sexoEditar" name="sexo" required>
                            <option value="HOMBRE">HOMBRE</option>
                            <option value="MUJER">MUJER</option>
                        </select>
                    </div>
					<div class="mb-3">
                        <label for="celularEditar" class="form-label"><b>Celular:</b></label>
                        <input type="number" class="form-control" id="celularEditar" name="celular" required>
                    </div>
                    <div class="mb-3">
                        <label for="correoEditar" class="form-label"><b>Correo:</b></label>
                        <input type="email" class="form-control" id="correoEditar" name="correo" required>
                    </div>
					
					<div class="mb-3">
              <label for="tituloEditar" class="form-label"><b>T&iacute;tulo:</b></label>
              <input type="text" class="form-control" id="tituloEditar" name="tituloEditar" style="text-transform: uppercase;" placeholder="Ejemplo: Ing., Lic., Dr." required>
            </div>
			
			<div class="mb-3">
              <label for="especialidadEditar" class="form-label"><b>Formaci&oacute;n:</b></label>
			<select class="form-control" id="especialidadEditar" name="especialidadEditar" required>
    <option value="ADMINISTRACION DE EMPRESAS">ADMINISTRACION DE EMPRESAS</option>
    <option value="ARQUITECTURA">ARQUITECTURA</option>
    <option value="BIOLOGIA">BIOLOGIA</option>
    <option value="CIENCIAS DE LA COMPUTACION">CIENCIAS DE LA COMPUTACION</option>
    <option value="CIENCIAS POLITICAS">CIENCIAS POLITICAS</option>
    <option value="CONTADURIA PUBLICA">CONTADURIA PUBLICA</option>
    <option value="DERECHO">DERECHO</option>
    <option value="DISEÑO GRAFICO">DISEÑO GRAFICO</option>
    <option value="EDUCACION">EDUCACION</option>
    <option value="ELECTRONICA">ELECTRONICA</option>
    <option value="ENERGIAS RENOVABLES">ENERGIAS RENOVABLES</option>
    <option value="FISICA">FISICA</option>
    <option value="GASTRONOMIA">GASTRONOMIA</option>
    <option value="INGENIERA EN SISTEMAS COMPUTACIONALES">INGENIERA EN SISTEMAS COMPUTACIONALES</option>
    <option value="INGENIERA EN SISTEMAS GESTION EMPRESARIAL">INGENIERA EN SISTEMAS GESTION EMPRESARIAL</option>
    <option value="INGENIERIA">INGENIERIA</option>
    <option value="INGENIERIA DE SOFTWARE">INGENIERIA DE SOFTWARE</option>
    <option value="INTELIGENCIA ARTIFICIAL">INTELIGENCIA ARTIFICIAL</option>
    <option value="MATEMATICAS APLICADAS">MATEMATICAS APLICADAS</option>
    <option value="MECANICA">MECANICA</option>
    <option value="MEDICINA">MEDICINA</option>
    <option value="MERCADOTECNIA">MERCADOTECNIA</option>
    <option value="PEDAGOGIA">PEDAGOGIA</option>
    <option value="PSICOLOGIA">PSICOLOGIA</option>
    <option value="QUIMICA">QUIMICA</option>
    <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
    <option value="RELACIONES INTERNACIONALES">RELACIONES INTERNACIONALES</option>
    <option value="SISTEMAS COMPUTACIONALES">SISTEMAS COMPUTACIONALES</option>
    <option value="TURISMO">TURISMO</option>
</select>
</div>
                    
                    <!--
                    <div class="mb-3">
                        <label for="num_controlEditar" class="form-label"><b>N&uacute;mero de Control:</b></label>
                        <input type="text" class="form-control" id="num_controlEditar" name="num_control" style="text-transform: uppercase;" required>
                    </div>
                    -->
					<!--
                    <div class="mb-3">
                        <label for="idcarreraEditar" class="form-label"><b>Carrera:</b></label>
                        <select class="form-control" id="idcarreraEditar" name="idcarrera" required>
                            <option value="">SELECCIONE UNA CARRERA</option>
                            
                        </select>
                    </div>
					-->
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FORM PARA CREAR LA CUENTA DE USUARIO-->
<!-- Botón para abrir el modal -->


<!-- -->

  
<script>
//ESTE SCRIPT CARGA LAS CARRERAS EN EL COMBO 
/*
	function cargarCarreras() {
  axios.get('cat_alumnos/carreras.php')
    .then(response => {
      const carreras = response.data;

      if (carreras.error) {
        alertaPersonalizada('danger', carreras.error);
        return;
      }

      const carreraSelect = document.getElementById('idcarrera');
      carreraSelect.innerHTML = '<option value="">SELECCIONE UNA CARRERA</option>'; // Limpiamos las opciones previas

      carreras.forEach(carrera => {
        const option = document.createElement('option');
        option.value = carrera.idcarrera;
        option.textContent = carrera.nombre_carrera;
        carreraSelect.appendChild(option);
      });
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar las carreras: ' + error.message);
    });
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', cargarCarreras);
*/
</script>

  <script>
  /*
function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Construir la URL con los parámetros
	const url = `add_user.php?idalumno=${encodeURIComponent(idAlumno)}&nombre=${encodeURIComponent(nombre)}&apellidop=${encodeURIComponent(apellidoP)}&apellidom=${encodeURIComponent(apellidoM)}&correo=${encodeURIComponent(correo)}&celular=${encodeURIComponent(celular)}`;
//alert(url);
    // Redirigir al archivo con los parámetros
    window.location.href = url;
}
*/
function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Verificar si el alumno ya tiene una cuenta
    axios.post('cat_tutoresacademicos/tutores_academicos.php', new URLSearchParams({
        action: 'verificarcuenta',
        correo: correo,
        idperfil: 7 // ID del perfil "tutor academico"
    }))
    .then(function (response) {
        if (response.data.success) {
            // Alumno ya tiene cuenta, detener el flujo
            swal("¡Atención!", response.data.message, "info");
            return; // Detener aquí
        } 
        
        // Alumno no tiene cuenta, proceder a la creación
        const url = `add_user_tutordual.php?idalumno=${encodeURIComponent(idAlumno)}&nombre=${encodeURIComponent(nombre)}&apellidop=${encodeURIComponent(apellidoP)}&apellidom=${encodeURIComponent(apellidoM)}&correo=${encodeURIComponent(correo)}&celular=${encodeURIComponent(celular)}`;
        window.location.href = url; // Redirigir al archivo
    })
    .catch(function (error) {
        // Manejo del error en la solicitud
        console.error('Error en la solicitud:', error);
        swal("¡Error!", "Error al conectar con el servidor.", "error");
    });
}



    function alertaPersonalizada(tipo, mensaje) {
      const alerta = document.createElement('div');
      alerta.classList.add('alert', 'alert-' + tipo, 'alert-custom');
      alerta.innerHTML = mensaje;
      document.body.appendChild(alerta);
      setTimeout(() => {
        alerta.remove();
      }, 3000);
    }

    // Filtrar tabla
	
    function filtrarTabla() {
      const busqueda = document.getElementById('buscador').value.toLowerCase();
      const filas = document.querySelectorAll('#tablaAlumnos tr');
      filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(busqueda)) {
          fila.style.display = '';
        } else {
          fila.style.display = 'none';
        }
      });
    }
	/*
	
*/
function filtrarCards() {
  const busqueda = document.getElementById('buscador').value.toLowerCase();
  const cards = document.querySelectorAll('.row .col-md-4'); // Selecciona todas las columnas que contienen cards
  let cantidadVisible = 0;

  cards.forEach(card => {
    const textoCard = card.textContent.toLowerCase(); // Obtiene el texto de la tarjeta
    if (textoCard.includes(busqueda)) {
      card.style.display = ''; // Muestra la tarjeta si coincide
      cantidadVisible++; // Incrementa el contador si la tarjeta es visible
    } else {
      card.style.display = 'none'; // Oculta la tarjeta si no coincide
    }
  });

  // Actualiza el label con la cantidad de tarjetas visibles
  document.getElementById('cantidadRegistros').textContent = `Cantidad de registros: ${cantidadVisible}`;

  // Si no hay resultados visibles, muestra la alerta
  if (cantidadVisible === 0) {
    swal("¡Resultado!", "Ningún registro coincide con la búsqueda", "warning");
  }
}

	
	
    // Editar alumno
    // Función para editar el alumno
function editarAlumno(id) {
	//alert("El id Tut@r es: " + id);
  axios.post('cat_tutoresacademicos/tutores_academicos.php', new URLSearchParams({
    action: 'obtenerTutor',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const alumno = response.data.alumno;
      const carreras = response.data.carreras;

      document.getElementById('id_tutor').value = alumno.idtutor_academico;
      document.getElementById('nombreEditar').value = alumno.nombre_tutor;
	  //document.getElementById('nombreEditar').value = decodeURIComponent(escape(alumno.nombre_tutor));
	  /*
	  const utf8Text = decodeURIComponent(escape(alumno.nombre_tutor));
	  document.getElementById('nombreEditar').value =utf8Text;
	  */
      document.getElementById('apellidopEditar').value = alumno.apellido_paterno;
      document.getElementById('apellidomEditar').value = alumno.apellido_materno;
      document.getElementById('correoEditar').value = alumno.email;
      document.getElementById('curpEditar').value = alumno.curp;
      document.getElementById('sexoEditar').value = alumno.sexo;
      
      document.getElementById('celularEditar').value = alumno.num_celular;
	  document.getElementById('tituloEditar').value = alumno.titulo_academico;
      document.getElementById('especialidadEditar').value = alumno.especialidad;

      // Llenar el select de carreras
	  /*
      const carreraSelect = document.getElementById('especialidadEditar');
      carreraSelect.innerHTML = ''; // Limpiar las opciones existentes

      carreras.forEach(function(carrera) {
        const option = document.createElement('option');
        option.value = carrera.idcarrera;
        option.textContent = carrera.nombre_carrera;

        if (carrera.idcarrera == alumno.idcarrera) {
          option.selected = true;
        }

        carreraSelect.appendChild(option);
      });
	  */
	  // Variable con el valor a seleccionar
const valorSeleccionado = alumno.especialidad;
//alert("La especialidad es: " + valorSeleccionado);
// Referencia al elemento select
const carreraSelect = document.getElementById('especialidadEditar');

// Establecer la opción seleccionada
carreraSelect.value = valorSeleccionado;

// Opcional: Verifica si se seleccionó correctamente
console.log(carreraSelect.value);
console.log(valorSeleccionado);
if (carreraSelect.value === valorSeleccionado) {
    console.log("Opción seleccionada correctamente:", carreraSelect.value);
} else {
    console.error("El valor no coincide con ninguna opción.");
}

      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener el Tut@r.", "error");
    }
  })
  .catch(function (error) {
    console.error('Error en la solicitud:', error);
    //alert('Error al conectar con el servidor.');
	 swal("¡Error!", "Error al conectar con el servidor.", "error");
  });
}

// Enviar los datos del formulario de edición
document.getElementById('formEditar').addEventListener('submit', function (e) {
  e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

  // Obtener el id del alumno
  const id = document.getElementById('id_tutor').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id', id); // Añadir el id del alumno al FormData
  formData.append('titulo', document.getElementById('tituloEditar').value); // Campo título
  formData.append('especialidad', document.getElementById('especialidadEditar').value); // Campo especialidad

  axios.post('cat_tutoresacademicos/tutores_academicos.php', formData)
  .then(function (response) {
	  alert(response);
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Tut@r actualizado correctamente", "success")
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                            modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
	  
	  /*
	  */
	  
	  
	  
	  
    } else {
     // alert('No se pudo actualizar el alumno.');
	  swal("¡Error!", "No se pudo actualizar al Tut@r." + response.data.message, "error");
    }
  })
  .catch(function (error) {
    console.error('Error en la solicitud:', error);
    //alert('Error al conectar con el servidor.');
	swal("¡Error!", "Error al conectar con el servidor.", "error");
  });
});



    // Eliminar alumno
	
// Función para eliminar un alumno
function eliminarAlumno(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_tutoresacademicos/tutores_academicos.php', new URLSearchParams({
            action: 'eliminar',
            id: id
        }))
        .then(response => {
            // Manejar la respuesta del servidor
            if (response.data.success) {
				//#####
				/*
                
				*/
				//##########
				
				/*
				*/
				alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El Tut@r ha sido eliminado correctamente", "success")
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            //const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                            //modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
				/**/
				
				
            } else {
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el Tut@r');
				swal("¡Error!", response.data.message || 'Error al eliminar el Tut@r', "error");
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alertaPersonalizada('danger', 'Error al conectar con el servidor.');
			swal("¡Error!", "Error al conectar con el servidor.", "error");
        });
  } else {
    // Acciones si el usuario cancela
    console.log("Cancelado");
  }
});


	
    
}


  </script>
  
  
  <script>
        // Cargar carreras y manejar el formulario al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        //cargarCarreras(); // Llenar el select con las carreras disponibles

        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
			
			

            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_tutoresacademicos/tutores_academicos.php', new URLSearchParams({
                action: 'agregar',
                nombre: formData.get('nombre'),
                apellidop: formData.get('apellidop'),
                apellidom: formData.get('apellidom'),
				sexo: formData.get('sexo'),
				celular: formData.get('celular'),
                correo: formData.get('correo'),
                titulo: formData.get('titulo'),
				curp: formData.get('curp'),
                especialidad: formData.get('especialidad')
            }))
			//alert("llega aqui");
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El Tut@r se ha agregado correctamente", "success")
					
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
                            modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
                } else {
                    //alertaPersonalizada('danger', response.data.message || 'Error al agregar el alumno.');
					swal("¡Error!", response.data.message, "error");

                }
            })
            .catch(function (error) {
                console.error('Error en la solicitud:', error);
                alertaPersonalizada('danger', 'Error al conectar con el servidor.');
            });
        });
    });
        

        // Función para mostrar alertas personalizadas
        function alertaPersonalizada(tipo, mensaje) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${tipo}`;
            alertDiv.textContent = mensaje;
            document.body.prepend(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000); // Quitar alerta después de 3 segundos
        }
    </script>
	
</body>
</html>
