<?php include('cat_planteles/planteles.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Planteles</title>
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
  <h4 class="text-center">Catálogo de Planteles</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar planteles..."
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
  $planteles = cargarPlanteles();
  $totalRegistros = count($planteles); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($planteles as $plantel) {
    $icono = 'fas fa-school';
    $color = 'black'; // Puedes cambiar el color si lo deseas

    
    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$plantel['nombre_plantel']} </b></h5>";

    
    echo "<b>Nombre:</b> {$plantel['nombre_plantel']}<br>";
    echo "<b>Ubicacion:</b> {$plantel['ubicacion_plantel']}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarPlantel({$plantel['idplantel']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarPlantel({$plantel['idplantel']})' style='font-size: 14px;'>
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

  <!-- Modal para agregar alumno -->
  <!-- Modal para agregar alumno -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Plantel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="nombre_plantel" class="form-label"><b>Nombre:</b></label>
              <input type="text" class="form-control" id="nombre_plantel" name="nombre_plantel" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="ubicacion_plantel" class="form-label"><b>Ubicacion Plantel:</b></label>
              <input type="text" class="form-control" id="ubicacion_plantel" name="ubicacion_plantel" style="text-transform: uppercase;" required>
            </div>
           
            <div class="mb-3">
 
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
                <h5 class="modal-title" id="modalEditarLabel">Editar plantel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_plantel" name="id_plantel">
                    <div class="mb-3">
                        <label for="nombre_plantelEditar" class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" id="nombre_plantelEditar" name="nombre_plantel" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion_plantelEditar" class="form-label"><b>Ubicacion:</b></label>
                        <input type="text" class="form-control" id="ubicacion_plantelEditar" name="ubicacion_plantel" style="text-transform: uppercase;" required>
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
/*
function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Verificar si el alumno ya tiene una cuenta
    axios.post('cat_alumnos/alumnos.php', new URLSearchParams({
        action: 'verificarcuenta',
        correo: correo,
        idperfil: 5 // ID del perfil "Alumno"
    }))
    .then(function (response) {
        if (response.data.success) {
            // Alumno ya tiene cuenta, detener el flujo
            swal("¡Atención!", response.data.message, "info");
            return; // Detener aquí
        } 
        
        // Alumno no tiene cuenta, proceder a la creación
        const url = `add_user.php?idalumno=${encodeURIComponent(idAlumno)}&nombre=${encodeURIComponent(nombre)}&apellidop=${encodeURIComponent(apellidoP)}&apellidom=${encodeURIComponent(apellidoM)}&correo=${encodeURIComponent(correo)}&celular=${encodeURIComponent(celular)}`;
        window.location.href = url; // Redirigir al archivo
    })
    .catch(function (error) {
        // Manejo del error en la solicitud
        console.error('Error en la solicitud:', error);
        swal("¡Error!", "Error al conectar con el servidor.", "error");
    });
}
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

    // Filtrar tabla
	
    function filtrarTabla() {
      const busqueda = document.getElementById('buscador').value.toLowerCase();
      const filas = document.querySelectorAll('#tablaPlanteles tr');
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
function editarPlantel(id) {
  axios.post('cat_planteles/planteles.php', new URLSearchParams({
    action: 'obtenerPlantel',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const plantel = response.data.plantel;
    
      document.getElementById('id_plantel').value = plantel.idplantel;
      document.getElementById('nombre_plantelEditar').value = plantel.nombre_plantel;
      document.getElementById('ubicacion_plantelEditar').value = plantel.ubicacion_plantel;
     
      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener el plantel.", "error");
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
  const id = document.getElementById('id_plantel').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_plantel', id); // Añadir el id del alumno al FormData

  axios.post('cat_planteles/planteles.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "plantel actualizado correctamente", "success")
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
function eliminarPlantel(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_planteles/planteles.php', new URLSearchParams({
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
                    swal("¡Éxito!", "El plantel ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar el plantel');
				swal("¡Error!", response.data.message || 'Error al eliminar el plantel', "error");
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
      
        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
			
			

            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_planteles/planteles.php', new URLSearchParams({
                action: 'agregar',
                nombre_plantel: formData.get('nombre_plantel'),
                ubicacion_plantel: formData.get('ubicacion_plantel'),
               
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "La carrera se ha agregado correctamente", "success")
					
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
