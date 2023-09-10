<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer_Lb/src/Exception.php';
require 'PHPMailer_Lb/src/PHPMailer.php';
require 'PHPMailer_Lb/src/SMTP.php';
//Load Composer's autoloader
// require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Habilitar salida de depuración detallada
    $mail->isSMTP();                                            // Enviar usando SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Configurar el servidor SMTP para enviar a través de Gmail
    $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
    $mail->Username   = 'soportecrazydriving@gmail.com';                     // Nombre de usuario SMTP
    $mail->Password   = 'rmzhqmjwqbkswubj';                               // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Habilitar cifrado TLS implícito
    $mail->Port       = 465;                                    // Puerto TCP para conectarse; usa 587 si has configurado `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Destinatarios
    $mail->setFrom('soportecrazydriving@gmail.com', 'Crazy Driving'); // Quien lo envía
    $mail->addAddress('soportecrazydriving@gmail.com', 'Charlie Montano');     // Agregar un destinatario

    // Adjuntos
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Agregar archivos adjuntos
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Nombre opcional

    // Contenido
    $mail->CharSet = 'UTF-8'; //caracteres especiales
    $mail->isHTML(true);                                  // Configurar el formato del correo como HTML
    $mensaje = 'Estos es un mensaje Cuaquiera DE Una Variable X ';
    $mail->Subject = 'Codigo De Cambio de Contraseña';
    $mail->AltBody = 'Este es el cuerpo en texto sin formato para clientes de correo que no admiten HTML';

    $mail->Body    = '<!DOCTYPE html>
    
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$mail->Subject.'</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
            }
            p {
                color: #666;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: #fff;
                text-decoration: none;
                border-radius: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Título del Correo Electrónico</h1>
            <p>'. $mail->AltBody. '</p>
            <p>'. $mensaje. '</p>
            <a href="#" class="button">Visitar Sitio Web</a>
        </div>
    </body>
    </html>
    ';

    $mail->send();
    echo 'Enviado correctamente ';
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}
