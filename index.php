<!-- PHP INCLUDES -->

<?php

include "connect.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";

?>

<!-- SECCIÓN DE HOME -->

<section class="home-section" id="home-section">
    <div class="home-section-content">
        <div id="home-section-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#home-section-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#home-section-carousel" data-slide-to="1"></li>
                <li data-target="#home-section-carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <!-- PRIMER SLIDE -->
                <div class="carousel-item active">
                    <img class="d-block w-100" src="Design/images/barbershop_image_1.jpeg" alt="First slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Porque tu cabello merece lo mejor, ven a nuestra barbería y marca la diferencia</h3>
                        <p>
                            Vibrans Studio, donde el estilo no es una opción, es una prioridad!
                            <br>
                            No es solo un corte, es una experiencia.
                        </p>
                    </div>
                </div>
                <!-- SEGUNDO SLIDE -->
                <div class="carousel-item">
                    <img class="d-block w-100" src="Design/images/barbershop_image_2.jpg" alt="Second slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Calidad y estilo a tu alcance. ¡Haz tu cita ahora y luce impecable!</h3>
                        <p>
                            Vibrans Studio, donde el estilo no es una opción, es una prioridad!
                            <br>
                            No es solo un corte, es una experiencia.
                        </p>
                    </div>
                </div>
                <!-- TERCER SLIDE -->
                <div class="carousel-item">
                    <img class="d-block w-100" src="Design/images/barbershop_image_3.png" alt="Third slide">
                    <div class="carousel-caption d-md-block">
                        <h3>Cortes clásicos o modernos, nosotros lo hacemos todo</h3>
                        <p>
                            Vibrans Studio, donde el estilo no es una opción, es una prioridad!
                            <br>
                            No es solo un corte, es una experiencia.
                        </p>
                    </div>
                </div>
            </div>
            <!-- ANTERIOR & SIGUIENTE -->
            <a class="carousel-control-prev" href="#home-section-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previo</span>
            </a>
            <a class="carousel-control-next" href="#home-section-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
    </div>
</section>

<!-- SECCIÓN ACERCA DE NOSOTROS -->

<section id="about" class="about_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about_content" style="text-align: center;">                    
                    <h3>Vibrans Studio, donde el estilo no es una opción, es una prioridad! <br>Desde 1990</h3>
                    <img src="Design/images/about-logo.png" alt="logo">
                    <p style="color: #777">
                        Somos una barbería enfocada en nuestros clientes, antes de empezar analizamos tu fisonomía para recomendarte tu mejor corte.
                        Como siempre respetando tu criterio, tus gustos y preferencias ante todo.
                    </p>                    
                </div>
            </div>
            <div class="col-md-6  d-none d-md-block">
                <div class="about_img" style="overflow:hidden">
                    <img class="about_img_1" src="Design/images/about-1.jpeg" alt="about-1">
                    <img class="about_img_2" src="Design/images/about-2.jpg" alt="about-2">
                    <img class="about_img_3" src="Design/images/about-3.jpg" alt="about-3">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE SERVICIOS -->

<section class="services_section" id="services">
    <div class="container">
        <div class="section_heading">
            <h3>Vibrans Studio, donde el estilo no es una opción, es una prioridad!</h3>
            <h2>Nuestros Servicios</h2>
            <div class="heading-line"></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-scissors-1"></i>
                    <h3>Cortes de Cabello</h3>
                    <p>Cortes clásicos o modernos, nosotros lo hacemos todo. ¡Tu estilo, tu elección!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-razor-2"></i>
                    <h3>Barba</h3>
                    <p>Deja que nuestros expertos cuiden de tu barba, dándole forma, suavidad y un toque de distinción que atraerá todas las miradas.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-brush"></i>
                    <h3>Tratamientos</h3>
                    <p>Estos tratamientos ayudan a mantener una apariencia saludable y cuidada en cada área: facial, cabello, barba, etc.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 padd_col_res">
                <div class="service_box">
                    <i class="bs bs-hairbrush-1"></i>
                    <h3>Tintura</h3>
                    <p>Cambia tu look de forma natural con sutiles toques de color, cubriendo las canas o añadiendo reflejos que realcen tu estilo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE RESERVA -->

<section class="book_section" id="booking">
    <div class="book_bg"></div>
    <div class="map_pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <form action="appointment.php" method="post" id="appointment_form" class="form-horizontal appointment_form">
                    <div class="book_content">
                        <h2 style="color: white;">Reserva tu Cita</h2>
                        <p style="color: #999;">
                            En unos sencillos pasos, solo elige el/los servicio(s) que deseas <br> el barbero y la fecha y podrás reservar tu cita sin problemas.
                        </p>
                    
                    <!-- SECCIÓN DE AGENDAR -->

                    <button id="app_submit" class="default_btn" type="submit">
                        Reserva tu Cita
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE GALERIA -->

<section class="gallery-section" id="gallery">
    <div class="section_heading">
        <h3>Vibrans Studio, donde el estilo no es una opción, es una prioridad!</h3>
        <h2>Nuestros Clientes Felices</h2>
        <div class="heading-line"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-1.jpg');"> </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-2.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-3.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-4.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-5.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-6.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-7.jpg');"></div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 gallery-column">
                <div style="height: 230px">
                    <div class="gallery-img" style="background-image: url('Design/images/portfolio-8.jpg');"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE NUESTROS BARBEROS -->

<section id="team" class="team_section">
    <div class="container">
        <div class="section_heading ">
            <h3>Vibrans Studio, donde el estilo no es una opción, es una prioridad!</h3>
            <h2>Nuestros Barberos</h2>
            <div class="heading-line"></div>
        </div>
        <ul class="team_members row">
            <li class="col-lg-3 col-md-6 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-1.jpg" alt="Team Member">
                </div>
            </li>
            <li class="col-lg-3 col-md-6 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-2.jpg" alt="Team Member">
                </div>
            </li>
            <li class="col-lg-3 col-md-6 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-3.jpg" alt="Team Member">
                </div>
            </li>
            <li class="col-lg-3 col-md-6 padd_col_res">
                <div class="team_member">
                    <img src="Design/images/team-4.jpg" alt="Team Member">
                </div>
            </li>
        </ul>
    </div>
</section>

<!-- SECCIÓN DE PRECIOS  -->

<section class="pricing_section" id="pricing">

    <!-- EMPEZAR A OBTENER LOS PRECIOS DE LAS CATEGORÍAS DE LA BASE DE DATOS -->

    <?php

    $stmt = $con->prepare("Select * from service_categories");
    $stmt->execute();
    $categories = $stmt->fetchAll();

    ?>

    <!-- FIN -->

    <div class="container">
        <div class="section_heading">
            <h3>Somos tu mejor opción</h3>
            <h2>Nuestros Precios</h2>
            <div class="heading-line"></div>
        </div>
        <div class="row">
            <?php

            foreach ($categories as $category) {
                $stmt = $con->prepare("Select * from services where category_id = ?");
                $stmt->execute(array($category['category_id']));
                $totalServices =  $stmt->rowCount();
                $services = $stmt->fetchAll();

                if ($totalServices > 0) {
            ?>

                    <div class="col-lg-4 col-md-6 sm-padding">
                        <div class="price_wrap">
                            <h3><?php echo $category['category_name'] ?></h3>
                            <ul class="price_list">
                                <?php

                                foreach ($services as $service) {
                                ?>

                                    <li>
                                        <h4><?php echo $service['service_name'] ?></h4>
                                        <p><?php echo $service['service_description'] ?></p>
                                        <span class="price">$ <?php echo number_format($service['service_price'], 0, ',', '.'); ?></span>
                                    </li>

                                <?php
                                }

                                ?>

                            </ul>
                        </div>
                    </div>

            <?php
                }
            }

            ?>

        </div>
    </div>
</section>

<!-- SECCIÓN DE CONTACTO -->

<section class="contact-section" id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 sm-padding">
                <div class="contact-info">
                    <h2>
                        Si tienes alguna duda
                        <br>envianos un mensaje hoy!
                    </h2>
                    <p>
                        Estamos muy pendientes de nuestros clientes y sus consultas o sugerencias son muy importantes para nosotros.
                    </p>
                    <h3>
                        Cra. 40 # 56 Sur - 29
                        <br>
                        Sabaneta Antioquia, Colombia
                    </h3>
                    <h4>
                        <span style="font-weight: bold">Email:</span>
                        contacto@vibransstudio.com
                        <br>
                        <span style="font-weight: bold">Phone:</span>
                        +57 3106301190
                        <br>
                    </h4>
                </div>
            </div>
            <div class="col-lg-6 sm-padding">
                <div class="contact-form">
                    <div id="contact_ajax_form" class="contactForm">
                        <div class="form-group colum-row row">
                            <div class="col-sm-6">
                                <input type="text" id="contact_name" name="name" class="form-control" placeholder="Tu nombre">
                            </div>
                            <div class="col-sm-6">
                                <input type="email" id="contact_email" name="email" class="form-control" placeholder="Correo">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Asunto">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="contact_message" name="message" cols="30" rows="5" class="form-control message" placeholder="Mensaje"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button id="contact_send" class="default_btn">Enviar tu mensaje</button>
                            </div>
                        </div>
                        <img src="Design/images/ajax_loader_gif.gif" id="contact_ajax_loader" style="display: none">
                        <div id="contact_status_message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Footer  -->

<?php include "./Includes/templates/footer.php"; ?>