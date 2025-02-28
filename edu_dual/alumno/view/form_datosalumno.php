<?php include('cat_inscripciones/inscripciones.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datos del Alumno</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

  <style>
    .card {
      width: 100%;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card-header {
      background: #f8f9fa;
      font-weight: bold;
      padding: 15px;
      text-align: center;
      border-bottom: 2px solid #ddd;
      font-size: 18px;
    }

    .card-body {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 20px;
    }

    .data-item {
      flex: 1;
      min-width: 200px;
      margin-right: 20px;
      margin-bottom: 10px;
    }

    .data-title {
      font-weight: bold;
      text-transform: uppercase;
      font-size: 14px;
      color: #555;
      padding-bottom: 3px;
    }

    .data-value {
      font-size: 18px;
      font-weight: bold;
      color: #222;
    }

    .btn-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      flex: 1;
      min-width: 200px;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <div style="position: sticky; top: 0; background-color: #f4f6f6; z-index: 10; padding: 15px;">
      <h4 class="text-center">Datos del Alumno</h4>
    </div>

    <!-- Cards -->
    <div class="row">
      <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $idusuario = $_SESSION["userId"] ?? null;

        if ($idusuario) {
          $inscripciones = cargarInscripcion($idusuario);
          $totalRegistros = count($inscripciones);
        } else {
          $inscripciones = [];
          $totalRegistros = 0;
        }
      ?>

      <?php
      if ($totalRegistros === 0) {
        echo "<p class='text-center text-muted'>No hay inscripciones disponibles.</p>";
      } else {
        foreach ($inscripciones as $inscripcion) {
          echo "<div class='col-md-12'>"; 
          echo "<div class='card'>";
          echo "<div class='card-body'>";


          echo "<div class='data-item'><div class='data-title'>Nombre</div><div class='data-value'>{$inscripcion['nombre']} {$inscripcion['apellidop']} {$inscripcion['apellidom']}</div></div>";
          
          echo "<div class='data-item'><div class='data-title'>Tutor Académico</div><div class='data-value'>{$inscripcion['nombre_tutor']} {$inscripcion['apellido_paterno']} {$inscripcion['apellido_materno']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Tutor Personal</div><div class='data-value'>{$inscripcion['nombre_personal']} {$inscripcion['papellido_paterno']} {$inscripcion['papellido_materno']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Empresa</div><div class='data-value'>{$inscripcion['nombre_empresa']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Ciclo Escolar</div><div class='data-value'>{$inscripcion['semestre']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Fecha de Inicio</div><div class='data-value'>{$inscripcion['fecha_inicio']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Fecha de Fin</div><div class='data-value'>{$inscripcion['fecha_fin']}</div></div>";
          echo "<div class='data-item'><div class='data-title'>Estatus</div><div class='data-value'>{$inscripcion['estatus']}</div></div>";

          
          echo "<div class='btn-container'>";
          echo "<button class='btn btn-warning' onclick='viewcronograma({$inscripcion['idinscripcion']})' style='font-size: 16px; padding: 10px 20px;'>
                  <i class='fas fa-edit'></i> Cronograma
                </button>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>"; 
        }
      }
      ?>
    </div>
  </div>

  <script>
    function viewcronograma(idinscripcion) {
    // Construir la URL con los parámetros necesarios
    const url = `cronograma.php?idinscripcion=${encodeURIComponent(idinscripcion)}`;
    
    // Redirigir a bitacora.php
    window.location.href = url;
}
    </script>
</body>
</html>
