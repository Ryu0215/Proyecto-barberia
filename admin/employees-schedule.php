<?php
session_start();

//Título de la página
$pageTitle = 'Horario de Emplead@s';

//Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

//Extra JS FILES
echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

//Comprobar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
?>
    <!-- Comenzar contenido de la página -->
    <div class="container-fluid">

        <!-- Heading de la página -->


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Horario de empleados</h6>
            </div>
            <div class="card-body">
                <div class="sb-entity-selector" style="max-width:300px;">
                    <form action="employees-schedule.php" method="POST">
                        <div class="form-group">
                            <label class="control-label" for="emloyee_schedule_select">
                                Seleccione empleado para configurar el horario:
                            </label>
                            <div style="display:inline-block;margin-bottom: 10px;">
                                <?php
                                $stmt = $con->prepare('select * from employees');
                                $stmt->execute();
                                $employees = $stmt->fetchAll();

                                echo "<select class='form-control' name='employee_selected'>";
                                foreach ($employees as $employee) {
                                    echo "<option value=" . $employee['employee_id'] . " " . ((isset($_POST['employee_selected']) && $_POST['employee_selected'] == $employee['employee_id']) ? 'selected' : '') . ">" . $employee['first_name'] . " " . $employee['last_name'] . "</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                            <button type="submit" name="show_schedule_sbmt" class="btn btn-primary">Mostrar horarios</button>
                        </div>
                    </form>
                </div>

                <div class="alert alert-info">
                    Configure los ajustes de su semana aquí. Simplemente seleccione la hora de inicio y la hora de finalización para configurar las horas de trabajo de los empleados.
                </div>


                <!-- PARTE DEL HORARIO -->

                <div class="sb-content" style="min-height: 500px;">
                    <?php

                    /** CUANDO SE PULSA EL BOTÓN MOSTRAR HORARIO **/

                    if (isset($_POST['show_schedule_sbmt'])) {
                    ?>
                        <form method="POST" action="employees-schedule.php">
                            <input type="hidden" name="employee_id" value="<?php echo $_POST['employee_selected']; ?>" hidden>
                            <div class="worktime-days">
                                <?php
                                $employee_id = $_POST['employee_selected'];
                                $stmt = $con->prepare('select * from employees e, employees_schedule es where es.employee_id = e.employee_id and e.employee_id = ?');
                                $stmt->execute(array($employee_id));
                                $employees = $stmt->fetchAll();

                                $days = array(
                                    "1" => "Lunes",
                                    "2" => "Martes",
                                    "3" => "Miercoles",
                                    "4" => "Jueves",
                                    "5" => "Viernes",
                                    "6" => "Sabado",
                                    "7" => "Domingo"
                                );

                                //Días disponibles
                                $av_days = array();
                                foreach ($employees as $employee) {
                                    $av_days[] = $employee['day_id'];
                                }

                                foreach ($days as $key => $value) {
                                    echo "<div class='worktime-day row'>";

                                    if (in_array($key, $av_days)) {
                                        echo "<div class='form-group  col-md-4'>";
                                        echo "<input name='" . $value . "' id='" . $key . "' class='sb-worktime-day-switch' type='checkbox' checked>";
                                        echo "<span class='day-name'>";
                                        echo $value;
                                        echo "</span>";
                                        echo "</div>";

                                        foreach ($employees as $employee) {
                                            if (in_array($key, $av_days) && $employee['day_id'] == $key) {
                                                echo "<div class='time_ col-md-8 row'>";
                                                echo "<div class='form-group col-md-6'>";
                                                echo "<input type='time' name='" . $value . "-from' value='" . $employee['from_hour'] . "' class='form-control'>";
                                                echo "</div>";
                                                echo "<div class='form-group col-md-6'>";
                                                echo "<input type='time' name='" . $value . "-to' value='" . $employee['to_hour'] . "'  class='form-control'>";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        }
                                    } else {
                                        echo "<div class='form-group  col-md-4'>";
                                        echo "<input name='" . $value . "' id='" . $key . "' class='sb-worktime-day-switch' type='checkbox'>";
                                        echo "<span class='day-name'>";
                                        echo $value;
                                        echo "</span>";
                                        echo "</div>";

                                        echo "<div class='time_ col-md-8 row' style='display:none;'>";
                                        echo "<div class='form-group col-md-6'>";
                                        echo "<input type='time' name='" . $value . "-from' value = '09:00' class='form-control'>";
                                        echo "</div>";
                                        echo "<div class='form-group col-md-6'>";
                                        echo "<input type='time' name='" . $value . "-to' value = '18:00' class='form-control'>";
                                        echo "</div>";
                                        echo "</div>";
                                    }

                                    echo "</div>";
                                }
                                ?>
                            </div>

                            <!-- BOTÓN GUARDAR HORARIO -->

                            <div class="form-group">
                                <button type="submit" name="save_schedule_sbmt" class="btn btn-info">Guardar horario</button>
                            </div>
                        </form>
                    <?php
                    }
                    ?>
                </div>

                <?php

                /** CUANDO SE PULSA EL BOTÓN DE GUARDAR HORARIO **/

                if (isset($_POST['save_schedule_sbmt'])) {
                    $days = array(
                        "1" => "Lunes",
                        "2" => "Martes",
                        "3" => "Miercoles",
                        "4" => "Jueves",
                        "5" => "Viernes",
                        "6" => "Sabado",
                        "7" => "Domingo"
                    );
                    $stmt = $con->prepare("delete from employees_schedule where employee_id = ?");
                    $stmt->execute(array($_POST['employee_id']));

                    foreach ($days as $key => $value) {
                        if (isset($_POST[$value])) {
                            $stmt = $con->prepare("insert into employees_schedule(employee_id,day_id,from_hour,to_hour) values(?, ?, ?,?)");
                            $stmt->execute(array($_POST['employee_id'], $key, $_POST[$value . '-from'], $_POST[$value . '-to']));

                            $message = "¡Ha actualizado con éxito el horario de los empleados!";

                ?>

                            <script type="text/javascript">
                                swal("Establecer horario de empleados", "¡Ha establecido con éxito el horario de los empleados!", "success").then((value) => {});
                            </script>

                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php

    //Include Footer
    include 'Includes/templates/footer.php';
} else {
    header('Location: login.php');
    exit();
}

?>