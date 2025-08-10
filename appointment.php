<!-- PHP INCLUDES -->

<?php

include "connect.php";
include "Includes/functions/functions.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";

?>
<!-- Hoja de estilo de la página de citas -->
<link rel="stylesheet" href="Design/css/appointment-page-style.css">

<!-- SECCIÓN DE RESERVA DE CITAS -->

<section class="booking_section">
    <div class="container">

        <?php

        if (isset($_POST['submit_book_appointment_form']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- RECOLECCIÓN Y LIMPIEZA DE DATOS ---

            // Servicios, Empleado y Horario Seleccionados
            $selected_services = $_POST['selected_services'];
            $selected_employee = $_POST['selected_employee'];
            $selected_date_time = explode(' ', $_POST['desired_date_time']);
            $date_selected = $selected_date_time[0];
            $start_time = $date_selected . " " . $selected_date_time[1];
            $end_time = $date_selected . " " . $selected_date_time[2];

            // Detalles del Cliente (Sanitizados)
            $client_first_name = test_input($_POST['client_first_name']);
            $client_last_name = test_input($_POST['client_last_name']);
            $client_phone_number = test_input($_POST['client_phone_number']);
            $client_email = test_input($_POST['client_email']);

            // --- LÓGICA DE BASE DE DATOS CON TRANSACCIÓN ---
            
            $con->beginTransaction();

            try {
                
                // Paso 1: Verificar si el cliente existe. Si no, crearlo.
                $stmtCheckClient = $con->prepare("SELECT client_id FROM clients WHERE client_email = ?");
                $stmtCheckClient->execute(array($client_email));
                $client_result = $stmtCheckClient->fetch();
                
                $client_id = null;

                if ($stmtCheckClient->rowCount() > 0) {
                    // El cliente ya existe, usamos su ID.
                    $client_id = $client_result["client_id"];
                } else {
                    // El cliente es nuevo, lo insertamos en la base de datos.
                    $stmtClient = $con->prepare("INSERT INTO clients(first_name, last_name, phone_number, client_email) VALUES(?, ?, ?, ?)");
                    $stmtClient->execute(array($client_first_name, $client_last_name, $client_phone_number, $client_email));
                    
                    // Obtenemos el ID del cliente recién creado.
                    $client_id = $con->lastInsertId();
                }

                // Paso 2: Crear la cita.
                $stmt_appointment = $con->prepare("INSERT INTO appointments(date_created, client_id, employee_id, start_time, end_time_expected) VALUES(?, ?, ?, ?, ?)");
                $stmt_appointment->execute(array(Date("Y-m-d H:i"), $client_id, $selected_employee, $start_time, $end_time));
                
                // Obtenemos el ID de la cita recién creada.
                $appointment_id = $con->lastInsertId();

                // Paso 3: Vincular los servicios a la cita.
                foreach ($selected_services as $service) {
                    $stmt = $con->prepare("INSERT INTO services_booked(appointment_id, service_id) VALUES(?, ?)");
                    $stmt->execute(array($appointment_id, $service));
                }

                // Si todo fue exitoso, confirmamos la transacción.
                $con->commit();

                echo "<div class = 'alert alert-success'>";
                echo "¡Excelente! Tu cita ha sido creada con éxito.";
                echo "</div>";

            } catch (Exception $e) {
                // Si algo falla, revertimos todos los cambios.
                $con->rollBack();
                echo "<div class = 'alert alert-danger'>";
                echo "Ha ocurrido un error al procesar tu cita: " . $e->getMessage();
                echo "</div>";
            }
        }

        ?>

        <!-- FORMULARIO DE RESERVA -->

        <form method="post" id="appointment_form" action="appointment.php">

            <!-- SELECCIÓN DE SERVICIO -->

            <div class="select_services_div tab_reservation" id="services_tab">

                <!-- MENSAJE DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    ¡Por favor, seleccione al menos un servicio!
                </div>

                <div class="text_header">
                    <span>
                        1. Escoge el servicio que requieres:
                    </span>
                </div>

                <!-- TABLA DE SERVICIOS -->

                <div class="items_tab">
                    <?php
                    $stmt = $con->prepare("Select * from services");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();

                    foreach ($rows as $row) {
                        echo "<div class='itemListElement'>";
                        echo "<div class = 'item_details'>";
                        echo "<div>";
                        echo $row['service_name'];
                        echo "</div>";
                        echo "<div class = 'item_select_part'>";
                        echo "<span class = 'service_duration_field'>";
                        echo $row['service_duration'] . " min";
                        echo "</span>";
                        echo "<div class = 'service_price_field'>";
                        echo "<span style = 'font-weight: bold;'>";
                        echo "$ " . number_format($row['service_price'], 0, ',', '.');
                        echo "</span>";
                        echo "</div>";
                    ?>
                        <div class="select_item_bttn">
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="service_label item_label btn btn-secondary">
                                    <input type="checkbox" name="selected_services[]" value="<?php echo $row['service_id'] ?>" autocomplete="off">Fijar
                                </label>
                            </div>
                        </div>
                    <?php
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- SELECCIÓN DE EMPLEADO -->

            <div class="select_employee_div tab_reservation" id="employees_tab">

                <!-- MENSAJE DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    Por favor, seleccione un Barbero!
                </div>

                <div class="text_header">
                    <span>
                        2. Elección del Barbero
                    </span>
                </div>

                <!-- TABLA DE EMPLEADOS -->

                <div class="btn-group-toggle" data-toggle="buttons">
                    <div class="items_tab">
                        <?php
                        $stmt = $con->prepare("Select * from employees");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();

                        foreach ($rows as $row) {
                            echo "<div class='itemListElement'>";
                            echo "<div class = 'item_details'>";
                            echo "<div>";
                            echo $row['first_name'] . " " . $row['last_name'];
                            echo "</div>";
                            echo "<div class = 'item_select_part'>";
                        ?>
                            <div class="select_item_bttn">
                                <label class="item_label btn btn-secondary active">
                                    <input type="radio" class="radio_employee_select" name="selected_employee" value="<?php echo $row['employee_id'] ?>">Seleccionar
                                </label>
                            </div>
                        <?php
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>


            <!-- SELECCIÓN DE FECHA Y HORA -->

            <div class="select_date_time_div tab_reservation" id="calendar_tab">

                <!-- MENSAJE DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    Por favor, selecciona hora de tu reserva!
                </div>

                <div class="text_header">
                    <span>
                        3. Elección de fecha y hora:
                    </span>
                </div>

                <div class="calendar_tab" style="overflow-x: auto;overflow-y: visible;" id="calendar_tab_in">
                    <div id="calendar_loading">
                        <img src="Design/images/ajax_loader_gif.gif" style="display: block;margin-left: auto;margin-right: auto;">
                    </div>
                </div>

            </div>


            <!-- DETALLES DEL CLIENTE -->

            <div class="client_details_div tab_reservation" id="client_tab">

                <div class="text_header">
                    <span>
                        4. Tu información de Cliente:
                    </span>
                </div>

                <div>
                    <div class="form-group colum-row row">
                        <div class="col-sm-6">
                            <input type="text" name="client_first_name" id="client_first_name" class="form-control" placeholder="Nombre">
                            <span class="invalid-feedback">Este campo es requerido</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="client_last_name" id="client_last_name" class="form-control" placeholder="Apellido">
                            <span class="invalid-feedback">Este campo es requerido</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="email" name="client_email" id="client_email" class="form-control" placeholder="Correo">
                            <span class="invalid-feedback">Dirección de Correo Inválido</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="client_phone_number" id="client_phone_number" class="form-control" placeholder="Teléfono Móvil">
                            <span class="invalid-feedback">Número de Teléfono Inválido</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- BOTONES DE SIGUIENTE Y ANTERIOR -->

            <div style="overflow:auto;padding: 30px 0px;">
                <div style="float:right;">
                    <input type="hidden" name="submit_book_appointment_form">
                    <button type="button" id="prevBtn" class="next_prev_buttons" style="background-color: #bbbbbb;" onclick="nextPrev(-1)">Previo</button>
                    <button type="button" id="nextBtn" class="next_prev_buttons" onclick="nextPrev(1)">Próximo</button>
                </div>
            </div>

            <!-- Círculos que indican los pasos del formulario: -->

            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>

        </form>
    </div>
</section>

<!-- BOTÓN DE FOOTER -->

<?php include "Includes/templates/footer.php"; ?>
