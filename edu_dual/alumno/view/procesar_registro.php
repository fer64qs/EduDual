<?php
/*
ini_set('display_errors', 0);  // Oculta cualquier error o advertencia en pantalla
ini_set('log_errors', 1);      // Habilita el registro de errores en un archivo de logs
error_reporting(E_ALL);        // Reporta todos los errores
*/

require_once "../class/DataSource.php";
require_once "../class/Member.php";

use Phppot\Member;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');  // Asegurar que siempre enviamos JSON

    // Obtener los datos del formulario
    $apellidos = strtoupper($_POST['apellidos']);
    $nombres = strtoupper($_POST['nombres']);
    $clave_sie = strtoupper($_POST['clave_sie']);
    $password = $_POST['contrasenia'];
    $confirmPassword = $_POST['confirm_contrasenia'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
	$idperfil = $_POST['perfil'];

    // Comprobar si las contraseñas coinciden
    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden."]);
        exit;
    }

    // Crear una instancia de la clase Member
    $member = new Member();

    // Verificar si el usuario ya existe en la base de datos
    $existingUser = $member->getUserByClaveSIEOrEmail($clave_sie, $email);

    if ($existingUser) {
        echo json_encode(["status" => "error", "message" => "El usuario con esa clave SIE o correo electrónico ya existe."]);
        exit;
    }

    // Procesar la imagen (si se seleccionó)
    $photo = null;
    if (!empty($_FILES["photo"]["name"])) {
        $targetDir = "../profiles_uploads/";
        $photo = $targetDir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
    }

    // Llamar a la función para insertar el nuevo registro
    $insertId = $member->addMember($apellidos, $nombres, $clave_sie, $password, $email, $telefono, $photo, $idperfil);

    // Comprobar si la inserción fue exitosa
    if ($insertId) {
        echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar el usuario."]);
    }
}
?>
