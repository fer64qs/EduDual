<?php
//error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmail/Exception.php';
require 'phpmail/PHPMailer.php';
require 'phpmail/SMTP.php';


//$continente=$_POST['continente'];
if (isset($_REQUEST['cuenta'])){
	 
	 $cuenta=$_REQUEST['cuenta'];
 }
 
 if (isset($_REQUEST['pass'])){
	 
	 $pass=$_REQUEST['pass'];
 }
 
 if (isset($_REQUEST['nombre'])){
	 
	 $nombre=$_REQUEST['nombre'];
 }
 
 if (isset($_REQUEST['email'])){
	 
	 $email=$_REQUEST['email'];
 }
 
 if (isset($_REQUEST['perfil'])){
	 
	 $perfil=$_REQUEST['perfil'];
 }

 
 $nombre_destinatario = "Juan Pérez"; // Ejemplo de variable dinámica
$asunto = "¡Bienvenido a EduDual! Aquí están tus datos de acceso";
$mensaje = "¡Nos complace darte la bienvenida a EduDual!<br><br> Tu cuenta ha sido creada con éxito, y ahora puedes acceder al sistema para gestionar tu perfil y aprovechar todas las funcionalidades que hemos diseñado para ti.
<br><br>
Aquí tienes tus datos de acceso:
<br><br>";

$correo_html = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Notificación</title>
   <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .header {
        background-color: #4caf50;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between; /* Coloca las imágenes en los extremos */
        color: #ffffff;
        font-size: 24px;
        font-weight: bold;
    }
    .header img {
        width: 50px; /* Ajusta el tamaño según tus necesidades */
        height: auto;
    }
    .header h1 {
        flex: 1; /* Ocupa el espacio restante */
        text-align: center;
        margin: 0;
    }
	
    .content {
        padding: 20px;
        color: #333333;
        line-height: 1.6;
    }
    .content h2 {
        color: #00264d;
        margin-top: 0;
    }
    .content p {
        margin: 10px 0;
    }
    .footer {
        text-align: center;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 14px;
        color: #666666;
    }
    .button {
        display: inline-block;
        background-color: #A57F2C;
        color: #ffffff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
    }
    .button:hover {
        background-color: #e65c00;
    }
</style>

</head>
<body>
    <div class='container'>
        <div class='header'>
          <!--<img src='https://i.ibb.co/x1BYLpr/dgeti.png' alt='Logo Izquierdo' class='left-image'>-->
          <!--<h1>Notificación EduDual</h1>-->
		  <h3 style='text-align: center; margin-bottom: 20px;'>Notificación Enviada desde EduDual</h3>
       
          <!--<img src='https://i.ibb.co/x1BYLpr/dgeti.png' alt='Logo Derecho' class='right-image'>-->
        </div>


        <div class='content'>
            <h2>Hola, $nombre</h2>
            <p>$mensaje</p>
            <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #00264d; border-radius: 5px;'>
                <p><strong>Usuario:</strong> $cuenta</p>
                <p><strong>Contraseña:</strong> $pass</p>
				
            </div>
			<br>Por motivos de seguridad, te recomendamos que sigas estos pasos:<br><br>

1. Accede al sistema a través del siguiente enlace: [URL del sistema]. <br>
2. Ingresa tus datos de usuario y contraseña. <br>
3. Cambia tu contraseña temporal por una nueva desde la sección de configuración de tu perfil. <br>
4. Si tienes alguna duda o necesitas asistencia, no dudes en contactarnos a través de [correo de soporte] o al teléfono [número de soporte].<br><br>

Estamos aquí para ayudarte a sacar el máximo provecho de EduDual. ¡Gracias por ser parte de nuestra comunidad!<br><br>

Saludos cordiales,<br>
El equipo de EduDual<br>
[Información de contacto adicional o redes sociales]
			
			
            <p style='text-align: center;'>
                <a href='https://www.tuweb.com/contacto' class='button'>Contactar soporte</a>
            </p>
        </div>
        <div class='footer'>
            <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
";
 
                $mensaje= $correo_html;
				
				
				
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'isc.jsantamaria@gmail.com';                     // SMTP username
    $mail->Password   = 'nkpiobcbrozjlijl';  //'nkpiobcbrozjlijl   'halamadrid2317                             // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('isc.jsantamaria@gmail.com', 'EduDual Info');
    $mail->addAddress($email, $nombre_destinatario);     // Add a recipient
    
	
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Bienvenido a EduDual. Tienes una nueva Cuenta de Usuario';
	//$mail->Body = 
    $mail->Body    = $mensaje."<br>"."<img src='http://imgfz.com/i/JuINg8w.png' width='860'><br>";
    //https://ibb.co/5TrDz6F
	//http://imgfz.com/i/riSP5Oa.png
	//
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'Message has been sent';
	//echo json_encode("success:"."Mensaje Enviado");
	echo json_encode(["success" => true, "message" => "Datos Enviados al Correo del Usuario"]);

} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   //echo json_encode("Error:".$mail->ErrorInfo);
   echo json_encode(["success" => false, "message" => $mail->ErrorInfo]);

}				
				
			
					
					
				
			 
?>