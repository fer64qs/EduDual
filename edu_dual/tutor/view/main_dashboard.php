<?php

namespace Phppot;

use \Phppot\Member;

// Incluir SweetAlert2 desde el CDN
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

if (!empty($_SESSION["userId"])) {
    require_once realpath(dirname(__FILE__) . '/../class/Member.php');
    $member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if (!empty($memberResult[0]["display_name"])) {
        $displayName = ucwords($memberResult[0]["display_name"]);
    } else {
        $displayName = $memberResult[0]["apellidos"] . " " . $memberResult[0]["nombres"];
        $profileName = $memberResult[0]["nombre_perfil"];
        $clave_sie = $memberResult[0]["clave_sie"];
    }
} else {
    // Mostrar alerta SweetAlert2
    echo "<script>
        alert('No ha iniciado Sesion');
                window.location.assign('../index.php');
        
    </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduDual Connect</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
	
	
	<!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!--- -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	
<meta name="theme-color" content="#000000">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">

	<!-- -->

    <style>
        /* Estilo para el iframe */
        #contenido iframe {
            width: 100%;
            height: 500px; /* Ajusta la altura según sea necesario */
            border: none; /* Remueve el borde */
        }
    </style>
</head>



    <!-- Header -->
    <header class="text-white text-center py-3" style="background-color: #611232;">
        <div class="container">
            <div class="row">
                <!-- Primera columna -->
                <div class="col-md-4">
                    <h2>EduDual Connect</h2>
                </div>
                <!-- Segunda columna -->
                <div class="col-md-4">
                    <p><b><?php echo "Bienvenid@: " . $displayName; echo "<br>"; echo $profileName . " | " . $clave_sie; ?></b></p>
                </div>
                <!-- Cuarta columna: cerrar sesión -->
                <div class="col-md-4 text-end">
                   <!-- <p><a href="./logout.php" class="logout-button">Cerrar Sesi&oacute;n</a></p> -->
					<a href="#" class="logout-button" onclick="confirmLogout(event)">Cerrar Sesi&oacute;n</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navbar con elementos y subelementos -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #A57F2C;">
    <div class="container-fluid">
        <!--<a class="navbar-brand" href="#">Mi Sitio</a> -->
		<a class="navbar-brand" href="" onclick="cargarVista('view/welcome.php');"><i class="fas fa-home"></i></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mis Cursos                    
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                        <li>
                        <a class="dropdown-item" href="#" onclick="cargarVista('./view/form_datosasesorinterno.php'); cerrarMenu();">
                                <i class="fas fa-user-graduate"></i> Datos
                            </a>
                        </li> 
                    </ul>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opciones
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#" onclick="cargarVista('./view/contrasena_nueva.php'); cerrarMenu();">Contraseña</a></li>
                    </ul>
                </li>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Main Content con iframe -->
	<div class="container mt-5" id="contenido">
    <iframe src="view/welcome.php" id="vistaFrame" style="width: 100%; height: 600px; border: none;"></iframe>
</div>

	<!--
    <div class="container mt-5" id="contenido">
        <iframe src="" id="vistaFrame" style="width: 100%; height: 600px; border: none;"></iframe>
    </div>
	-->

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 <a href="https://santamasoft.mx/" target="blank" >Santamasoft.</a> Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para cargar vistas en el iframe -->
    <script>
        function cargarVista(vista) {
            console.log("Cargando vista:", vista); // Verifica que se llama correctamente
            document.getElementById('vistaFrame').src = vista;
        }
		
		function cerrarMenu() {
    const menu = document.getElementById('navbarNav');
    const bsCollapse = bootstrap.Collapse.getInstance(menu); // Obtiene la instancia del menú colapsable
    if (bsCollapse) {
        bsCollapse.hide(); // Contrae el menú
    }
}


    </script>
	
	<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function confirmLogout(event) {
    // Evita la redirección del enlace
    event.preventDefault();
    
    // Muestra el cuadro de confirmación
    swal({
      title: "Salir",
      text: "¿Desea Salir del Sistema?",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then((willLogout) => {
      if (willLogout) {
        // Redirige al usuario si confirma
        window.location.href = "./logout.php";
      }
    });
  }
</script>
	
	
</body>
</html>
