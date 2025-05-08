<?php
    include "../functions/functions.php";

    if (isset($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message'])) {

        $contact_name = test_input($_POST['contact_name']);
        $contact_email = test_input($_POST['contact_email']);
        $contact_subject = test_input($_POST['contact_subject']);
        $contact_message = test_input($_POST['contact_message']);  

        if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            exit("<div class='alert alert-danger'>¡Correo electrónico no válido!</div>");
        }

        $to = "info@tubarberia.com"; // Reemplaza con tu dirección real
        $body = "Nombre: $contact_name\n";
        $body .= "Correo: $contact_email\n\n";
        $body .= "Mensaje:\n$contact_message\n";
        $headers = "From: $contact_name <$contact_email>\r\n";

        try {
            mail($to, $contact_subject, $body, $headers);
            echo "<div class='alert alert-success'>El mensaje ha sido enviado con éxito.</div>";
        } catch(Exception $ex) {
            echo "<div class='alert alert-warning'>Ha ocurrido un problema al enviar el mensaje, por favor intenta más tarde.</div>";
        }
    }
?>
