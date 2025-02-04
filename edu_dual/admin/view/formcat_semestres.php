<?php include('cat_semestres/semestres.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Semestres</title>
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
  <h4 class="text-center">Catálogo de Semestres</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar Semestre..."
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
  $semestres = cargarSemestres();
  $totalRegistros = count($semestres); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($semestres as $semestre) {
    $icono = 'fa-calendar-alt'; // Icono predeterminado para grupos
    $color = '#000000'; // Color predeterminado

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$semestre['semestre']} </b></h5>";

    echo "<p class='card-text'>";
    echo "<b>Fecha de Inicio:</b> {$semestre['fecha_inicio']}<br>";
	echo "<b>Fecha de fin:</b> {$semestre['fecha_fin']}<br>";

    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarSemestre({$semestre['idSemestre']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarSemestre({$semestre['idSemestre']})' style='font-size: 14px;'>
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

  
  <!-- Modal para agregar semestre -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Semestre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="semestre" class="form-label"><b>Semestre:</b></label>
              <input type="text" class="form-control" id="semestre" name="semestre" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="fecha_inicio" class="form-label"><b>Fecha Inicio:</b></label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="fecha_fin" class="form-label"><b>Fecha de fin:</b></label>
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" style="text-transform: uppercase;" required>
            </div>
         

            <button type="submit" class="btn btn-success">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Código del modal ya incluido en la pregunta -->
  <!-- Modal para editar semestre -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Semestre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_Semestre" name="id_Semestre">
                    <div class="mb-3">
                        <label for="semestreEditar" class="form-label"><b>Semestre:</b></label>
                        <input type="text" class="form-control" id="semestreEditar" name="semestre" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inicioEditar" class="form-label"><b>Fecha de inicio:</b></label>
                        <input type="date" class="form-control" id="fecha_inicioEditar" name="fecha_inicio" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_finEditar" class="form-label"><b>Fecha de fin:</b></label>
                        <input type="date" class="form-control" id="fecha_finEditar" name="fecha_fin" style="text-transform: uppercase;" required>
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
      const filas = document.querySelectorAll('#tablaSemestres tr');
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

	

    // Función para editar el semestre
function editarSemestre(id) {
  axios.post('cat_semestres/semestres.php', new URLSearchParams({
    action: 'obtenerSemestre',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const semestre = response.data.semestre;
      

      document.getElementById('id_Semestre').value = semestre.idSemestre;
      document.getElementById('semestreEditar').value = semestre.semestre;
      document.getElementById('fecha_inicioEditar').value = semestre.fecha_inicio;
      document.getElementById('fecha_finEditar').value = semestre.fecha_fin;
      


      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el semestre.');
	  swal("¡Error!", "No se pudo obtener el semestre.", "error");
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

  // Obtener el id del semestre
  const id = document.getElementById('id_Semestre').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_Semestre', id); // Añadir el id del semestre al FormData

  axios.post('cat_semestres/semestres.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('semestre actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Semestre actualizado correctamente", "success")
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
     // alert('No se pudo actualizar el semestre.');
	  swal("¡Error!", "No se pudo actualizar el Semestre.", "error");
    }
  })
  .catch(function (error) {
    console.error('Error en la solicitud:', error);
    //alert('Error al conectar con el servidor.');
	swal("¡Error!", "Error al conectar con el servidor.", "error");
  });
});



    // Eliminar semestre
	

function eliminarSemestre(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_semestres/semestres.php', new URLSearchParams({
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
                    swal("¡Éxito!", "El Semestre ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el semestre');
				swal("¡Error!", response.data.message || 'Error al eliminar el semestre', "error");
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

  
  <script>
        document.addEventListener('DOMContentLoaded', function () {
      
      // Manejar el envío del formulario
      document.getElementById('formAgregar').addEventListener('submit', function (event) {
          event.preventDefault(); // Evitar el envío tradicional del formulario
    
    

          // Obtener datos del formulario
          const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_semestres/semestres.php', new URLSearchParams({
                action: 'agregar',
                semestre: formData.get('semestre'),
                fecha_inicio: formData.get('fecha_inicio'),
                fecha_fin: formData.get('fecha_fin'),
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El semestre se ha agregado correctamente", "success")
					
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
                            modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
                } else {
                    //alertaPersonalizada('danger', response.data.message || 'Error al agregar el semestre.');
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
