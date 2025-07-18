<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'DBC.php';
require_once 'phpmail/PHPMailer.php';
require_once 'phpmail/SMTP.php';
require_once 'phpmail/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    try {
        $pdo = DBC::get();

        // Buscar al usuario por email
        $stmt = $pdo->prepare("SELECT nombres, apellidos FROM usuarios WHERE email = :correo");
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $nombreCompleto = $usuario['nombres'] . ' ' . $usuario['apellidos'];

            // 1. Generar una contraseña temporal
            $nuevaContrasenia = bin2hex(random_bytes(4)); // 8 caracteres aleatorios
            $nuevaContraseniaHash = password_hash($nuevaContrasenia, PASSWORD_DEFAULT);

            // 2. Actualizar la nueva contraseña hasheada en la base de datos
            $updateStmt = $pdo->prepare("UPDATE usuarios SET contrasenia = :hash WHERE email = :correo");
            $updateStmt->execute([
                ':hash' => $nuevaContraseniaHash,
                ':correo' => $correo
            ]);

            // 3. Configurar y enviar correo
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'isc.jsantamaria@gmail.com';
            $mail->Password = 'nkpiobcbrozjlijl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('isc.jsantamaria@gmail.com', 'Soporte EduDual');
            $mail->addAddress($correo, $nombreCompleto);

            $mail->isHTML(true);
            $mail->Subject = 'Nueva credencial temporal para EduDual';
            $mail->Body = "
                <p>Hola <strong>$nombreCompleto</strong>,</p>
                <p>Hemos generado una nueva contraseña temporal para que accedas a EduDual:</p>
                <p><strong>Contraseña temporal:</strong> {$nuevaContrasenia}</p>
                <p>Te recomendamos cambiar esta contraseña una vez inicies sesión.</p>
                <hr>
                <p>Si no hiciste esta solicitud, puedes ignorar este correo.</p>
            ";

            $mail->send();
            echo "<script>alert('Se ha enviado una nueva contraseña temporal a tu correo.'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Correo no encontrado en la base de datos.'); window.history.back();</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error al enviar el correo: " . $mail->ErrorInfo . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Solicitud no válida.'); window.location.href='../index.php';</script>";
}
?>