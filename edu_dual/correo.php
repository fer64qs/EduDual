<?php
$nombre_destinatario = "Juan Pérez"; // Ejemplo de variable dinámica
$asunto = "Respuesta automática";
$mensaje = "Gracias por contactarnos. Nuestro equipo está trabajando en tu caso.";

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
        background-color: #611232;
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
          <img src='img/dgeti.png' alt='Logo Izquierdo' class='left-image'>
          <h1>Notificación Importante</h1>
          <img src='img/dgeti.png' alt='Logo Derecho' class='right-image'>
        </div>

        <div class='content'>
            <h2>Hola, $nombre_destinatario</h2>
            <p>$mensaje</p>
            <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #00264d; border-radius: 5px;'>
                <p><strong>Asunto:</strong> $asunto</p>
                <p><strong>Mensaje:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet facilisis urna.</p>
            </div>
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

echo $correo_html; // Para verificar el resultado
?>
