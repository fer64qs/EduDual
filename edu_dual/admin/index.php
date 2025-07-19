<?php
session_start();
if (!empty($_SESSION["userId"])) {

    $variable = $_SESSION["idperfil"];

    switch ($variable) {
        case 1: // ADMINISTRADOR
            require_once __DIR__ . '/view/main_dashboard.php';
            break;

        case 2: // DOCENTE
        case 3: // COORDINACION
        case 4: // PADRE DE FAMILIA/TUTOR
        case 5: // ALUMNO
        case 6: // AUXILIAR DE COORDINACION
        case 7: // TUTOR
            // Mostrar mensaje de que el módulo no está disponible
            echo "<script>
                    alert('El módulo al que ha ingresado no es el correcto.');
                    window.location.href = '../index.html';
                  </script>";
            session_destroy(); // opcional: cerrar sesión
            exit;
            break;
    	}

} else {
    // No hay sesión iniciada
    require_once __DIR__ . '/view/login-form.php';
}
?>