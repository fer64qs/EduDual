<?php include('cat_noticias/noticias.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Noticias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

  <style>
    .alert-custom {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
    }
    img.img-noticia {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .modal-body {
      max-height: 400px;
      overflow-y: auto;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <div style="position: sticky; top: 0; background-color: #f4f6f6; z-index: 10; padding: 10px;">
    <h4 class="text-center">Catálogo de Noticias</h4>
    <div class="row g-2">
      <div class="col-9">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar noticias..." oninput="filtrarCards()">
      </div>
      <div class="col-3 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
          <i class="fas fa-plus"></i> Nueva Noticia
        </button>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-12 text-center">
        <label id="cantidadRegistros" class="form-label" style="font-weight: bold; color: #A57F2C;">
          <strong>Cantidad de registros: 0</strong>
        </label>
      </div>
    </div>
  </div>

  <div class="row mt-3" id="contenedorNoticias">
    <?php
    $noticias = cargarNoticias();
    $totalNoticias = count($noticias);
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('cantidadRegistros').textContent = 'Cantidad de registros: <?php echo $totalNoticias; ?>';
      });
    </script>
    <?php 
    foreach ($noticias as $noticia) { 
      $imagen = $noticia['imagen']; // Ruta de la imagen

    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card' style='width: 20rem;'>";
    echo "<div class='text-center mt-3'>";
    echo "<img src='{$imagen}' alt='Imagen de la noticia' style='width: 150px; height: 150px; border-radius: 50%; object-fit: cover;'>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title text-center'><b>{$noticia['titulo']} </b></h5>";

    echo "<p class='card-text'>";
    echo "<b></b> {$noticia['subtitulo']}<br>";
    echo "<b></b> {$noticia['fecha']}<br>";
    echo "<b></b> {$noticia['descripcion']}<br>";
    echo "</p>";
    
    echo "<div class='d-flex justify-content-between'>";
    echo '<button class="btn btn-warning btn-sm" onclick=\'abrirModalEditar(' . json_encode($noticia) . ')\'><i class="fas fa-edit"></i> Editar</button>';
    echo "<button class='btn btn-danger btn-sm' onclick='eliminarNoticia({$noticia['id_noticia']})'><i class='fas fa-trash'></i> Eliminar</button>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
    }
    ?>
    </div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalAgregarLabel">Agregar Noticia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form id="formAgregar" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="action" value="agregar">
          <div class="mb-3"><label class="form-label">Título</label><input type="text" class="form-control" name="titulo" required></div>
          <div class="mb-3"><label class="form-label">Subtítulo</label><input type="text" class="form-control" name="subtitulo"></div>
          <div class="mb-3"><label class="form-label">Fecha</label><input type="date" class="form-control" name="fecha" required></div>
          <div class="mb-3"><label class="form-label">Descripción</label><textarea class="form-control" name="descripcion" id="descripcionAgregar"></textarea></div>
          <div class="mb-3"><label class="form-label">Imagen</label><input type="file" class="form-control" name="imagen" accept="image/*"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editarModalLabel">Editar Noticia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form id="formEditar" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" id="idEditar" name="id">
          <div class="mb-3"><label class="form-label">Título</label><input type="text" class="form-control" name="titulo" id="tituloEditar" required></div>
          <div class="mb-3"><label class="form-label">Subtítulo</label><input type="text" class="form-control" name="subtitulo" id="subtituloEditar"></div>
          <div class="mb-3"><label class="form-label">Fecha</label><input type="date" class="form-control" name="fecha" id="fechaEditar" required></div>
          <div class="mb-3"><label class="form-label">Descripción</label><textarea class="form-control" name="descripcion" id="descripcionEditar"></textarea></div>
          <div class="mb-3"><label class="form-label">Nueva Imagen (opcional)</label><input type="file" class="form-control" name="imagen" accept="image/*"></div>
          <div class="mb-3"><label class="form-label">Imagen Actual</label><br><img id="imagenActualEditar" src="" alt="Imagen actual" class="img-fluid mb-2" style="max-height: 200px;"><p><strong>Nombre del archivo:</strong> <span id="nombreImagenEditar"></span></p></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let editorAgregar;

document.addEventListener('DOMContentLoaded', () => {
  ClassicEditor
    .create(document.querySelector('#descripcionAgregar'))
    .then(editor => {
      editorAgregar = editor;
    })
    .catch(error => {
      console.error(error);
    });
});
  // Enviar el formulario para agregar una nueva noticia
  document.getElementById('formAgregar').addEventListener('submit', function (e) {
  e.preventDefault();
  
  // Sincronizar contenido de CKEditor con el textarea
  if (editorAgregar) {
    document.querySelector('#descripcionAgregar').value = editorAgregar.getData();
  }

  const formData = new FormData(this);
  axios.post('cat_noticias/noticias.php', formData)
    .then(res => {
      swal("¡Éxito!", "Noticia agregada correctamente", "success").then(() => location.reload());
    })
    .catch(() => swal("Error", "Error al agregar la noticia", "error"));
});

  /* Enviar el formulario para editar la noticia
  document.getElementById('formEditar').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    axios.post('cat_noticias/noticias.php', formData)
      .then(res => {
        swal("¡Éxito!", "Noticia actualizada correctamente", "success").then(() => location.reload());
      })
      .catch(() => swal("Error", "Error al actualizar la noticia", "error"));
  });
*/
  // Función para eliminar noticia
  function eliminarNoticia(id) {
    swal({
      title: "¿Estás seguro?",
      text: "¡Este cambio no se puede deshacer!",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then((willDelete) => {
      if (willDelete) {
        axios.post('cat_noticias/noticias.php', new URLSearchParams({ action: 'eliminar', id }))
          .then(() => {
            swal("¡Éxito!", "La noticia ha sido eliminada", "success").then(() => location.reload());
          })
          .catch(() => swal("Error", "Error al eliminar la noticia", "error"));
      }
    });
  }


  let editorEditar;

  document.addEventListener('DOMContentLoaded', () => {
    ClassicEditor
      .create(document.querySelector('#descripcionEditar'))
      .then(editor => {
        editorEditar = editor;
      })
      .catch(error => {
        console.error(error);
      });
  });
// Función para abrir el modal de edición y cargar los datos
function abrirModalEditar(noticia) {
  document.getElementById('idEditar').value = noticia.id_noticia;
  document.getElementById('tituloEditar').value = noticia.titulo;
  document.getElementById('subtituloEditar').value = noticia.subtitulo;
  document.getElementById('fechaEditar').value = noticia.fecha;
  document.getElementById('imagenActualEditar').src = noticia.imagen;

  // Obtener el nombre del archivo desde la ruta
  const nombreArchivo = noticia.imagen.split('/').pop();
  document.getElementById('nombreImagenEditar').textContent = nombreArchivo;

  // Cargar la descripción en el editor
  if (editorEditar) {
    editorEditar.setData(noticia.descripcion);
  } else {
    // Si el editor aún no está inicializado, esperar a que lo esté
    ClassicEditor
      .create(document.querySelector('#descripcionEditar'))
      .then(editor => {
        editorEditar = editor;
        editorEditar.setData(noticia.descripcion);
      })
      .catch(error => {
        console.error(error);
      });
  }

  // Mostrar el modal
  new bootstrap.Modal(document.getElementById('editarModal')).show();
}

// Enviar el formulario para editar la noticia
document.getElementById('formEditar').addEventListener('submit', function (e) {
  e.preventDefault();

  // Sincronizar contenido de CKEditor con el textarea
  if (editorEditar) {
    document.querySelector('#descripcionEditar').value = editorEditar.getData();
  }

  const formData = new FormData(this);
  axios.post('cat_noticias/noticias.php', formData)
    .then(res => {
      swal("¡Éxito!", "Noticia actualizada correctamente", "success").then(() => location.reload());
    })
    .catch(() => swal("Error", "Error al actualizar la noticia", "error"));
});
</script>

</body>
</html>