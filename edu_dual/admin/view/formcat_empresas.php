<?php include('cat_empresas/empresas.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat de Empresas</title>
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
  <h4 class="text-center">Catálogo de Empresas</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar Empresa..."
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
  $empresas = cargarEmpresas();
  $totalRegistros = count($empresas); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($empresas as $empresa) {
    $icono = 'fa-building';
    $color = 'black'; 

    
    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$empresa['nombre_empresa']}  </b></h5>";

    echo "<p class='card-text'>";
    echo "<b>Representante:</b> {$empresa['representante']}<br>";
    echo "<b>RFC:</b> {$empresa['rfc']}<br>";
	echo "<b>Direccion:</b> {$empresa['direccion']}<br>";
    echo "<b>Telefono:</b> {$empresa['telefono']}<br>";
    echo "<b>Email:</b> {$empresa['email']}<br>";
    
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarEmpresa({$empresa['idempresa']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarEmpresa({$empresa['idempresa']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    echo "<button class='btn btn-info' onclick='crearCuenta(\"{$empresa['idempresa']}\", \"{$empresa['nombre_empresa']}\", \"{$empresa['rfc']}\", \"{$empresa['representante']}\", \"{$empresa['email']}\", \"{$empresa['telefono']}\")' style='font-size: 14px;'>
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

  
  <!-- Modal para agregar empresa -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Empresa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="nombre_empresa" class="form-label"><b>Nombre Empresa:</b></label>
              <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" style="text-transform: uppercase;" required>
            </div>
            
            <div class="mb-3">
              <label for="rfc" class="form-label"><b>RFC:</b></label>
              <input type="text" class="form-control" id="rfc" name="rfc" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-3">
              <label for="direccion" class="form-label"><b>Direccion:</b></label>
              <input type="text" class="form-control" id="direccion" name="direccion" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label"><b>Telefono:</b></label>
              <input type="number" class="form-control" id="telefono" name="telefono" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label"><b>Correo:</b></label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="representante" class="form-label"><b>Representante:</b></label>
              <input type="text" class="form-control" id="representante" name="representante" style="text-transform: uppercase;" required>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Código del modal ya incluido en la pregunta -->
  <!-- Modal para editar empresa -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_empresa" name="id_empresa">
                    <div class="mb-3">
                        <label for="nombre_empresaEditar" class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" id="nombre_empresaEditar" name="nombre_empresa" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="rfcEditar" class="form-label"><b>RFC:</b></label>
                        <input type="text" class="form-control" id="rfcEditar" name="rfc" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionEditar" class="form-label"><b>Direccion:</b></label>
                        <input type="text" class="form-control" id="direccionEditar" name="direccion" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefonoEditar" class="form-label"><b>Telefono:</b></label>
                        <input type="number" class="form-control" id="telefonoEditar" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailEditar" class="form-label"><b>Correo:</b></label>
                        <input type="email" class="form-control" id="emailEditar" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="representanteEditar" class="form-label"><b>Representante:</b></label>
                        <input type="text" class="form-control" id="representanteEditar" name="representante" style="text-transform: uppercase;" required>
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
  /*
function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Construir la URL con los parámetros
	const url = `add_user.php?idalumno=${encodeURIComponent(idAlumno)}&nombre=${encodeURIComponent(nombre)}&apellidop=${encodeURIComponent(apellidoP)}&apellidom=${encodeURIComponent(apellidoM)}&correo=${encodeURIComponent(correo)}&celular=${encodeURIComponent(celular)}`;
//alert(url);
    // Redirigir al archivo con los parámetros
    window.location.href = url;
}
*/
function crearCuenta(idEmpresa, nombre_empresa, rfc, representante, email, telefono) {
    axios.post('cat_empresas/empresas.php', new URLSearchParams({
    action: 'verificarcuenta',
    email: email,
    idperfil: 6 // ID del perfil de empresa
}))
.then(function (response) {
    if (response.data.success) {
        swal("¡Atención!", response.data.message, "info");
        return;
    }
    const url = `add_user_empresa.php?idempresa=.php?idempresa=${encodeURIComponent(idEmpresa)}&nombre_empresa=${encodeURIComponent(nombre_empresa)}&representante=${encodeURIComponent(representante)}&rfc=${encodeURIComponent(rfc)}&email=${encodeURIComponent(email)}&telefono=${encodeURIComponent(telefono)}`;
        window.location.href = url;
})
.catch(function (error) {
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
      const filas = document.querySelectorAll('#tablaEmpresa tr');
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
function editarEmpresa(id) {
  axios.post('cat_empresas/empresas.php', new URLSearchParams({
    action: 'obtenerEmpresa',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      
      const empresa = response.data.empresa;

      document.getElementById('id_empresa').value = empresa.idempresa;
      document.getElementById('nombre_empresaEditar').value = empresa.nombre_empresa;
      document.getElementById('rfcEditar').value = empresa.rfc;
      document.getElementById('direccionEditar').value = empresa.direccion;
      document.getElementById('telefonoEditar').value = empresa.telefono;
      document.getElementById('emailEditar').value = empresa.email;
      
      document.getElementById('representanteEditar').value = empresa.representante;
      
      const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    } else {
      //alert('No se pudo obtener el alumno.');
	  swal("¡Error!", "No se pudo obtener la empresa.", "error");
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
  const id = document.getElementById('id_empresa').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_empresa', id); // Añadir el id del alumno al FormData

  axios.post('cat_empresas/empresas.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  //#######anterior
	  /*
	  
	  */
	                alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "Empresa actualizado correctamente", "success")
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
	  swal("¡Error!", "No se pudo actualizar la Empresa.", "error");
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
function eliminarEmpresa(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_empresas/empresas.php', new URLSearchParams({
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
                    swal("¡Éxito!", "La empresa ha sido eliminado correctamente", "success")
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
                alertaPersonalizada('danger', response.data.message || 'Error al eliminar la empresa');
				swal("¡Error!", response.data.message || 'Error al eliminar la empresa', "error");
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
            axios.post('cat_empresas/empresas.php', new URLSearchParams({
                action: 'agregar',
                nombre_empresa: formData.get('nombre_empresa'),
                rfc: formData.get('rfc'),
                direccion: formData.get('direccion'),
                telefono: formData.get('telefono'),
                email: formData.get('email'),
                representante: formData.get('representante'),
                
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "la empresa se ha agregado correctamente", "success")
					
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
