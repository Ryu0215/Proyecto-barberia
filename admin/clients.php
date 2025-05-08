<?php
session_start();

//Título de la página
$pageTitle = 'Clientes';

//Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

//Comprobar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
?>
    <!-- Comenzar contenido de la página -->
    <div class="container-fluid">

        <!-- Heading de la página -->

        <!-- Tabla de clientes -->
        <?php
        $stmt = $con->prepare("SELECT * FROM clients");
        $stmt->execute();
        $rows_clients = $stmt->fetchAll();
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Clientes</h6>
            </div>
            <div class="card-body">

                <!-- Tabla de clientes -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_clients as $client) {
                                echo "<tr>";
                                echo "<td>";
                                echo $client['client_id'];
                                echo "</td>";
                                echo "<td>";
                                echo $client['first_name'];
                                echo "</td>";
                                echo "<td>";
                                echo $client['last_name'];
                                echo "</td>";
                                echo "<td>";
                                echo $client['phone_number'];
                                echo "</td>";
                                echo "<td>";
                                echo $client['client_email'];
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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