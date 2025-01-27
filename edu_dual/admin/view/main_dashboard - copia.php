<?php
namespace Phppot;

use \Phppot\Member;

if (! empty($_SESSION["userId"])) {
    require_once __DIR__ . './../class/Member.php';
    $member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if(!empty($memberResult[0]["display_name"])) {
        $displayName = ucwords($memberResult[0]["display_name"]);
    } else {
        $displayName = $memberResult[0]["apellidos"]. " ". $memberResult[0]["nombres"];
		$profileName = $memberResult[0]["nombre_perfil"];
		$clave_sie = $memberResult[0]["clave_sie"];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AulaNET SIE</title>
	
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<style>
    #contenido {
        max-height: 500px; /* Ajusta la altura según necesites */
        overflow-y: auto;  /* Scroll vertical */
        overflow-x: hidden; /* Evita scroll horizontal si no es necesario */
        padding: 10px; /* Espaciado para el contenido */
        border: 1px solid #ccc; /* Opcional: borde para visualizar el contenedor */
        background-color: #f8f9fa; /* Opcional: color de fondo */
    }
</style>

</head>
<body>

    <!-- Header -->
	<!--
    <header class="text-white text-center py-3" style="background-color: #611232;">
        <h2>Bienvenido a la Ventana Principal</h2>
		<p><a href="./logout.php" class="logout-button">Cerrar Sesi&oacute;n</a></p>
    </header>
-->
<!-- Header -->
<header class="text-white text-center py-3" style="background-color: #611232;">
    <div class="container">
        <div class="row">
            <!-- Primera columna -->
            <div class="col-md-4">
                <h2>AulaNET SIE</h2>
            </div>
            <!-- Segunda columna -->
            <div class="col-md-4">
                <p> <b><?php  echo "Bienvenid@: " .$displayName; echo "<br>"; echo $profileName . " | " .$clave_sie; ?></b></p>
            </div>
			
            <!-- Tercera columna: imagen -->
			<!--
            <div class="col-md-3 text-end">
                <!--<img src="<?php //echo substr($memberResult[0]['foto'], 1); ?>" class="profile-photo" />
            </div>
			-->
            <!-- Cuarta columna: cerrar sesión -->
            <div class="col-md-4 text-end">
                <p><a href="./logout.php" class="logout-button">Cerrar Sesi&oacute;n</a></p>
            </div>
        </div>
    </div>
</header>


    <!-- Navbar con elementos y subelementos si queremos que sea bgcolor de bootstrap usamos este comentario-->
	<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-secondary"> -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #A57F2C;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Sitio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="cargarVista('bienvenida.html')">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="cargarVista('registros.html')">Registros</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administraci&oacute;n
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" onclick="cargarVista('view/cargar_datos.html')">Cargar Datos</a></li>
                            <li><a class="dropdown-item" href="#" onclick="cargarVista('opcion2.php?value=chiquiña')">Opción 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5" id="contenido">
        <!-- Aquí se cargarán las vistas dinámicamente -->
        <div class="alert alert-info text-center">
            <h2>Bienvenido a la plataforma</h2>
            <p>Por favor, selecciona una opción del menú para comenzar.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Mi Sitio. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para cargar vistas dinámicamente -->
    <script>
    function cargarVista(vista) {
        console.log("Cargando vista:", vista); // Verifica que se llama correctamente
        fetch(vista)
            .then(response => response.text())
            .then(data => {
                document.getElementById('contenido').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('contenido').innerHTML = '<div class="alert alert-danger">Error al cargar la vista.</div>';
                console.error('Error al cargar la vista:', error);
            });
    }
</script>
</body>
</html>
