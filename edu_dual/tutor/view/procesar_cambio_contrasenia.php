<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'DBC.php';
require_once 'phpmail/PHPMailer.php';
require_once 'phpmail/SMTP.php';
require_once 'phpmail/Exception.php';

if (!isset($_SESSION['userId'])) {
    $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Debes iniciar sesión primero.'];
    header('Location: contrasena_nueva.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idusuario = $_SESSION['userId'];
    $contrasenia_actual = $_POST['contrasenia_actual'] ?? '';
    $contrasenia_nueva = $_POST['contrasenia_nueva'] ?? '';
    $contrasenia_confirmar = $_POST['contrasenia_confirmar'] ?? '';

    if (!$contrasenia_actual || !$contrasenia_nueva || !$contrasenia_confirmar) {
        $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Por favor llena todos los campos.'];
        header('Location: contrasena_nueva.php');
        exit;
    }

    if ($contrasenia_nueva !== $contrasenia_confirmar) {
        $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'La nueva contraseña y la confirmación no coinciden.'];
        header('Location: contrasena_nueva.php');
        exit;
    }

    try {
        $pdo = DBC::get();

        $stmt = $pdo->prepare("SELECT contrasenia, email, nombres, apellidos FROM usuarios WHERE idusuario = :id");
        $stmt->execute([':id' => $idusuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Usuario no encontrado.'];
            header('Location: contrasena_nueva.php');
            exit;
        }

        if (!password_verify($contrasenia_actual, $usuario['contrasenia'])) {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'La contraseña actual es incorrecta.'];
            header('Location: contrasena_nueva.php');
            exit;
        }

        $hashNueva = password_hash($contrasenia_nueva, PASSWORD_DEFAULT);

        $update = $pdo->prepare("UPDATE usuarios SET contrasenia = :nueva WHERE idusuario = :id");
        $update->execute([
            ':nueva' => $hashNueva,
            ':id' => $idusuario
        ]);

        if ($update->rowCount() > 0) {
            // Enviar correo
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'isc.jsantamaria@gmail.com'; // Tu correo
            $mail->Password = 'nkpiobcbrozjlijl'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('isc.jsantamaria@gmail.com', 'Soporte EduDual');
            $mail->addAddress($usuario['email'], $usuario['nombres'] . ' ' . $usuario['apellidos']);
            $mail->isHTML(true);
            $mail->Subject = 'Se ha detectado un cambio de clave en EduDual';
            $mail->Body = "
                <p>Hola <strong>" . htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) . "</strong>,</p>
                <p>Te confirmamos que tu contraseña ha sido cambiada correctamente.</p>
                <p>Si no realizaste esta acción, por favor contacta con soporte inmediatamente.</p>
                <hr>
                <p>Saludos,<br>Equipo EduDual</p>
            ";

            $mail->send();

            $_SESSION['mensaje'] = ['tipo' => 'success', 'texto' => 'Tu contraseña ha sido cambiada correctamente.'];
        } else {
            $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'No se pudo actualizar la contraseña.'];
        }

        header('Location: contrasena_nueva.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Error: ' . $e->getMessage()];
        header('Location: contrasena_nueva.php');
        exit;
    }
} else {
    $_SESSION['mensaje'] = ['tipo' => 'error', 'texto' => 'Acceso no permitido.'];
    header('Location: contrasena_nueva.php');
    exit;
}