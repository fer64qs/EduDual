<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cambiar Contraseña - EduDual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 420px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Cambiar Contraseña</h3>
            <form id="formCambioContrasena" method="POST" action="procesar_cambio_contrasenia.php" novalidate>
                <div class="mb-3">
                    <label for="contrasenia_actual" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control" id="contrasenia_actual" name="contrasenia_actual" required>
                    <div class="invalid-feedback">
                        Por favor ingresa tu contraseña actual.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="contrasenia_nueva" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="contrasenia_nueva" name="contrasenia_nueva" required minlength="6">
                    <div class="invalid-feedback">
                        Por favor ingresa una nueva contraseña (mínimo 6 caracteres).
                    </div>
                </div>
                <div class="mb-3">
                    <label for="contrasenia_confirmar" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="contrasenia_confirmar" name="contrasenia_confirmar" required minlength="6">
                    <div class="invalid-feedback">
                        Por favor confirma tu nueva contraseña.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Bootstrap 5 validation
    (() => {
        'use strict'
        const form = document.getElementById('formCambioContrasena');

        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            } else {
                const nueva = form.contrasenia_nueva.value;
                const confirmar = form.contrasenia_confirmar.value;
                if (nueva !== confirmar) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire('Error', 'La nueva contraseña y su confirmación no coinciden.', 'error');
                    return false;
                }
            }

            form.classList.add('was-validated')
        }, false)
    })();
</script>

<?php if (!empty($_SESSION['mensaje'])): ?>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['mensaje']['tipo'] ?>',
        title: '<?= $_SESSION['mensaje']['tipo'] === 'success' ? 'Éxito' : 'Error' ?>',
        text: '<?= $_SESSION['mensaje']['texto'] ?>'
    });
</script>
<?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

</body>
</html>