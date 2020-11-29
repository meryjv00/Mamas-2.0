<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio alumno</title>
        <!-- Bootstrap core CSS -->
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
        $asignaturas = $_SESSION['asignaturasImpartidas'];

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
        <main class="pb-5 pt-5 ml-4 mb-5">
            <div class="container-fluid row ">
                <div class="col-md-9 mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-5 bg-transparent">
                            <div class="view view-cascade gradient-card-header">
                                <!-- Title -->
                                <h2 class="card-header-title font-weight-bold text-center letra display-4 tit pt-2 pb-2">Mis asignaturas</h2>
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
                            </div>
                            <form class="row justify-content-center" name = "home" action = "<?= $controlador ?>" method = "post">
                                <?php
                                foreach ($asignaturas as $i => $asignatura) {
                                    ?>

                                    <div class="col-md-3 card  card-cascade narrower card-ecommerce mt-3 ml-3 mr-3" style="height: 280px" >
                                        <button class="border-0 bg-white" type="submit" name="<?= $i ?>" value="<?= $asignatura->getIdAsignatura() ?>"> <!-- Card image -->

                                            <div class="view bg-white overlay zoom" style="height: 200px">
                                                <img src="data:image/png;base64,<?php echo base64_encode($asignatura->getImagen()); ?>" alt="titulo foto" class="img-fluid"
                                                     />
                                                <div class="mask flex-center">
                                                    <p class="white-text"><i class="fas fa-arrow-right" style="color:#543b54;font-size: 40px"></i></p>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- Card image -->
                                        <!-- Card content -->
                                        <div class="card-body card-body-cascade text-center">
                                            <!-- Category & Title -->

                                            <h5><?= $asignatura->getNombre() ?></h5>

                                            <!-- Card content -->
                                        </div>

                                    </div>

                                    <?php
                                }
                                ?>
                            </form>

                        </div>

                    </div>

                </div>

                <div class="col-md-3 mt-5 card card-cascade narrower align-self-start">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                        <!-- Title -->
                        <h1 class="card-header-title text-center titulo text-white pt-1">Exámenes sin realizar</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                        <!-- Text -->
                        <form name="examenes" action="<?= $controlador ?>" method="post">
                            <?php foreach ($examenesPendientes as $key => $examenP) { ?>
                                <p  style="font-size: 20px;color: #4D2034"><i class="fas fa-angle-right pr-2" ></i><?= $examenP->getContenido() ?></p>
                                <p class="card-text"><?= $examenP->getDescripcion() ?></p>
                                <button type="submit" class="btn purple lighten-3 text-white
                                        btn-rounded waves-effect z-depth-1a" name="realizarExamen" value="<?= $examenP->getId() ?>">Realizar exámen
                                </button> 
                                <hr>
                                <?php
                            }
                            ?>

                        </form>
                    </div>
                </div>
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
