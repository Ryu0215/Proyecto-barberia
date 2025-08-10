<?php
    
    //PHP INCLUDES
    include "connect.php";

    // Se establece la zona horaria correcta para Colombia.
    // Esto asegura que todas las comparaciones de tiempo sean precisas.
    date_default_timezone_set('America/Bogota');

    if(isset($_POST['selected_employee']) && isset($_POST['selected_services']))
    {
        ?>

        <!-- ESTILOS PARA EL CALENDARIO -->
        <style type="text/css">
            .calendar_tab{background:white;margin-top:5px;width:100%;position:relative;box-shadow:rgba(60,66,87,0.04) 0px 0px 5px 0px,rgba(0,0,0,0.04) 0px 0px 10px 0px;overflow:hidden;border-radius:4px}.appointment_day{width:15%;text-align:center;display:flex;color:rgb(151,151,151);font-weight:700;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;font-size:14px;line-height:1.5}.appointments_days{border-top-left-radius:4px;border-top-right-radius:4px;display:flex;height:60px;position:relative;-webkit-box-pack:justify;justify-content:space-between;padding:10px;border-bottom:1px solid rgb(229,229,229)}.available_booking_hours{display:flex;-webkit-box-pack:justify;justify-content:space-between;padding:10px;border-radius:4px}.available_booking_hour:hover{font-weight:700}.available_booking_hour{font-size:14px;padding-top:25px;line-height:1.3;cursor:pointer}input[type=radio]{display:none}input[type=radio]:checked+label{font-weight:700}.available_booking_hours_colum{width:15%;text-align:center}
        </style>

        <!-- INICIO DEL SLOT DEL CALENDARIO -->
        <div class="calendar_slots" style="min-width: 600px;">

            <!-- ENCABEZADOS DE LOS PRÓXIMOS DÍAS -->
            <div class="appointments_days">
                <?php
                    // Muestra los encabezados de los próximos 10 días, empezando desde HOY.
                    for($i = 0; $i < 10; $i++) {
                        $appointment_date = date('Y-m-d', strtotime("+$i day"));
                        echo "<div class='appointment_day'>";
                        echo date('D', strtotime($appointment_date))."<br>";
                        echo date('d', strtotime($appointment_date))." ".date('M', strtotime($appointment_date));
                        echo "</div>";
                    } 
                ?>
            </div>

            <!-- COLUMNAS DE HORARIOS DISPONIBLES -->
            <div class='available_booking_hours'>
                <?php
                    $desired_services = $_POST['selected_services'];
                    $selected_employee = $_POST['selected_employee'];
                    $sum_duration = 0;
                    
                    foreach($desired_services as $service) {
                        $stmtServices = $con->prepare("select service_duration from services where service_id = ?");
                        $stmtServices->execute(array($service));
                        $rowS = $stmtServices->fetch();
                        $sum_duration += $rowS['service_duration'];
                    }
                    
                    $sum_duration_in_seconds = $sum_duration * 60;

                    // Bucle para generar las columnas de horarios, empezando desde HOY.
                    for($i = 0; $i < 10; $i++) {
                        echo "<div class='available_booking_hours_colum'>";
                        
                        $appointment_date = date('Y-m-d', strtotime("+$i day"));
                        $day_id = date('w', strtotime($appointment_date));
                        
                        if($day_id == 0) { $day_id = 7; }

                        $stmt_emp_schedule = $con->prepare("SELECT from_hour, to_hour FROM employees_schedule WHERE employee_id = ? AND day_id = ?");
                        $stmt_emp_schedule->execute(array($selected_employee, $day_id));
                        
                        if($stmt_emp_schedule->rowCount() > 0) {
                            $emp_schedule = $stmt_emp_schedule->fetch();
                            
                            $day_start_timestamp = strtotime($appointment_date . ' ' . $emp_schedule['from_hour']);
                            $day_end_timestamp = strtotime($appointment_date . ' ' . $emp_schedule['to_hour']);

                            for ($current_slot_start = $day_start_timestamp; $current_slot_start < $day_end_timestamp; $current_slot_start += (30 * 60)) {
                                
                                // *** ¡CORRECCIÓN CLAVE #2! ***
                                // Se comprueba que el horario a mostrar sea en el futuro.
                                if ($current_slot_start < time()) {
                                    continue; // Si la hora ya pasó, se salta al siguiente intervalo.
                                }

                                $current_slot_end = $current_slot_start + $sum_duration_in_seconds;

                                if ($current_slot_end > $day_end_timestamp) {
                                    break;
                                }

                                $start_time_to_check = date('Y-m-d H:i:s', $current_slot_start);
                                $end_time_to_check = date('Y-m-d H:i:s', $current_slot_end);

                                $stmt_conflict = $con->prepare("
                                    SELECT appointment_id FROM appointments
                                    WHERE employee_id = ? AND canceled = 0 AND
                                    (
                                        ? < end_time_expected AND ? > start_time
                                    )
                                ");
                                $stmt_conflict->execute(array($selected_employee, $start_time_to_check, $end_time_to_check));
                                
                                if($stmt_conflict->rowCount() == 0) {
                                    $start_time_formatted = date('H:i', $current_slot_start);
                                    $end_time_formatted = date('H:i', $current_slot_end);
                                    $radio_id = $appointment_date . "-" . str_replace(":", "", $start_time_formatted);
                                    $radio_value = $appointment_date . " " . $start_time_formatted . " " . $end_time_formatted;
                                    ?>
                                        <input type="radio" id="<?php echo $radio_id; ?>" name="desired_date_time" value="<?php echo $radio_value; ?>">
                                        <label class="available_booking_hour" for="<?php echo $radio_id; ?>"><?php echo $start_time_formatted; ?></label>
                                    <?php
                                }
                            }
                        }
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    <?php
    }
    else
    {
        header('location: index.php');
        exit();
    }
?>
