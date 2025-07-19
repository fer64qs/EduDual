<?php
session_start();
if(!empty($_SESSION["userId"])) {
	
	//aqui debemos de hacer un switch para leer el valor:   $_SESSION["idperfil"]
	//que representa el idperfil del perfil que tiene el usuario y con ello mandar en cada case
	// require_once __DIR__ . '/view/ARCHIVO_QUE_CORRESPONDA.php';
    
	
	//require_once __DIR__ . '/view/dashboard.php';
	
	$variable = $_SESSION["idperfil"];
	//echo "La variable es: " . $variable;
	
	switch($variable){
		case 1: //se trata del perfil ADMINISTRADOR
		case 2: // se trata del perfil DOCENTE
		case 3: // se trata del perfil COORDINACION
		case 4: // se trata del perfil PADRE DE FAMILIA/TUTOR
		case 5: // se trata del perfil ALUMNO
		            // Mostrar mensaje de que el módulo no está disponible
            echo "<script>
                    alert('El módulo al que ha ingresado no es el correcto.');
                    window.location.href = '../index.html';
                  </script>";
            session_destroy(); // opcional: cerrar sesión
            exit;
            break;
		case 6: //se trata del AUXILIAR DE COORDINACION
		require_once __DIR__ . '/view/main_dashboard.php';
		break;
		case 7: // se trata del perfil TUTOR
		            // Mostrar mensaje de que el módulo no está disponible
            echo "<script>
                    alert('El módulo al que ha ingresado no es el correcto.');
                    window.location.href = '../index.html';
                  </script>";
            session_destroy(); // opcional: cerrar sesión
            exit;
            break;
	}
	
} 

//esto es para saber que si no se ha logueado se manda al form de login
else {
    require_once __DIR__ . '/view/login-form.php';
}
?>