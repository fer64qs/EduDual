<?php include('cat_inscripciones/inscripciones.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Inscripcion</title>
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
  <h4 class="text-center">Inscripcion De Educacion Dual: </h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar..."
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
  $inscripciones = cargarInscripcion();
  $totalRegistros = count($inscripciones); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>



  <?php
  foreach ($inscripciones as $inscripcion) {
    $icono = 'fa-building';
    $color = 'black'; 

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$inscripcion['nombre']} {$inscripcion['apellidop']} {$inscripcion['apellidom']}</b></h5>";

    echo "<p class='card-text'>";
    echo "<b>Tutor Academico:</b> {$inscripcion['nombre_tutor']} {$inscripcion['apellido_paterno']} {$inscripcion['apellido_materno']}<br>";
    echo "<b>Tutor Personal:</b> {$inscripcion['nombre_personal']} {$inscripcion['papellido_paterno']} {$inscripcion['papellido_materno']}<br>";
    echo "<b>Empresa:</b> {$inscripcion['nombre_empresa']}<br>";
    echo "<b>Ciclo Escolar:</b> {$inscripcion['semestre']}<br>";
    echo "<b>Fecha de Inicio:</b> {$inscripcion['fecha_inicio']}<br>";
    echo "<b>Fecha de Fin:</b> {$inscripcion['fecha_fin']}<br>";
    echo "<b>Estatus:</b> {$inscripcion['estatus']}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarInscripcion({$inscripcion['idinscripcion']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
          
    echo "<button class='btn btn-danger' onclick='eliminarInscripcion({$inscripcion['idinscripcion']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    
    echo "<button class='btn btn-info' onclick='redirigirBitacora({$inscripcion['idinscripcion']})' style='font-size: 14px;'>
          <i class='fas fa-calendar-alt'></i> Crono
          </button>";

    echo "<button class='btn btn-info' onclick='redirigirOficio({$inscripcion['idinscripcion']})' style='font-size: 14px;'>
          <i class='fas fa-calendar-alt'></i> Oficio
          </button>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  ?>
</div>



	<!-- cards end-->
     	
  </div>
<!-- HACER LA INSCRIPCION -->


  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Inscripcion:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
          <div class="mb-3">
            <label for="idalumno" class="form-label"><b>Alumno:</b></label>
            <select class="form-control" id="idalumno" name="idalumno" required>
            <option value="">SELECCIONE UN ALUMNO</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idempresa" class="form-label"><b>Empresa:</b></label>
            <select class="form-control" id="idempresa" name="idempresa" required>
            <option value="">SELECCIONE UNA EMPRESA</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idpersonal" class="form-label"><b>Asesor Dual:</b></label>
            <select class="form-control" id="idpersonal" name="idpersonal" required>
            <option value="">SELECCIONE UN ASESOR DEL PERSONAL DE LA EMPRESA</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idtutor_academico" class="form-label"><b>Tutor Academico:</b></label>
            <select class="form-control" id="idtutor_academico" name="idtutor_academico" required>
            <option value="">SELECCIONE UN TUTOR ACADEMICO</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idSemestre" class="form-label"><b>Ciclo Escolar:</b></label>
            <select class="form-control" id="idSemestre" name="idSemestre" required>
            <option value="">SELECCIONE UN CICLO ESCOLAR</option>
            </select>
            </div>
            <div class="mb-3">
              <label for="fecha_inicio" class="form-label"><b>Fecha Inicio:</b></label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="fecha_fin" class="form-label"><b>Fecha de fin:</b></label>
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="estatus" class="form-label"><b>Estatus:</b></label>
              <select class="form-control" id="estatus" name="estatus" required>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          

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
                <h5 class="modal-title" id="modalEditarLabel">Editar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="formEditar">
            <input type="hidden" id="id_inscripcion" name="id_inscripcion">
            <div class="mb-3">
            <label for="idalumnoEditar" class="form-label"><b>Alumno:</b></label>
            <select class="form-control" id="idalumnoEditar" name="idalumno" required>
            <option value="">SELECCIONE UN ALUMNO</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idempresaEditar" class="form-label"><b>Empresa:</b></label>
            <select class="form-control" id="idempresaEditar" name="idempresa" required>
            <option value="">SELECCIONE UNA EMPRESA</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idpersonalEditar" class="form-label"><b>Asesor del personal de la empresa:</b></label>
            <select class="form-control" id="idpersonalEditar" name="idpersonal" required>
            <option value="">SELECCIONE AL PERSONAL DE LA EMPRESA</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idtutor_academicoEditar" class="form-label"><b>Tutor academico:</b></label>
            <select class="form-control" id="idtutor_academicoEditar" name="idtutor_academico" required>
            <option value="">SELECCIONE UN TUTOR ACADEMICO</option>
            </select>
            </div>
            <div class="mb-3">
            <label for="idSemestreEditar" class="form-label"><b>Ciclo Escolar:</b></label>
            <select class="form-control" id="idSemestreEditar" name="idSemestre" required>
            <option value="">SELECCIONE UN CICLO ESCOLAR</option>
            </select>
            </div>
            <div class="mb-3">
              <label for="fecha_inicioEditar" class="form-label"><b>Fecha Inicio:</b></label>
              <input type="date" class="form-control" id="fecha_inicioEditar" name="fecha_inicio" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="fecha_finEditar" class="form-label"><b>Fecha de fin:</b></label>
              <input type="date" class="form-control" id="fecha_finEditar" name="fecha_fin" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="estatusEditar" class="form-label"><b>Estatus:</b></label>
              <select class="form-control" id="estatusEditar" name="estatus" required>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
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
    function cargarAlumnos() {
  axios.get('cat_inscripciones/alumnos.php')
    .then(response => {
      const alumnos = response.data;

      if (alumnos.error) {
        alertaPersonalizada('danger', alumnos.error);
        return;
      }

      const alumnoSelect = document.getElementById('idalumno');
      alumnoSelect.innerHTML = '<option value="">SELECCIONE UN ALUMNO</option>'; // Limpiamos las opciones previas

      alumnos.forEach(alumno => {
        const option = document.createElement('option');
        option.value = alumno.idalumno;
        option.textContent = alumno.nombre + " " + alumno.apellidop + " " + alumno.apellidom;
        alumnoSelect.appendChild(option);
      });
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar el alumno: ' + error.message);
    });
}
    function cargarEmpresas() {
  axios.get('cat_inscripciones/empresas.php')
    .then(response => {
      const empresas = response.data;

      if (empresas.error) {
        alertaPersonalizada('danger', empresas.error);
        return;
      }

      const empresaSelect = document.getElementById('idempresa');
      empresaSelect.innerHTML = '<option value="">SELECCIONE UNA EMPRESA</option>'; // Limpiamos las opciones previas

      empresas.forEach(empresa => {
        const option = document.createElement('option');
        option.value = empresa.idempresa;
        option.textContent = empresa.nombre_empresa;
        empresaSelect.appendChild(option);
      });
      empresaSelect.addEventListener('change', cargarPersonales);
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar las empresas: ' + error.message);
    });
}
function cargarPersonales() {
  axios.get('cat_inscripciones/personal_empresas.php')
    .then(response => {
      const personales = response.data;

      if (personales.error) {
        alertaPersonalizada('danger', personales.error);
        return;
      }

      const personalSelect = document.getElementById('idpersonal');
      personalSelect.innerHTML = '<option value="">SELECCIONE UN TUTOR</option>'; // Limpiamos las opciones previas

      personales.forEach(personal => {
        const option = document.createElement('option');
        option.value = personal.idpersonal;
        option.textContent = personal.nombre_personal + " " + personal.papellido_paterno + " " + personal.papellido_materno;
        personalSelect.appendChild(option);
      });
     
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar al personal: ' + error.message);
    });
}

function cargarTutores() {
  axios.get('cat_inscripciones/tutores_academicos.php')
    .then(response => {
      const tutores = response.data;

      if (tutores.error) {
        alertaPersonalizada('danger', tutores.error);
        return;
      }

      const tutorSelect = document.getElementById('idtutor_academico');
      tutorSelect.innerHTML = '<option value="">SELECCIONE UN TUTOR</option>'; // Limpiamos las opciones previas

      tutores.forEach(tutor => {
        const option = document.createElement('option');
        option.value = tutor.idtutor_academico;
        option.textContent = tutor.nombre_tutor + " " + tutor.apellido_paterno + " " + tutor.apellido_materno;
        tutorSelect.appendChild(option);
      });
     
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar al Tutor: ' + error.message);
    });
}

function cargarSemestre() {
  axios.get('cat_inscripciones/semestres.php')
    .then(response => {
      const semestres = response.data;

      if (semestres.error) {
        alertaPersonalizada('danger', semestres.error);
        return;
      }

      const semestreSelect = document.getElementById('idSemestre');
      semestreSelect.innerHTML = '<option value="">SELECCIONE UN CURSO ESCOLAR</option>'; // Limpiamos las opciones previas

      semestres.forEach(semestre => {
        const option = document.createElement('option');
        option.value = semestre.idSemestre;
        option.textContent = semestre.semestre;
        semestreSelect.appendChild(option);
      });
     
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar las carreras: ' + error.message);
    });
}

    




	

// Llamar a la función al cargar la página

document.addEventListener('DOMContentLoaded', cargarAlumnos);
document.addEventListener('DOMContentLoaded', cargarEmpresas);
document.addEventListener('DOMContentLoaded', cargarPersonales);
document.addEventListener('DOMContentLoaded', cargarTutores);
document.addEventListener('DOMContentLoaded', cargarSemestre);
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
function redirigirBitacora(idinscripcion) {
    // Construir la URL con los parámetros necesarios
    const url = `bitacora.php?idinscripcion=${encodeURIComponent(idinscripcion)}`;
    
    // Redirigir a bitacora.php
    window.location.href = url;
}

function redirigirBitacora(idinscripcion) {
    // Construir la URL con los parámetros necesarios
    const url = `bitacora.php?idinscripcion=${encodeURIComponent(idinscripcion)}`;
    
    // Redirigir a bitacora.php
    window.location.href = url;
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
    function editarInscripcion(id) {
  axios.post('cat_inscripciones/inscripciones.php', new URLSearchParams({
    action: 'obtenerInscripcion',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const inscripcion = response.data.inscripcion;
      const alumnos = response.data.alumnos;
      const empresas = response.data.empresas;
      const personales = response.data.personales;
      const tutores = response.data.tutores;
      const semestres = response.data.semestres;

      // Llenar los campos con los datos actuales
      document.getElementById('id_inscripcion').value = inscripcion.idinscripcion;
      document.getElementById('idalumnoEditar').value = inscripcion.idalumno;
      document.getElementById('idempresaEditar').value = inscripcion.idempresa;
      document.getElementById('idpersonalEditar').value = inscripcion.idpersonal;
      document.getElementById('idtutor_academicoEditar').value = inscripcion.idtutor_academico;
      document.getElementById('idSemestreEditar').value = inscripcion.idSemestre;
      document.getElementById('fecha_inicioEditar').value = inscripcion.fecha_inicio;
      document.getElementById('fecha_finEditar').value = inscripcion.fecha_fin;
      document.getElementById('estatusEditar').value = inscripcion.estatus;
      
      const alumnoSelect = document.getElementById('idalumnoEditar');
      alumnoSelect.innerHTML = ''; // Limpiar las opciones existentes

      alumnos.forEach(function(alumno) {
        const option = document.createElement('option');
        option.value = alumno.idalumno;
        option.textContent = alumno.nombre + " " + alumno.apellidop + " " + alumno.apellidom;

        if (alumno.idalumno == inscripcion.idalumno) {
          option.selected = true;
        }

        alumnoSelect.appendChild(option);
      });

      const empresaSelect = document.getElementById('idempresaEditar');
      empresaSelect.innerHTML = ''; // Limpiar las opciones existentes

      empresas.forEach(function(empresa) {
        const option = document.createElement('option');
        option.value = empresa.idempresa;
        option.textContent = empresa.nombre_empresa;

        if (empresa.idempresa == inscripcion.idempresa) {
          option.selected = true;
        }

        empresaSelect.appendChild(option);
      });
      const personalSelect = document.getElementById('idpersonalEditar');
      personalSelect.innerHTML = '';

      personales.forEach(function(personal) {
        const option = document.createElement('option');
        option.value = personal.idpersonal;
        option.textContent = personal.nombre_personal + " " + personal.papellido_paterno + " " + personal.papellido_materno;

        if(personal.idpersonal == inscripcion.idpersonal) {
            option.selected = true;
        }
        personalSelect.appendChild(option);
      });
      const tutorSelect = document.getElementById('idtutor_academicoEditar');
      tutorSelect.innerHTML = '';

      tutores.forEach(function(tutor) {
        const option = document.createElement('option');
        option.value = tutor.idtutor_academico;
        option.textContent = tutor.nombre_tutor + " " + tutor.apellido_paterno + " " + tutor.apellido_materno;

        if(tutor.idpersonal == inscripcion.idtutor_academico) {
            option.selected = true;
        }
        tutorSelect.appendChild(option);
      });
      const semestreSelect = document.getElementById('idSemestreEditar');
      semestreSelect.innerHTML = '';

      semestres.forEach(function(semestre) {
        const option = document.createElement('option');
        option.value = semestre.idSemestre;
        option.textContent = semestre.semestre;

        if(semestre.idSemestre == inscripcion.idSemestre) {
            option.selected = true;
        }
        semestreSelect.appendChild(option);
      });
      


      
      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener el alumno.", "error");
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
  const id = document.getElementById('id_inscripcion').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_inscripcion', id); // Añadir el id del alumno al FormData

  axios.post('cat_inscripciones/inscripciones.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Alumno actualizado correctamente", "success")
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
	  swal("¡Error!", "No se pudo actualizar el alumno.", "error");
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
function eliminarInscripcion(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_inscripciones/inscripciones.php', new URLSearchParams({
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
                    swal("¡Éxito!", "El alumno ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el alumno');
				swal("¡Error!", response.data.message || 'Error al eliminar el alumno', "error");
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
        cargarAlumnos();
        cargarEmpresas();
        cargarPersonales();
        cargarTutores();
        cargarSemestre();

        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
			
			

            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_inscripciones/inscripciones.php', new URLSearchParams({
                action: 'agregar',
                fecha_inicio: formData.get('fecha_inicio'),
                fecha_fin: formData.get('fecha_fin'),
                estatus: formData.get('estatus'),
                idalumno: formData.get('idalumno'),
                idempresa: formData.get('idempresa'),
                idpersonal: formData.get('idpersonal'),
                idtutor_academico: formData.get('idtutor_academico'),
                idSemestre: formData.get('idSemestre')
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "La inscripcion se ha realizado correctamente", "success")
					
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
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener los elementos de fecha
        let fechaInicio = document.getElementById("fecha_inicioEditar");
        let fechaFin = document.getElementById("fecha_finEditar");
        

        // Agregar evento para validar la fecha de fin
        fechaInicio.addEventListener("change", validarFechas);
        fechaFin.addEventListener("change", validarFechas);

        function validarFechas() {
            let inicio = new Date(fechaInicio.value);
            let fin = new Date(fechaFin.value);

            if (inicio && fin && fin < inicio) {
                alert("La fecha de fin no puede ser menor que la fecha de inicio.");
                fechaFin.value = ""; // Borra la fecha de fin si es inválida
            }
        }
    });
    
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener los elementos de fecha
        let fechaInicio = document.getElementById("fecha_inicio");
        let fechaFin = document.getElementById("fecha_fin");
        

        // Agregar evento para validar la fecha de fin
        fechaInicio.addEventListener("change", validarFechas);
        fechaFin.addEventListener("change", validarFechas);

        function validarFechas() {
            let inicio = new Date(fechaInicio.value);
            let fin = new Date(fechaFin.value);

            if (inicio && fin && fin < inicio) {
                alert("La fecha de fin no puede ser menor que la fecha de inicio.");
                fechaFin.value = ""; // Borra la fecha de fin si es inválida
            }
        }
    });
</script>

	
</body>
</html>
