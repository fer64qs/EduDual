<?php 
include('cat_inscripciones/inscripciones.php'); 
$nombrecompleto_alumno = isset($_REQUEST["nombrecompleto_alumno"]) ? $_REQUEST["nombrecompleto_alumno"] : '';
$nombre_empresa = isset($_REQUEST["nombre_empresa"]) ? $_REQUEST["nombre_empresa"] : '';
$idasesordual_docente = isset($_REQUEST["idasesordual_docente"]) ? $_REQUEST["idasesordual_docente"] : '';
$nombreasesordual_docente = isset($_REQUEST["nombreasesordual_docente"]) ? $_REQUEST["nombreasesordual_docente"] : '';
$responsable_empresa = isset($_REQUEST["responsable_empresa"]) ? $_REQUEST["responsable_empresa"] : '';
$nombre_director = isset($_REQUEST["nombre_director"]) ? $_REQUEST["nombre_director"] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte</title>
  
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
    <div style="position: sticky; top: 0; background-color: #f4f6f6; z-index: 10; padding: 10px;">
      <h4 class="text-center">Reporte de Inscripción De Educación Dual:</h4>

      <!-- Campo de búsqueda centrado -->
      <div class="row justify-content-center g-2 mb-3">
        <div class="col-md-6">
          <input
            type="text"
            id="buscador"
            class="form-control text-center"
            placeholder="Buscar alumno o empresa..."
            oninput="filtrarCards()"
          >
        </div>
      </div>

      <!-- Fila con checkboxes y select -->
      <div class="row mt-3 justify-content-center">
      <div class="col-auto">
          <input type="checkbox" id="chkTodos" checked> <label for="chkTodos">TODOS</label>
        </div>
        <div class="col-auto">
          <label for="estatus" class="form-label"><b>Estatus:</b></label>
          <input type="checkbox" id="chkActivo"> <label for="chkActivo">ACTIVO</label>
        </div>
        <div class="col-auto">
          <input type="checkbox" id="chkInactivo"> <label for="chkInactivo">INACTIVO</label>
        </div>
        <div class="col-auto">
          <label for="alfabeticamente" class="form-label"><b>Orden alfabético:</b></label>
          <input type="checkbox" id="chkAsc"> <label for="chkAsc">ASCENDENTE (A-Z)</label>
        </div>
        <div class="col-auto">
          <input type="checkbox" id="chkDesc"> <label for="chkDesc">DESCENDENTE (Z-A)</label>
        </div>
        </div>

      <!-- Select de ciclo escolar -->
      <div class="col-md-2 mt-2 mt-md-0">
        <label for="ciclo_escolar" class="form-label"><b>Ciclo Escolar:</b></label>
        <select class="form-control text-center" id="ciclo_escolar" name="ciclo_escolar">
          <option value="">Selecciona un ciclo escolar</option>
          <?php
          $inscripciones = cargarInscripcion();
          $ciclosUnicos = [];
          foreach ($inscripciones as $inscripcion) {
            $semestre = $inscripcion['semestre'];
            if (!in_array($semestre, $ciclosUnicos)) {
              $ciclosUnicos[] = $semestre;
              echo "<option value=\"" . htmlspecialchars($semestre) . "\">" . htmlspecialchars($semestre) . "</option>";
            }
          }
          ?>
        </select>
      </div>
      <button type="button" class="btn btn-danger" onclick="generarPDF()">Generar PDF</button>

      
      <?php
      $inscripciones = cargarInscripcion();
      $cantidadRegistros = count($inscripciones);
      ?>

      <!-- Label para cantidad de registros -->
      <div class="row mt-2">
        <div class="col-12 text-center">
          <label id="cantidadRegistros" class="form-label" style="font-weight: bold; color: #A57F2C;">
            <strong>Cantidad de registros: <?= $cantidadRegistros ?></strong>
          </label>
        </div>
      </div>

      <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Nombre del Alumno</th>
              <th>Empresa</th>
              <th>Ciclo Escolar</th>
              <th>Estatus</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php foreach ($inscripciones as $inscripcion): ?>
              <tr>
                <td><?= htmlspecialchars($inscripcion['nombre'] . ' ' . $inscripcion['apellidop'] . ' ' . $inscripcion['apellidom']) ?></td>
                <td><?= htmlspecialchars($inscripcion['nombre_empresa']) ?></td>
                <td><?= htmlspecialchars($inscripcion['semestre']) ?></td>
                <td><?= htmlspecialchars($inscripcion['estatus']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
  const chkActivo = document.getElementById('chkActivo');
  const chkInactivo = document.getElementById('chkInactivo');
  const chkTodos = document.getElementById('chkTodos');
  const chkAsc = document.getElementById('chkAsc');
  const chkDesc = document.getElementById('chkDesc');
  const cicloEscolarSelect = document.getElementById('ciclo_escolar');
  const buscadorInput = document.getElementById('buscador');
  const tbody = document.querySelector('table tbody');

  // Variable para almacenar el orden original de las filas
  const filasOriginales = Array.from(tbody.querySelectorAll('tr'));

  function actualizarFiltro() {
    let mostrarActivos = chkActivo.checked;
    let mostrarInactivos = chkInactivo.checked;
    let mostrarTodos = chkTodos.checked;
    const cicloEscolarSeleccionado = cicloEscolarSelect.value.trim().toUpperCase();
    const textoBusqueda = buscadorInput.value.trim().toLowerCase();
    const filas = Array.from(tbody.querySelectorAll('tr'));

    if (!mostrarActivos && !mostrarInactivos && !mostrarTodos) {
      mostrarTodos = true;
    }

    filas.forEach(fila => {
      const nombreAlumno = fila.cells[0].innerText.trim().toLowerCase();
      const nombreEmpresa = fila.cells[1].innerText.trim().toLowerCase();
      const cicloEscolar = fila.cells[2].innerText.trim().toUpperCase();
      const estatus = fila.cells[3].innerText.trim().toUpperCase();
      let mostrarFila = true;

      // Filtro por estatus
      if (!mostrarTodos &&
          !(mostrarActivos && estatus === 'ACTIVO') &&
          !(mostrarInactivos && estatus === 'INACTIVO')) {
        mostrarFila = false;
      }

      // Filtro por ciclo escolar
      if (cicloEscolarSeleccionado && cicloEscolar !== cicloEscolarSeleccionado) {
        mostrarFila = false;
      }

      // Filtro por búsqueda en nombre de alumno o empresa
      if (textoBusqueda && !nombreAlumno.includes(textoBusqueda) && !nombreEmpresa.includes(textoBusqueda)) {
        mostrarFila = false;
      }

      fila.style.display = mostrarFila ? '' : 'none';
    });

    actualizarContador();
  }

  function actualizarContador() {
    const visibles = Array.from(tbody.querySelectorAll('tr')).filter(f => f.style.display !== 'none');
    document.getElementById('cantidadRegistros').innerHTML =
      `<strong>Cantidad de registros: ${visibles.length}</strong>`;
  }

  function ordenarTabla(ascendente = true) {
    const filas = Array.from(tbody.querySelectorAll('tr')).filter(f => f.style.display !== 'none');
    const filasOrdenadas = filas.sort((a, b) => {
      const nombreA = a.cells[0].innerText.toUpperCase();
      const nombreB = b.cells[0].innerText.toUpperCase();
      return ascendente
        ? nombreA.localeCompare(nombreB)
        : nombreB.localeCompare(nombreA);
    });

    filasOrdenadas.forEach(fila => tbody.appendChild(fila));
  }

  // Restaura el orden original de las filas
  function restaurarOrdenOriginal() {
    filasOriginales.forEach(fila => tbody.appendChild(fila));
  }

  // Eventos
  chkActivo.addEventListener('change', () => {
    if (chkActivo.checked) {
      chkInactivo.checked = false;
      chkTodos.checked = false;
    } else if (!chkInactivo.checked) {
      chkTodos.checked = true;
    }
    actualizarFiltro();
  });

  chkInactivo.addEventListener('change', () => {
    if (chkInactivo.checked) {
      chkActivo.checked = false;
      chkTodos.checked = false;
    } else if (!chkActivo.checked) {
      chkTodos.checked = true;
    }
    actualizarFiltro();
  });

  chkTodos.addEventListener('change', () => {
    if (chkTodos.checked) {
      chkActivo.checked = false;
      chkInactivo.checked = false;
      buscadorInput.value = ''; // Borrar contenido del buscador
      cicloEscolarSelect.value = ''; // Restablecer ciclo escolar al valor predeterminado
    }
    actualizarFiltro();
  });

  chkAsc.addEventListener('change', () => {
    if (chkAsc.checked) {
      chkDesc.checked = false;
      ordenarTabla(true); // Ascendente
    } else {
      // Si ambos están desmarcados, restauramos el orden original
      if (!chkDesc.checked) {
        restaurarOrdenOriginal();
      }
    }
  });

  chkDesc.addEventListener('change', () => {
    if (chkDesc.checked) {
      chkAsc.checked = false;
      ordenarTabla(false); // Descendente
    } else {
      // Si ambos están desmarcados, restauramos el orden original
      if (!chkAsc.checked) {
        restaurarOrdenOriginal();
      }
    }
  });

  cicloEscolarSelect.addEventListener('change', () => {
    chkTodos.checked = false;
    actualizarFiltro();
  });

  // Evento para búsqueda en tiempo real
  buscadorInput.addEventListener('input', () => {
    if (chkTodos.checked) {
      chkTodos.checked = false;
    }
    actualizarFiltro();
  });

  // Llamamos a actualizarFiltro para aplicar filtros al cargar la página
  actualizarFiltro();
});


function generarPDF() {
  const chkActivo = document.getElementById('chkActivo');
  const chkInactivo = document.getElementById('chkInactivo');
  const chkTodos = document.getElementById('chkTodos');
  const chkAsc = document.getElementById('chkAsc');
  const chkDesc = document.getElementById('chkDesc');
  const cicloEscolarSelect = document.getElementById('ciclo_escolar');
  const buscadorInput = document.getElementById('buscador');

  const filtro = {
    estatus: chkActivo.checked ? "ACTIVO" :
             chkInactivo.checked ? "INACTIVO" :
             chkTodos.checked ? "TODOS" : "",
    ciclo_escolar: cicloEscolarSelect.value,
    busqueda: buscadorInput.value.trim(),
    orden: chkAsc.checked ? "ASC" :
           chkDesc.checked ? "DESC" : ""
  };

  const url = `../../exportar_pdf.php?filtros=${encodeURIComponent(JSON.stringify(filtro))}`;
  window.open(url, '_blank');
}

  </script>
</body>
</html>
