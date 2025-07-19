<?php include('cat_tablas/tablas.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar datos </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <style>
    .card {
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .tabla-card input[type="checkbox"] {
      transform: scale(1.2);
    }
  </style>
</head>
<body>
<div class="container mt-4">

  <div class="sticky-top bg-light p-3 mb-4 rounded shadow-sm">
    <h4 class="text-center">Eliminar Datos </h4>
    <div class="row g-2">
      <div class="col-md-9">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar tabla..." oninput="filtrarCards()">
      </div>
      <div class="col-md-3 text-end">
        <button class="btn btn-danger w-100" onclick="truncarSeleccionadas()">
          <i class="fas fa-trash-alt"></i> Eliminar Seleccionados
        </button>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-12 text-center">
        <label id="cantidadRegistros" class="form-label fw-bold text-primary">Cantidad de tablas: 0</label>
      </div>
    </div>
  </div>

  <form id="formTablas">
    <div class="row" id="contenedorTablas">
      <?php
      $tablas = cargarTablas();
      $total = count($tablas);
      ?>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          document.getElementById('cantidadRegistros').textContent = 'Cantidad de tablas: <?= $total ?>';
        });
      </script>
      <?php foreach ($tablas as $tabla): ?>
        <div class="col-md-4 mb-4 tabla-card">
          <div class="card p-3">
            <div class="text-center">
              <i class="fas fa-database" style="font-size: 48px; color: #0d6efd;"></i>
            </div>
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($tabla) ?></h5>
              <label>
                <input type="checkbox" name="tablas[]" value="<?= $tabla ?>" checked>
                
              </label>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </form>

</div>

<script>
function filtrarCards() {
  const filtro = document.getElementById('buscador').value.toLowerCase();
  document.querySelectorAll('.tabla-card').forEach(card => {
    const texto = card.innerText.toLowerCase();
    card.style.display = texto.includes(filtro) ? '' : 'none';
  });
}

function truncarSeleccionadas() {
  const checkboxes = document.querySelectorAll('input[name="tablas[]"]:checked');
  if (checkboxes.length === 0) {
    swal("Aviso", "Debes seleccionar al menos una tabla.", "warning");
    return;
  }

  const tablas = Array.from(checkboxes).map(cb => cb.value);

  swal({
    title: "¿Confirmar eliminacion?",
    text: `Se eliminarán todos los datos de ${tablas.length} tabla(s).`,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then(confirmado => {
    if (confirmado) {
      const form = new FormData();
      tablas.forEach(t => form.append('tablas[]', t));

      axios.post('cat_tablas/tablas.php', form)
        .then(res => {
          const data = res.data;
          swal("Resultado", data.message, data.success ? "success" : "error");
        })
        .catch(err => {
          console.error(err);
          swal("Error", "No se realizar la eliminacion", "error");
        });
    }
  });
}
</script>
</body>
</html>
