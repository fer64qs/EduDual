<?php include('cat_grupos/grupos.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Grupos</title>
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
  <h4 class="text-center">Catálogo de Grupos</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar Grupo..."
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
  $grupos = cargarGrupos();
  $totalRegistros = count($grupos); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($grupos as $grupo) {
    $icono = 'fa-users'; // Icono predeterminado para grupos
    $color = '#000000'; // Color predeterminado

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$grupo['grupo']} </b></h5>";

    echo "<p class='card-text'>";
    echo "<b>Folio:</b> {$grupo['folio']}<br>";
    echo "<b>Carrera:</b> {$grupo['nombre_carrera']}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarGrupo({$grupo['idGrupo']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarGrupo({$grupo['idGrupo']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  ?>
</div>



	<!-- cards end-->
  </div>

  <!-- Modal para agregar grupo -->
  
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Grupo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="grupo" class="form-label"><b>Nombre del grupo:</b></label>
              <input type="text" class="form-control" id="grupo" name="grupo" style="text-transform: uppercase;" required>
            </div>
            
            <div class="mb-3">
              <label for="folio" class="form-label"><b>Folio:</b></label>
              <input type="number" class="form-control" id="folio" name="folio" required>
            </div>
            <div class="mb-3">
  <label for="idcarrera" class="form-label"><b>Carrera:</b></label>
  <select class="form-control" id="idcarrera" name="idcarrera" required>
    <option value="">SELECCIONE UNA CARRERA</option>
  </select>
</div>

            <button type="submit" class="btn btn-success">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Código del modal ya incluido en la pregunta -->
  <!-- Modal para editar grupo -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_grupo" name="id_grupo">
                    <div class="mb-3">
                        <label for="grupoEditar" class="form-label"><b>Nombre del grupo:</b></label>
                        <input type="text" class="form-control" id="grupoEditar" name="grupo" style="text-transform: uppercase;" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="folioEditar" class="form-label"><b>Folio:</b></label>
                        <input type="number" class="form-control" id="folioEditar" name="folio" required>
                    </div>
                    <div class="mb-3">
                        <label for="idcarreraEditar" class="form-label"><b>Carrera:</b></label>
                        <select class="form-control" id="idcarreraEditar" name="idcarrera" required>
                            <option value="">SELECCIONE UNA CARRERA</option>
                            <!-- Aquí se llenarán las carreras dinámicamente -->
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

	function cargarCarreras() {
  axios.get('cat_grupos/carreras.php')
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

</script>
  <script>
  /*

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
      const filas = document.querySelectorAll('#tablaGrupos tr');
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

function alertaPersonalizada(tipo, mensaje) {
      const alerta = document.createElement('div');
      alerta.classList.add('alert', 'alert-' + tipo, 'alert-custom');
      alerta.innerHTML = mensaje;
      document.body.appendChild(alerta);
      setTimeout(() => {
        alerta.remove();
      }, 3000);
    }
    
    function filtrarTabla() {
      const busqueda = document.getElementById('buscador').value.toLowerCase();
      const filas = document.querySelectorAll('#tablaGrupos tr');
      filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(busqueda)) {
          fila.style.display = '';
        } else {
          fila.style.display = 'none';
        }
      });
    }
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

	
	
    // Editar grupo
  
function editarGrupo(id) {
  axios.post('cat_grupos/grupos.php', new URLSearchParams({
    action: 'obtenerGrupo',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const grupo = response.data.grupo;
      const carreras = response.data.carreras;

      document.getElementById('id_grupo').value = grupo.idGrupo;
      document.getElementById('grupoEditar').value = grupo.grupo;
      document.getElementById('folioEditar').value = grupo.folio;
      
      document.getElementById('idcarreraEditar').value = grupo.idcarrera;

      // Llenar el select de carreras
      const carreraSelect = document.getElementById('idcarreraEditar');
      carreraSelect.innerHTML = ''; // Limpiar las opciones existentes

      carreras.forEach(function(carrera) {
        const option = document.createElement('option');
        option.value = carrera.idcarrera;
        option.textContent = carrera.nombre_carrera;

        if (carrera.idcarrera == grupo.idcarrera) {
          option.selected = true;
        }

        carreraSelect.appendChild(option);
      });

      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el grupo.');
	  swal("¡Error!", "No se pudo obtener el grupo.", "error");
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

  // Obtener el id del grupo
  const id = document.getElementById('id_grupo').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id', id); // Añadir el id del grupo al FormData

  axios.post('cat_grupos/grupos.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('grupo actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Grupo actualizado correctamente", "success")
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
     // alert('No se pudo actualizar el grupo.');
	  swal("¡Error!", "No se pudo actualizar el grupo.", "error");
    }
  })
  .catch(function (error) {
    console.error('Error en la solicitud:', error);
    //alert('Error al conectar con el servidor.');
	swal("¡Error!", "Error al conectar con el servidor.", "error");
  });
});



	
// Función para eliminar un grupo
function eliminarGrupo(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_grupos/grupos.php', new URLSearchParams({
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
                    swal("¡Éxito!", "El grupo ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el grupo');
				swal("¡Error!", response.data.message || 'Error al eliminar el grupo', "error");
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
        cargarCarreras(); // Llenar el select con las carreras disponibles

        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
			
			

            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_grupos/grupos.php', new URLSearchParams({
                action: 'agregar',
                grupo: formData.get('grupo'),
                folio: formData.get('folio'),
               
                idcarrera: formData.get('idcarrera')
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El grupo se ha agregado correctamente", "success")
					
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
                            modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
                } else {
                    //alertaPersonalizada('danger', response.data.message || 'Error al agregar el grupo.');
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
