<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio profesor</title>
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
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Asignatura.php';
        include_once '../Modelo/Examen.php';
        include_once '../Modelo/Pregunta.php';
        include_once '../Modelo/Respuesta.php';
        include_once '../Modelo/Alumno.php';
        include_once '../Modelo/Profesor.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignaturas = $_SESSION['asignaturasImpartidas'];
        $asignatura = $asignaturas[0];
        ?>
        <header>
            <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar colorNav">
                    <div class="container-fluid ml-5 mr-5">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <!--LEFT-->
                            <ul class="navbar-nav mr-auto smooth-scroll">
                                <!--CRUD ADMINISTRADOR-->
                                <?php
                                if ($usuario->getRol() == 2) {
                                    ?>
                                    <li class="nav-item">
                                        <button type="submit" class="btn mean-fruit-gradient text-white
                                                btn-rounded waves-effect z-depth-1a" name="CRUDadmin" value="CRUDadmin">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li  class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white
                                            btn-rounded waves-effect z-depth-1a" name="home" value="home">
                                        <i class="fas fa-home"></i>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white
                                            btn-rounded waves-effect z-depth-1a" name="homeInicio" value="homeInicio">
                                        <i class="far fa-eye pr-1"></i> alumno
                                    </button>
                                </li>
                            </ul>
                            <!--RIGHT-->
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white 
                                            btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                        <i class="fas fa-plus pr-1"></i> exámenes
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white 
                                            btn-rounded waves-effect z-depth-1a" name="crearPreguntas" value="Crear preguntas">
                                        <i class="fas fa-plus pr-1"></i>  preguntas
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white
                                            btn-rounded waves-effect z-depth-1a" name="perfil" value="Ver perfil">
                                        <i class="fas fa-user"></i>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="btn mean-fruit-gradient text-white
                                            btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </form>
        </header>
        <main class="pb-5 pt-5">
            <div class="container-fluid my-5">
                <div class="row altura d-flex justify-content-center align-items-center">
                    <div class="col-md-9 mx-auto">
                        <!-- Section: Block Content -->
                        <form action="../Controlador/controladorProfesor.php" method="post">
                            <div class="row mx-1 mb-4">
                                <div class=" bg-white mx-auto list-group-flush  rounded mb-4 col-md-4 " >
                                    <div class="row ">
                                        <img src="data:image/png;base64,<?php echo base64_encode($asignatura->getImagen()); ?>" alt="titulo foto" class=" mx-auto img-fluid" style=" height: 210px"/>
                                    </div>
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
                            <div class="row">
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
                                <div class="col-md-6  mb-4">
                                    <div class="card purple lighten-3 white-text">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="h2-responsive font-weight-bold mt-n2 mb-0"><?php
                                                    echo count($asignatura->getExamenes())
                                                    ?></p>
                                                <p class="mb-0">Exámenes </p>
                                            </div>
                                            <div>
                                                <i class="fas fa-feather-alt  fa-4x text-black-40"></i>
                                            </div>
                                        </div>
                                        <button class="card-footer footer-hover small text-center white-text border-0 p-2" type="submit" name="verExamenes">
                                            Más información<i class="fas fa-arrow-circle-right pl-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <div class="card orange lighten-3 white-text">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="h2-responsive font-weight-bold mt-n2 mb-0 pr-2"><i class="fas fa-graduation-cap fa-x "></i> </p>
                                                <p class="mb-0">Alumnos</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-user fa-4x text-black-40"></i>
                                            </div>
                                        </div>
                                        <button class="card-footer footer-hover small text-center white-text border-0 p-2" type="submit" name="verAlumnos">
                                            Más información<i class="fas fa-arrow-circle-right pl-2"></i>
                                        </button>                                        
                                    </div>
                                </div>
                            </div>
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
        <!-- Your custom scripts (optional) -->
    </body> 
</html>
