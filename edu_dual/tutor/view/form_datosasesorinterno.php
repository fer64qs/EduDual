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
    .alert-custom {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }
    
    .card {
      width: 100%;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
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
      <div class="row g-2">
        <div class="col-9">
          <input type="text" id="buscador" class="form-control" placeholder="Buscar..." oninput="filtrarCards()">
        </div>
        
      </div>
      <div class="row mt-2">
        <div class="col-12 text-center">
          <label id="cantidadRegistros" class="form-label" style="font-weight: bold; color: #A57F2C;"><strong>Cantidad de registros: 0</strong></label>
        </div>
      </div>
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

      <script>
        document.addEventListener('DOMContentLoaded', () => {
          document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalRegistros; ?>';
        });
      </script>

      <?php
      if ($totalRegistros === 0) {
        echo "<p class='text-center text-muted'>No hay inscripciones disponibles.</p>";
      } else {
        foreach ($inscripciones as $inscripcion) {
          echo "<div class='col-md-4 mb-4'>"; 
          echo "<div class='card'>";
          echo "<div class='card-body'>";

          echo "<div class='text-center mb-3'>";
          
          echo "</div>";

          echo "<h5 class='card-title text-center'><b>{$inscripcion['nombre']} {$inscripcion['apellidop']} {$inscripcion['apellidom']}</b></h5>";

          echo "<p class='card-text'>";
          echo "<b>Tutor Académico:</b> {$inscripcion['nombre_tutor']} {$inscripcion['apellido_paterno']} {$inscripcion['apellido_materno']}<br>";
          echo "<b>Tutor Personal:</b> {$inscripcion['nombre_personal']} {$inscripcion['papellido_paterno']} {$inscripcion['papellido_materno']}<br>";
          echo "<b>Empresa:</b> {$inscripcion['nombre_empresa']}<br>";
          echo "<b>Ciclo Escolar:</b> {$inscripcion['semestre']}<br>";
          echo "<b>Fecha de Inicio:</b> {$inscripcion['fecha_inicio']}<br>";
          echo "<b>Fecha de Fin:</b> {$inscripcion['fecha_fin']}<br>";
          echo "<b>Estatus:</b> {$inscripcion['estatus']}<br>";
          echo "</p>";

          echo "<div class='btn-container'>";
          echo "<button class='btn btn-warning' onclick='viewcronograma({$inscripcion['idinscripcion']})' style='font-size: 14px;'>
                  <i class='fas fa-calendar-alt'></i> Cronograma
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
      const url = `cronograma.php?idinscripcion=${encodeURIComponent(idinscripcion)}`;
      window.location.href = url;
    }

    function filtrarCards() {
      const searchValue = document.getElementById('buscador').value.toLowerCase();
      const cards = document.querySelectorAll('.card');

      cards.forEach(card => {
        const cardText = card.innerText.toLowerCase();
        card.style.display = cardText.includes(searchValue) ? 'block' : 'none';
      });
    }
  </script>
</body>
</html>
