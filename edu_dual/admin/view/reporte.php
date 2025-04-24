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
            placeholder="Buscar empresa..."
            oninput="filtrarCards()"
          >
        </div>
      </div>

      <!-- Fila con checkboxes y select -->
      <div class="row text-center align-items-center">
        <div class="col-md-2 offset-md-0">
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="check1">
            <label class="form-check-label ms-2" for="check1">ACTIVO</label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="check2">
            <label class="form-check-label ms-2" for="check2">INACTIVO</label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="check3">
            <label class="form-check-label ms-2" for="check3">ASCENDENTES</label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="check4">
            <label class="form-check-label ms-2" for="check4">DESCENDENTES</label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="check5">
            <label class="form-check-label ms-2" for="check5">TODOS</label>
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
      </div>

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

        <?php
        $inscripciones = cargarInscripcion();
        ?>

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
  </div>
</body>
</html>
