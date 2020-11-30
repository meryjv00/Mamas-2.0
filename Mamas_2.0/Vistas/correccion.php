<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>   <!-- Bootstrap core CSS -->
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
        include_once '../Modelo/Pregunta.php';
        include_once '../Modelo/Respuesta.php';
        include_once '../Modelo/Correccion.php';
        include_once '../Modelo/Solucion.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $alumnosS = $_SESSION['alumnosExamen'];
        $examenS = $_SESSION['examenS'];
        if (isset($_SESSION['correccionS'])) {
            $correccionS = $_SESSION['correccionS'];
            $respuestasS = $correccionS->getRespuestas();
        } else {
            $correccionS = $examenS;
        }
        ?>
        <?php ?>
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
                                            btn-rounded waves-effect z-depth-1a" name="verExamenes" value="Ver exámenes">
                                        <i class="far fa-eye pr-1"></i> exámenes
                                    </button>
                                </li>
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
        <main class="pb-5 pt-5 ml-4 mb-5">
            <div class="container-fluid row ">
                <div class="col-md-3 mt-5 card card-cascade narrower align-self-start">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                        <!-- Title -->
                        <h2 class="card-header-title text-center titulo text-white pt-1">Exámenes pendientes</h2>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                        <!-- Text -->
                        <form id="formuAddPreguntas" action="../Controlador/controladorProfesor.php" method="post" novalidate>
                            <div class="col-md-12 mx-auto text-center">
                                <button type="submit" name="aniadirPreguntas" class="btn purple lighten-3 text-white 
                                        btn-block btn-rounded waves-effect z-depth-1a">Corregir automáticamente
                                </button>
                                <hr>
                                <?php
                                foreach ($alumnosS as $i => $alumno) {
                                    ?>
                                    <div class="card mt-2 orange lighten-3 white-text">
                                        <div class="row card-body d-flex justify-content-between align-items-center">
                                            <div class="col-md-1">
                                                <?php
                                                if ($alumno->getImagen() == "") {
                                                    ?>
                                                    <img class="rounded-circle" src="../img/defectousu.png" height="35px"/>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img class="rounded-circle" src="data:image/png;base64,<?php echo base64_encode($alumno->getImagen()); ?>" 
                                                         alt="titulo foto" class="img-fluid" height="35px"  width="35px"/>
                                                         <?php
                                                     }
                                                     ?>
                                            </div>
                                            <div class="col-md-10">
                                                <p class="mb-0 text-white text-left"><?= $alumno->getNombre() . ' ' ?><?= $alumno->getApellidos() ?></p>
                                            </div>

                                        </div>
                                        <button class="card-footer footer-hover small text-center white-text border-0 p-2" type="submit" name="<?= $i ?>" 
                                                value="Corregir">
                                            Corregir<i class="fas fa-arrow-circle-right pl-2"></i>
                                        </button>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-8 mx-auto mt-5 card card-cascade narrower">
                    <form name="examen" action="../Controlador/controladorProfesor.php" method="post">
                        <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                            <h2 class="card-header-title text-center titulo text-white pt-1">
                                <?php
                                if (isset($_SESSION['correccionS'])) {
                                    echo 'Exámen entregado';
                                } else {
                                    echo 'Exámen';
                                }
                                ?>
                            </h2>
                        </div>
                        <div class="card-body card-body-cascade text-center">
                            <!-- Title -->
                            <h3 class="font-weight-bold letra"><a><?= $examenS->getContenido() ?></a></h3>
                            <!-- Data -->
                            <p>Numero de preguntas: <?= count($examenS->getPreguntas()); ?></p>
                            <div class="mt-3">
                                <h3>Descripción</h3>
                                <p><?= $examenS->getDescripcion() ?></p>
                            </div>
                            <div class="row pt-3">
                                <div class="col-md-8 mx-auto border pb-3 ">
                                    <h3 class="text-center">Preguntas </h3>
                                    <?php
                                    $preguntas = $examenS->getPreguntas();
                                    $contOpciones = 0;
                                    $contPregunta = 0;
                                    foreach ($preguntas as $i => $pregunta) {
                                        $contPregunta++;
                                        ?>
                                        <section class="mx-auto mt-3 white-dark text-left purple lighten-4 rounded pt-2 pb-4 my-2">
                                            <div class="row px-4">
                                                <div class="col-md-12">
                                                    <h5><?= $contPregunta . '. ' ?><?= $pregunta->getEnunciado() ?> (<?= $pregunta->getPuntuacion() ?> puntos).</h5>
                                                </div>
                                                <?php
                                                $respuestas = $pregunta->getRespuestas();
                                                $contOpciones = 0;
                                                ?>
                                                <div class="col-md-12">
                                                    <?php
                                                    foreach ($respuestas as $j => $respuesta) {
                                                        $contOpciones++;
                                                        if ($pregunta->getTipo() == 1) {
                                                            //--
                                                            if (isset($_SESSION['correccionS'])) {
                                                                if ($respuestasS[$i]->getRespuesta() == $respuesta->getRespuesta()) {
                                                                    if ($respuesta->getCorrecta() == 1) {
                                                                        $color = "#237965";
                                                                    } else {
                                                                        $color = "#E25B64";
                                                                    }
                                                                    ?>
                                                                    <i class="fas fa-hand-point-right letra" style="color: <?= $color ?>"></i>
                                                                    <?php
                                                                } else {
                                                                    echo $contOpciones . ') ';
                                                                }
                                                                ?>
                                                                <span><?= $respuesta->getRespuesta() ?></span><br>
                                                                <?php
                                                            } else {
                                                                echo $contOpciones . ') ';
                                                                if ($pregunta->getTipo() == 1) {
                                                                    if ($respuesta->getCorrecta() == 0) {
                                                                        $icono = "fas fa-times";
                                                                    } else {
                                                                        $icono = "fas fa-check";
                                                                    }
                                                                } else {
                                                                    $icono = "fas fa-sort-alpha-up";
                                                                }
                                                                ?>
                                                                <span><?= $respuesta->getRespuesta() . '   ' ?><i class="<?= $icono ?> letra"></i></span><br>
                                                                <?php
                                                            }
                                                        } else {
                                                            if (isset($_SESSION['correccionS'])) {
                                                                if ($contOpciones == 1) {
                                                                    ?>

                                                                    <textarea style="resize: none;" readonly  rows="5" cols="10"  name="<?= $contPregunta ?>" class="form-control mb-3" ><?= $respuestasS[$i]->getRespuesta() ?></textarea>
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label for="nota">Puntuación: </label><input type="number" name="nota" class="form-control" max="<?= $pregunta->getPuntuacion() ?>" min="0">
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span><?= $contOpciones . ') ' . $respuesta->getRespuesta() ?></span><br>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>  
                                            </div>
                                        </section>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (isset($_SESSION['correccionS'])) {
                                    ?>
                                    <div class="col-md-8 mx-auto border pb-3 mt-3">
                                        <section class="mx-auto mt-3 white-dark text-left orange lighten-3 pt-1 rounded py-2 my-2">
                                            <div class="row px-4">
                                                <div class="col-md-12 mx-auto">
                                                    <h5 class="text-center">Anotación</h5>
                                                    <textarea style="resize: none;"   rows="5" cols="10"  name="" class="form-control mb-3" placeholder="Deje su valoración aquí..."></textarea>

                                                </div>
                                            </div>
                                        </section>
                                        <button type="submit" class="btn purple lighten-3 text-white
                                                btn-rounded waves-effect z-depth-1a" name="corregirExamen">Corregir
                                        </button> 
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </form>
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
        <script type="text/javascript" src="../js/validar.js"></script>
        <script type="text/javascript" src="../js/diseño.js"></script>
    </body>
</html>
