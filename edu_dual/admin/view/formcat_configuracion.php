<?php include('cat_configuracion/configuracion.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Director</title>
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
       

  
</div>


    <!--cards begin -->
<div class="row">
  <?php
  $configuracion = cargarConfiguracion();
  $totalRegistros = count($configuracion); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  
</script>
  <?php
  foreach ($configuracion as $configuraciones) {
    

    
    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$configuraciones['nombre_director']} </b></h5>";

    
    
    echo "<button class='btn btn-warning' onclick='editarConfiguracion({$configuraciones['id_configuracion']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";

  

    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  ?>
</div>



	<!-- cards end-->
  </div>


  <!-- Código del modal ya incluido en la pregunta -->
  <!-- Modal para editar Alumno -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Director</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_configuracion" name="id_configuracion">
                    <div class="mb-3">
                        <label for="nombre_directorEditar" class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" id="nombre_directorEditar" name="nombre_director" style="text-transform: uppercase;" required>
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



    // Editar alumno
    // Función para editar el alumno
function editarConfiguracion(id) {
  axios.post('cat_configuracion/configuracion.php', new URLSearchParams({
    action: 'obtenerConfiguracion',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const configuracion = response.data.configuracion;
    
      document.getElementById('id_configuracion').value = configuracion.id_configuracion;
      document.getElementById('nombre_directorEditar').value = configuracion.nombre_director;

     
      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener la asignatura.", "error");
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
  const id = document.getElementById('id_configuracion').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_configuracion', id); // Añadir el id del alumno al FormData

  axios.post('cat_configuracion/configuracion.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Nombre del director actualizado correctamente", "success")
                    .then(() => {
                        // Esperar 3 segundos antes de hacer la recarga
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                            modal.hide();
                            location.reload(); // Recargar la página
                        }, 1000); // 3 segundos de espera antes de recargar
                    });
    } else {
     // alert('No se pudo actualizar el alumno.');
	  swal("¡Error!", "No se pudo actualizar la asignatura.", "error");
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


  </script>
  
  
  <script>
        // Cargar carreras y manejar el formulario al cargar la página
    
        

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
