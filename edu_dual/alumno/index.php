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
		break;
		case 2: // se trata del perfil DOCENTE
		require_once __DIR__ . '/view/main_dashboard.php';
		break;
		case 3: // se trata del perfil COORDINACION
		break;
		case 4: // se trata del perfil PADRE DE FAMILIA/TUTOR
		break;
		case 5: // se trata del perfil ALUMNO
		require_once __DIR__ . '/view/main_dashboard.php';
		break;
		case 6: //se trata del AUXILIAR DE COORDINACION
		break;
		case 7: // se trata del perfil TUTOR
		break;
	}
	
} 

//esto es para saber que si no se ha logueado se manda al form de login
else {
    require_once __DIR__ . '/view/login-form.php';
}
?>