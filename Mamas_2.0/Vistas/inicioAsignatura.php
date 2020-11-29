<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title> <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="../css/mdb.min.css">
        <!-- Your custom styles (optional) -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    </head>
    <body>
        <?php
        include_once '../Modelo/Asignatura.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Profesor.php';
        include_once '../Modelo/Alumno.php';
        include_once '../Modelo/Examen.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignaturaS = $_SESSION['asignaturaS'];
        if ($usuario->getRol() == 0) {
            $examenesPendientes = $_SESSION['examenesPendientes'];
            $controlador = '../Controlador/controladorAlumno.php';
        } else {
            $examenesPendientes = $_SESSION['examenesPendientes'];
            $controlador = '../Controlador/controlador.php';
        }
        ?>
        <header class="bg-white">
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top colorNav">
                <div class="container-fluid">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item">
                            <form name = "home" action = "<?= $controlador ?>" method = "post">
                                <button type="submit" class="btn mean-fruit-gradient text-white
                                        btn-rounded waves-effect z-depth-1a" name="home" value="home">
                                    <i class="fas fa-home"></i>
                                </button>
                                <?php
                                if ($usuario->getRol() == 1 || $usuario->getRol() == 2) {
                                    ?>
                                    <button type="submit" class="btn mean-fruit-gradient text-white
                                            btn-rounded waves-effect z-depth-1a" name="salirAlumno" value="salirAlumno">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <?php
                                }
                                ?>

                            </form>
                        </li> 
                    </ul>
                    <ul class="navbar-nav ml-auto mr-5">
                        <li class="nav-item">
                            <form name="cerrarSes" action="<?= $controlador ?>" method="post">
                                <button type="submit" class="btn mean-fruit-gradient text-white
                                        btn-rounded waves-effect z-depth-1a" name="perfil" value="Ver perfil">
                                    <i class="fas fa-user"></i>
                                </button>
                                <button type="submit" class="btn mean-fruit-gradient text-white
                                        btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </li> 
                    </ul>
                </div>
            </nav>
        </header>
        <main class="pb-5 pt-5">
            <?php
            if (isset($_SESSION['mensaje'])) {
                $mensaje = $_SESSION['mensaje'];
                ?>
                <div class="row">
                    <div class="mx-auto text-center text-white badge badge-secondary"><?= $mensaje ?></div>
                </div>
                <?php
                unset($_SESSION['mensaje']);
            }
            ?>
            <div class="container-fluid my-4 py-4">

                <!-- Section: Block Content -->
                <section class="row">

                    <style>
                        .footer-hover {
                            background-color: rgba(0, 0, 0, 0.1);
                            -webkit-transition: all .3s ease-in-out;
                            transition: all .3s ease-in-out
                        }

                        .footer-hover:hover {
                            background-color: rgba(0, 0, 0, 0.2)
                        }

                        .text-black-40 {
                            color: rgba(0, 0, 0, 0.4)
                        }
                    </style>
                    <div class="col-md-9 mx-auto">
                        <div class="row mx-1">
                            <div class="bg-white mx-auto list-group-flush  rounded mb-4 col-md-4 ">
                                <img src="data:image/png;base64,<?php echo base64_encode($asignaturaS->getImagen()); ?>" alt="titulo foto" class="img-fluid"/>
                                <div class="bg-white list-group-item active d-flex justify-content-start align-items-center py-3">
                                    <?php
                                    if ($usuario->getImagen() == "") {
                                        ?>
                                        <img class="rounded-circle" src="../img/defectousu.png" height="50"/>
                                        <?php
                                    } else {
                                        ?>
                                        <img src="data:image/png;base64,<?php echo base64_encode($usuario->getImagen()); ?>" class="rounded-circle z-depth-0" width="50" alt="avatar image">
                                        <?php
                                    }
                                    ?>
                                    <div class="d-flex flex-column pl-3 ">
                                        <p class="font-weight-bold letra titulo mb-0"> <?php echo $usuario->getNombre(); ?></p>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6  mb-4">

                                <!-- Card -->
                                <div class="card  orange lighten-3 white-text">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">150</p>
                                            <p class="mb-0">Exámenes pendientes</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-hourglass-end fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6  mb-4">

                                <!-- Card -->
                                <div class="card purple lighten-3 white-text">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">53 %</p>
                                            <p class="mb-0">Exámenes realizados</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-feather-alt  fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6  mb-4">

                                <!-- Card -->
                                <div class="card purple lighten-3 white-text">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">44</p>
                                            <p class="mb-0">Exámenes corregidos</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-check-double fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6  mb-4">

                                <!-- Card -->
                                <div class="card orange lighten-3 white-text">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">65</p>
                                            <p class="mb-0">Resultados</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-chart-pie fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->
                        </div>
                    </div>
                    <!-- Grid row -->

                </section>
                <!-- Section: Block Content -->

            </div>

        </main>
        <footer class="footer-copyright text-center text-white py-3 z-depth-2 colorNav fixed-bottom">
            <div> © 2020 Copyright: Israel y María</div>
        </footer>
        <!-- jQuery -->
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="../js/mdb.min.js"></script>
    </body>
</html>
