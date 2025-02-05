<?php include('cat_docentes/docentes.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Docentes</title>
  
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
  <h4 class="text-center">Catálogo de Docentes</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar Docente..."
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
  $docentes = cargarDocentes();
  $totalRegistros = count($docentes); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($docentes as $docente) {
    // Procesar datos para asegurar codificación UTF-8
    $nombre_docente = htmlspecialchars(utf8_encode($docente['nombre_docente']));
    $apellido_paterno = htmlspecialchars(utf8_encode($docente['apellido_paterno']));
    $apellido_materno = htmlspecialchars(utf8_encode($docente['apellido_materno']));
    $sexo = htmlspecialchars(utf8_encode($docente['sexo']));
    $rfc = htmlspecialchars(utf8_encode($docente['rfc']));
    $num_celular = htmlspecialchars(utf8_encode($docente['num_celular']));
    $email = htmlspecialchars(utf8_encode($docente['email']));
    $grado_estudios = htmlspecialchars(utf8_encode($docente['grado_estudios']));
    $titulo = htmlspecialchars(utf8_encode($docente['titulo']));

    $icono = ($sexo == 'HOMBRE') ? 'fa-male' : 'fa-female';
    $color = ($sexo == 'HOMBRE') ? 'black' : '#d093b6';

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$nombre_docente} {$apellido_paterno} {$apellido_materno}</b></h5>";

    echo "<p class='card-text'>";
	  echo "<b>RFC:</b> {$rfc}<br>";
    echo "<b>G&eacute;nero:</b> {$sexo}<br>";
    echo "<b>Celular:</b> {$num_celular}<br>";
    echo "<b>Correo:</b> {$email}<br>";
    echo "<b>Título:</b> {$titulo}<br>";
    echo "<b>Grado de estudios:</b> {$grado_estudios}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarAlumno({$docente['iddocente']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarAlumno({$docente['iddocente']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    echo "<button class='btn btn-info' onclick='crearCuenta(\"{$docente['iddocente']}\", \"{$nombre_docente}\", \"{$apellido_paterno}\", \"{$apellido_materno}\", \"{$email}\", \"{$num_celular}\")' style='font-size: 14px;'>
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
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Docente</h5>
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
              <label for="rfc" class="form-label"><b>RFC:</b></label>
              <input type="text" class="form-control" id="rfc" name="rfc" style="text-transform: uppercase;" required>
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

			 <div class="mb-3">
              <label for="estudios" class="form-label"><b>Grado de estudios:</b></label>
			<select class="form-control" id="estudios" name="estudios" required>
      <option value="TECNICO SUPERIOR UNIVERSITARIO">TECNICO SUPERIOR UNIVERSITARIO</option>
      <option value="LICENCIATURA">LICENCIATURA</option>
      <option value="ESPECIALIZACION">ESPECIALIZACION</option>
      <option value="MAESTRIA">MAESTRIA</option>
      <option value="DOCTORADO">DOCTORADO</option>
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
                <h5 class="modal-title" id="modalEditarLabel">Editar Docente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_docente" name="id_docente">
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
                        <label for="rfcEditar" class="form-label"><b>RFC:</b></label>
                        <input type="text" class="form-control" id="rfcEditar" name="rfc" style="text-transform: uppercase;" required>
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
              <input type="text" class="form-control" id="tituloEditar" name="titulo" style="text-transform: uppercase;" placeholder="Ejemplo: Ing., Lic., Dr." required>
            </div>
			
			<div class="mb-3">
              <label for="estudiosEditar" class="form-label"><b>Formaci&oacute;n:</b></label>
			<select class="form-control" id="estudiosEditar" name="estudios" required>
      <option value="TECNICO SUPERIOR UNIVERSITARIO">TECNICO SUPERIOR UNIVERSITARIO</option>
      <option value="LICENCIATURA">LICENCIATURA</option>
      <option value="ESPECIALIZACION">ESPECIALIZACION</option>
      <option value="MAESTRIA">MAESTRIA</option>
      <option value="DOCTORADO">DOCTORADO</option>
</select>
</div>
                    
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


  <script>

function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Verificar si el alumno ya tiene una cuenta
    axios.post('cat_docentes/docentes.php', new URLSearchParams({
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
  axios.post('cat_docentes/docentes.php', new URLSearchParams({
    action: 'obtenerDocente',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const alumno = response.data.alumno;

      document.getElementById('id_docente').value = alumno.iddocente;
      document.getElementById('nombreEditar').value = alumno.nombre_docente;
      document.getElementById('apellidopEditar').value = alumno.apellido_paterno;
      document.getElementById('apellidomEditar').value = alumno.apellido_materno;
      document.getElementById('correoEditar').value = alumno.email;
      document.getElementById('rfcEditar').value = alumno.rfc;
      document.getElementById('sexoEditar').value = alumno.sexo;
      document.getElementById('celularEditar').value = alumno.num_celular;
	    document.getElementById('tituloEditar').value = alumno.titulo;
      document.getElementById('estudiosEditar').value = alumno.grado_estudios;

      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener el docente.", "error");
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
  const id = document.getElementById('id_docente').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id', id); // Añadir el id del alumno al FormData
  formData.append('titulo', document.getElementById('tituloEditar').value); // Campo título
  formData.append('grado_estudios', document.getElementById('estudiosEditar').value); // Campo especialidad

  axios.post('cat_docentes/docentes.php', formData)
  .then(function (response) {
	  alert(response);
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Docente actualizado correctamente", "success")
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
	  swal("¡Error!", "No se pudo actualizar al Docente." + response.data.message, "error");
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
	axios.post('cat_docentes/docentes.php', new URLSearchParams({
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
                    swal("¡Éxito!", "El Docente ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el Docente');
				swal("¡Error!", response.data.message || 'Error al eliminar el Docente', "error");
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
            axios.post('cat_docentes/docentes.php', new URLSearchParams({
                action: 'agregar',
                nombre: formData.get('nombre'),
                apellidop: formData.get('apellidop'),
                apellidom: formData.get('apellidom'),
				        sexo: formData.get('sexo'),
				        celular: formData.get('celular'),
                correo: formData.get('correo'),
                titulo: formData.get('titulo'),
				        rfc: formData.get('rfc'),
                estudios: formData.get('estudios')
            }))
			//alert("llega aqui");
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El Docente se ha agregado correctamente", "success")
					
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
