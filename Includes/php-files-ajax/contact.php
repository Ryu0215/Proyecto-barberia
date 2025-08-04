<?php
// Inicia las clases de PHPMailer en el espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga el autoloader de Composer. Esta línea es clave.
require '../../vendor/autoload.php';

// Incluye tus funciones
include '../functions/functions.php';

if (isset($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message'])) {

    $contact_name = test_input($_POST['contact_name']);
    $contact_email = test_input($_POST['contact_email']);
    $contact_subject = test_input($_POST['contact_subject']);
    $contact_message = test_input($_POST['contact_message']); 

    // Validación del correo
    if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        exit("<div class='alert alert-danger'>¡Correo electrónico no válido!</div>");
    }

    // Creación de una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ryuhoshi0215@gmail.com';        // <-- REEMPLAZA CON TU CORREO DE GMAIL
        $mail->Password   = 'wuqt ayps xahj dhms';           // <-- REEMPLAZA CON TU CONTRASEÑA DE APLICACIÓN DE 16 LETRAS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet = 'UTF-8';

        // Configuración de los correos
        $mail->setFrom('tu_correo@gmail.com', 'Contacto Vibrans Studio'); // Quien envía
        $mail->addAddress('carlosortizq@gmail.com');     // A quien le llega el mensaje (tu correo)
        $mail->addReplyTo($contact_email, $contact_name);          // A quien responder si le das "Responder" en tu gestor de correo

        // Contenido del correo
        $mail->isHTML(false); // El correo será texto plano
        $mail->Subject = "Mensaje de Contacto: " . $contact_subject;

        $body = "Has recibido un nuevo mensaje desde el formulario de contacto de Vibrans Studio:\n\n";
        $body .= "Nombre: " . $contact_name . "\n";
        $body .= "Correo del remitente: " . $contact_email . "\n\n";
        $body .= "Mensaje:\n" . $contact_message;

        $mail->Body = $body;

        // Enviar
        $mail->send();
        echo "<div class='alert alert-success'>El mensaje ha sido enviado con éxito. ¡Gracias por contactarnos!</div>";

    } catch (Exception $e) {
        // Si hay un error, muestra un mensaje más detallado para depuración.
        echo "<div class='alert alert-warning'>Ha ocurrido un problema al enviar el mensaje. Error: {$mail->ErrorInfo}</div>";
    }
}
?>