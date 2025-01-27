<?php include('cat_alumnos/alumnos.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD de Alumnos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


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
    <h4 class="text-center">Cat&aacute;logo de Alumnos</h4>

    <!-- Buscador -->
    <div class="mb-3">
      <input type="text" id="buscador" class="form-control" placeholder="Buscar Alumno..." onkeyup="filtrarTabla()">
    </div>

    <!-- Botón para agregar -->
    <div class="mb-3 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Alumno</button>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
		    <th>Acciones</th>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo</th>
            <th>CURP</th>
            <th>Sexo</th>
            <th>Num. Control</th>
            <th>Celular</th>
			<th>Carrera</th>
            
          </tr>
        </thead>
        <tbody id="tablaAlumnos">
          <?php
          $alumnos = cargarAlumnos();
          foreach ($alumnos as $alumno) {
            echo "<tr>";
			echo "<td>
                    <button class='btn btn-warning' onclick='editarAlumno({$alumno['idalumno']})'>
    <i class='fas fa-edit'></i> <!-- Ícono de edición -->
</button>
<button class='btn btn-danger' onclick='eliminarAlumno({$alumno['idalumno']})'>
    <i class='fas fa-trash'></i> <!-- Ícono de papelera -->
</button>
                  </td>";
            echo "<td>{$alumno['idalumno']}</td>";
            echo "<td>{$alumno['nombre']}</td>";
            echo "<td>{$alumno['apellidop']}</td>";
            echo "<td>{$alumno['apellidom']}</td>";
            echo "<td>{$alumno['correo']}</td>";
            echo "<td>{$alumno['curp']}</td>";
            echo "<td>{$alumno['sexo']}</td>";
            echo "<td>{$alumno['num_control']}</td>";
            echo "<td>{$alumno['celular']}</td>";
			echo "<td>{$alumno['nombre_carrera']}</td>";
            
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal para agregar alumno -->
  <!-- Modal para agregar alumno -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgregarLabel">Agregar Alumno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregar">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="apellidop" class="form-label">Apellido Paterno</label>
              <input type="text" class="form-control" id="apellidop" name="apellidop" required>
            </div>
            <div class="mb-3">
              <label for="apellidom" class="form-label">Apellido Materno</label>
              <input type="text" class="form-control" id="apellidom" name="apellidom" required>
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="curp" class="form-label">CURP</label>
              <input type="text" class="form-control" id="curp" name="curp" required>
            </div>
            <div class="mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select class="form-control" id="sexo" name="sexo" required>
                <option value="HOMBRE">HOMBRE</option>
                <option value="MUJER">MUJER</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="num_control" class="form-label">Número de Control</label>
              <input type="text" class="form-control" id="num_control" name="num_control" required>
            </div>
            <div class="mb-3">
              <label for="celular" class="form-label">Celular</label>
              <input type="text" class="form-control" id="celular" name="celular" required>
            </div>
            <div class="mb-3">
  <label for="idcarrera" class="form-label">Carrera</label>
  <select class="form-control" id="idcarrera" name="idcarrera" required>
    <option value="">Seleccione una carrera</option>
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
                <h5 class="modal-title" id="modalEditarLabel">Editar Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="id_alumno" name="id_alumno">
                    <div class="mb-3">
                        <label for="nombreEditar" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreEditar" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidopEditar" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellidopEditar" name="apellidop" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidomEditar" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellidomEditar" name="apellidom" required>
                    </div>
                    <div class="mb-3">
                        <label for="correoEditar" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correoEditar" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="curpEditar" class="form-label">CURP</label>
                        <input type="text" class="form-control" id="curpEditar" name="curp" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexoEditar" class="form-label">Sexo</label>
                        <select class="form-control" id="sexoEditar" name="sexo" required>
                            <option value="HOMBRE">HOMBRE</option>
                            <option value="MUJER">MUJER</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="num_controlEditar" class="form-label">Número de Control</label>
                        <input type="text" class="form-control" id="num_controlEditar" name="num_control" required>
                    </div>
                    <div class="mb-3">
                        <label for="celularEditar" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="celularEditar" name="celular" required>
                    </div>
                    <div class="mb-3">
                        <label for="idcarreraEditar" class="form-label">Carrera</label>
                        <select class="form-control" id="idcarreraEditar" name="idcarrera" required>
                            <option value="">Seleccione una carrera</option>
                            <!-- Aquí se llenarán las carreras dinámicamente -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

  
<script>

	function cargarCarreras() {
  axios.get('cat_alumnos/carreras.php')
    .then(response => {
      const carreras = response.data;

      if (carreras.error) {
        alertaPersonalizada('danger', carreras.error);
        return;
      }

      const carreraSelect = document.getElementById('idcarrera');
      carreraSelect.innerHTML = '<option value="">Seleccione una carrera</option>'; // Limpiamos las opciones previas

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
	
	
    // Editar alumno
    // Función para editar el alumno
function editarAlumno(id) {
  axios.post('cat_alumnos/alumnos.php', new URLSearchParams({
    action: 'obtenerAlumno',
    id: id
  }))
  .then(function (response) {
    if (response.data.success) {
      const alumno = response.data.alumno;
      const carreras = response.data.carreras;

      document.getElementById('id_alumno').value = alumno.idalumno;
      document.getElementById('nombreEditar').value = alumno.nombre;
      document.getElementById('apellidopEditar').value = alumno.apellidop;
      document.getElementById('apellidomEditar').value = alumno.apellidom;
      document.getElementById('correoEditar').value = alumno.correo;
      document.getElementById('curpEditar').value = alumno.curp;
      document.getElementById('sexoEditar').value = alumno.sexo;
      document.getElementById('num_controlEditar').value = alumno.num_control;
      document.getElementById('celularEditar').value = alumno.celular;
      document.getElementById('idcarreraEditar').value = alumno.idcarrera;

      // Llenar el select de carreras
      const carreraSelect = document.getElementById('idcarreraEditar');
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
  const id = document.getElementById('id_alumno').value;

  const formData = new FormData(this);
  formData.append('action', 'editar');
  formData.append('id', id); // Añadir el id del alumno al FormData

  axios.post('cat_alumnos/alumnos.php', formData)
  .then(function (response) {
    if (response.data.success) {
      //alert('Alumno actualizado correctamente');
	  swal("¡Éxito!", "Alumno actualizado correctamente", "success")
	  setTimeout(() => {
                    location.href = "formcat_alumnos.php";
                }, 2000); // 5 segundos
      // Cerrar el modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
      modal.hide();
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
	axios.post('cat_alumnos/alumnos.php', new URLSearchParams({
            action: 'eliminar',
            id: id
        }))
        .then(response => {
            // Manejar la respuesta del servidor
            if (response.data.success) {
                //alertaPersonalizada('success', response.data.message);
				swal("¡Éxito!", "El alumno ha sido eliminado correctamente", "success");

                // Esperar 5 segundos y luego redirigir
                setTimeout(() => {
                    location.href = "formcat_alumnos.php";
                }, 3000); // 5 segundos
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
        cargarCarreras(); // Llenar el select con las carreras disponibles

        // Manejar el envío del formulario
        document.getElementById('formAgregar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario

            // Obtener datos del formulario
            const formData = new FormData(this);

            // Enviar los datos al servidor usando Axios
            axios.post('cat_alumnos/alumnos.php', new URLSearchParams({
                action: 'agregar',
                nombre: formData.get('nombre'),
                apellidop: formData.get('apellidop'),
                apellidom: formData.get('apellidom'),
                correo: formData.get('correo'),
                curp: formData.get('curp'),
                sexo: formData.get('sexo'),
                num_control: formData.get('num_control'),
                celular: formData.get('celular'),
                idcarrera: formData.get('idcarrera')
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
