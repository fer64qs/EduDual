<?php include('cat_personalempresas/personalempresas.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cat del personal de empresas</title>
  
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
  <h4 class="text-center">Catálogo del personal de empresas</h4>
  <div class="row g-2">
    <div class="col-9">
      <input
        type="text"
        id="buscador"
        class="form-control"
        placeholder="Buscar personales..."
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
  $alumnos = cargarPersonal();
  $totalRegistros = count($alumnos); // Cuenta la cantidad de registros
  ?>
  <script>
  // Actualiza el contenido del label con PHP
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
  });
</script>
  <?php
  foreach ($alumnos as $alumno) {
    $sexo = $alumno['sexo'];
    $icono = ($sexo == 'HOMBRE') ? 'fa-male' : 'fa-female';
    $color = ($sexo == 'HOMBRE') ? 'black' : '#d093b6';

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<i class='fas {$icono}' style='font-size: 64px; color: {$color};'></i>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$alumno['nombre_personal']} {$alumno['papellido_paterno']} {$alumno['papellido_materno']}</b></h5>";

    echo "<p class='card-text'>";
    //echo "<b>CURP:</b> {$alumno['curp']}<br>";
    echo "<b>G&eacute;nero:</b> {$alumno['sexo']}<br>";
    echo "<b>Correo:</b> {$alumno['correo']}<br>";
    echo "<b>Telefono:</b> {$alumno['telefono']}<br>";
    echo "<b>Cargo en la empresa:</b> {$alumno['cargo_empresa']}<br>";
    echo "<b>Empresa:</b> {$alumno['nombre_empresa']}<br>";
    echo "</p>";
    echo "<button class='btn btn-warning' onclick='editarPersonal({$alumno['idpersonal']})' style='font-size: 14px;'>
            <i class='fas fa-edit'></i> Editar
          </button>&nbsp;";
    echo "<button class='btn btn-danger' onclick='eliminarPersonal({$alumno['idpersonal']})' style='font-size: 14px;'>
            <i class='fas fa-trash'></i> Eliminar
          </button>&nbsp;";
    echo "<button class='btn btn-info' onclick='crearCuenta(\"{$alumno['idpersonal']}\", \"{$alumno['nombre_personal']}\", \"{$alumno['papellido_paterno']}\", \"{$alumno['papellido_materno']}\", \"{$alumno['correo']}\", \"{$alumno['telefono']}\")' style='font-size: 14px;'>
            <i class='fas fa-user'></i> Acceso
          </button>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  ?>
  <!-- Modal para agregar alumno -->
  <!-- Modal para agregar alumno -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar personal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="nombre_personal" class="form-label"><b>Nombre:</b></label>
              <input type="text" class="form-control" id="nombre_personal" name="nombre_personal" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="papellido_paterno" class="form-label"><b>Apellido Paterno:</b></label>
              <input type="text" class="form-control" id="papellido_paterno" name="papellido_paterno" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="papellido_materno" class="form-label"><b>Apellido Materno:</b></label>
              <input type="text" class="form-control" id="papellido_materno" name="papellido_materno" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label"><b>Correo:</b></label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="sexo" class="form-label"><b>G&eacute;nero:</b></label>
              <select class="form-control" id="sexo" name="sexo" required>
                <option value="HOMBRE">HOMBRE</option>
                <option value="MUJER">MUJER</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="cargo_empresa" class="form-label"><b>Cargo en la empresa:</b></label>
              <input type="text" class="form-control" id="cargo_empresa" name="cargo_empresa" style="text-transform: uppercase;" required>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label"><b>Telefono:</b></label>
              <input type="number" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="mb-3">
  <label for="idempresa" class="form-label"><b>Empresa:</b></label>
  <select class="form-control" id="idempresa" name="idempresa" required>
    <option value="">SELECCIONE UNA Empresa</option>
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
                <h5 class="modal-title" id="modalEditarLabel">Editar Personal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_personal" name="id_personal">
                    <div class="mb-3">
                        <label for="nombre_personalEditar" class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" id="nombre_personalEditar" name="nombre_personal" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="papellido_paternoEditar" class="form-label"><b>Apellido Paterno:</b></label>
                        <input type="text" class="form-control" id="papellido_paternoEditar" name="papellido_paterno" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="papellido_maternoEditar" class="form-label"><b>Apellido Materno:</b></label>
                        <input type="text" class="form-control" id="papellido_maternoEditar" name="papellido_materno" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="correoEditar" class="form-label"><b>Correo:</b></label>
                        <input type="email" class="form-control" id="correoEditar" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexoEditar" class="form-label"><b>G&eacute;nero:</b></label>
                        <select class="form-control" id="sexoEditar" name="sexo" required>
                            <option value="HOMBRE">HOMBRE</option>
                            <option value="MUJER">MUJER</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cargo_empresaEditar" class="form-label"><b>Cargo en la empresa:</b></label>
                        <input type="text" class="form-control" id="cargo_empresaEditar" name="cargo_empresa" style="text-transform: uppercase;" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefonoEditar" class="form-label"><b>Telefono:</b></label>
                        <input type="number" class="form-control" id="telefonoEditar" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="idempresaEditar" class="form-label"><b>Empresa:</b></label>
                        <select class="form-control" id="idempresaEditar" name="idempresa" required>
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

	function cargarEmpresas() {
  axios.get('cat_personalempresas/empresas.php')
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
    })
    .catch(error => {
      alertaPersonalizada('danger', 'Error al cargar las carreras: ' + error.message);
    });
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', cargarEmpresas);

</script>
  <script>
function crearCuenta(idAlumno, nombre, apellidoP, apellidoM, correo, celular) {
    // Verificar si el alumno ya tiene una cuenta
    axios.post('cat_personalempresas/personalempresas.php', new URLSearchParams({
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
        const url = `add_user_personal.php?idpersonal=${encodeURIComponent(idAlumno)}&nombre_personal=${encodeURIComponent(nombre)}&papellido_paterno=${encodeURIComponent(apellidoP)}&papellido_materno=${encodeURIComponent(apellidoM)}&correo=${encodeURIComponent(correo)}&telefono=${encodeURIComponent(celular)}`;
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
function editarPersonal(id) {
  axios.post('cat_personalempresas/personalempresas.php', new URLSearchParams({
    action: 'obtenerPersonal',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const alumno = response.data.alumno;
      const empresas = response.data.empresas;

      document.getElementById('id_personal').value = alumno.idpersonal;
      document.getElementById('nombre_personalEditar').value = alumno.nombre_personal;
      document.getElementById('papellido_paternoEditar').value = alumno.papellido_paterno;
      document.getElementById('papellido_maternoEditar').value = alumno.papellido_materno;
      document.getElementById('correoEditar').value = alumno.correo;
      //document.getElementById('curpEditar').value = alumno.curp;
      document.getElementById('sexoEditar').value = alumno.sexo;
      document.getElementById('cargo_empresaEditar').value = alumno.cargo_empresa;
      document.getElementById('telefonoEditar').value = alumno.telefono;
      document.getElementById('idempresaEditar').value = alumno.idempresa;

      // Llenar el select de carreras
      const empresaSelect = document.getElementById('idempresaEditar');
      empresaSelect.innerHTML = ''; // Limpiar las opciones existentes

      empresas.forEach(function(empresa) {
        const option = document.createElement('option');
        option.value = empresa.idempresa;
        option.textContent = empresa.nombre_empresa;

        if (empresa.idempresa == alumno.idempresa) {
          option.selected = true;
        }

        empresaSelect.appendChild(option);
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
  const id = document.getElementById('id_personal').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id_personal', id); // Añadir el id del alumno al FormData

  axios.post('cat_personalempresas/personalempresas.php', formData)
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
function eliminarPersonal(id) {
	
	swal({
  title: "¿Estás seguro?",
  text: "¡Este cambio no se puede deshacer!",
  icon: "warning",
  buttons: ["Cancelar", "Aceptar"],
}).then((willDelete) => {
  if (willDelete) {
    // Acciones si el usuario acepta
    console.log("Elemento eliminado");
	axios.post('cat_personalempresas/personalempresas.php', new URLSearchParams({
            action: 'eliminar',
            id: id
        }))
        .then(response => {
            // Manejar la respuesta del servidor
            if (response.data.success) {
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
        cargarEmpresas(); // Llenar el select con las carreras disponibles

        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
			
            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_personalempresas/personalempresas.php', new URLSearchParams({
                action: 'agregar',
                nombre_personal: formData.get('nombre_personal'),
                papellido_paterno: formData.get('papellido_paterno'),
                papellido_materno: formData.get('papellido_materno'),
                correo: formData.get('correo'),
                //curp: formData.get('curp'),
                sexo: formData.get('sexo'),
                cargo_empresa: formData.get('cargo_empresa'),
                telefono: formData.get('telefono'),
                idempresa: formData.get('idempresa')
            }))
            .then(function (response) {
                if (response.data.success) {
                    alertaPersonalizada('success', response.data.message);
                    swal("¡Éxito!", "El alumno se ha agregado correctamente", "success")
					
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
