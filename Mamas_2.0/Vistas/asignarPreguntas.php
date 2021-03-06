<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asignar preguntas</title>
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
        include_once '../Modelo/Pregunta.php';
        include_once '../Modelo/Respuesta.php';
        include_once '../Modelo/Examen.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Profesor.php';
        include_once '../Modelo/Alumno.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $examenS = $_SESSION['examenS'];
        if (isset($_SESSION['preguntasCreadas'])) {
            $preguntasCreadas = $_SESSION['preguntasCreadas'];
        }
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
        <main class="pt-5 pb-5 ml-4 align-content-center">
            <div class="container-fluid row ">
                <div class=" col-md-8 mx-auto mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-2 bg-white">
                            <form name="formPreg" action="../Controlador/controladorProfesor.php" method="post">
                                <div class="row view view-cascade gradient-card-header mean-fruit-gradient py-1">
                                    <div class="mx-auto"></div>
                                    <h2 class="card-header-title  mx-auto text-center titulo text-white py-2 ">Añadir preguntas a exámen</h2>
                                    <button type="submit" name="verExamenS" data-toggle="tooltip" data-placement="top" title="Ver exámen en detalle"  
                                            class="btn btn-outline-secondary btn-rounded btn-sm  purple lighten-3 ml-auto mr-3">
                                        <i class="far fa-eye" style="font-size: 20px ;color: white"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="justify-content-center">
                                <form name="formPreg" action="../Controlador/controladorProfesor.php" method="post">
                                    <!--Section: Content-->
                                    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text mt-3">
                                        <!--Grid row-->
                                        <div class="row d-flex justify-content-center">
                                            <!--Grid column-->
                                            <div class="col-md-10">
                                                <div class="form-row">
                                                    <div class="border w-100">
                                                        <h3 class="text-center">Información exámen</h3>
                                                        <ul class="pr-2">
                                                            <li><?= $examenS->getContenido() ?></li>
                                                            <li><?= $examenS->getDescripcion() ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <!--Asignatura-->
                                                    <div class="form-row col-12">
                                                        <div class="col-md-6">
                                                            <button type="submit" name="crearPreguntasEx"  class="btn purple lighten-3 text-white 
                                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Crear preguntas
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" name="verPreguntasCreadas"  class="btn purple lighten-3 text-white 
                                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Ver preguntas creadas
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row mt-2">
                                                    <div class="border w-100 px-3 pb-3">

                                                        <?php
                                                        if (isset($preguntasCreadas)) {
                                                            ?>
                                                            <h3 class="text-center">Preguntas a añadir 
                                                                <span class="badge badge-secondary"><?= count($preguntasCreadas) ?></span>
                                                            </h3>
                                                            <?php
                                                            $contOpciones = 0;
                                                            $contPregunta = 0;
                                                            foreach ($preguntasCreadas as $i => $pregunta) {
                                                                $contPregunta++;
                                                                ?>
                                                                <div class="container mt-3 z-depth-1 px-0 rounded ">
                                                                    <!--Section: Content-->
                                                                    <section class="white-dark purple lighten-4 pt-1 rounded pr-1">
                                                                        <div class="row px-4">
                                                                            <div class="col-md-12">
                                                                                <h5><?= $contPregunta . '. ' ?><?= $pregunta->getEnunciado() ?></h5>
                                                                            </div>

                                                                            <?php
                                                                            $respuestas = $pregunta->getRespuestas();
                                                                            if ($pregunta->getTipo() == 0) {
                                                                                $txt = "Palabras claves:";
                                                                            } else {
                                                                                $txt = "Opciones:";
                                                                            }
                                                                            ?>
                                                                            <span class="col-md-12 mt-1"><?= $txt ?></span>
                                                                            <div class="col-md-12">
                                                                                <?php
                                                                                foreach ($respuestas as $j => $respuesta) {
                                                                                    $contOpciones++;
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
                                                                                    <span><?= $contOpciones . ') ' . $respuesta->getRespuesta() ?> <i class="<?= $icono ?> letra"></i></span><br>
                                                                                    <?php
                                                                                }
                                                                                $contOpciones = 0;
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-2  ml-auto">
                                                                                <button type="submit" name="<?= $i ?>" value="Quitar" class="btn  purple lighten-2 text-white 
                                                                                        btn-block waves-effect z-depth-1a"><i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <ul class="pr-2">
                                                                <li>Añade nuevas preguntas a tu exámen, creandolas manualmente o eligiendolas desde el banco de preguntas.</li>
                                                            </ul>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <button type="submit" name="aniadirPreguntasExamen"  class="col-md-6 mx-auto btn purple lighten-3 text-white 
                                                            btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir preguntas al exámen
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                            </div>
                        </div>
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
        <script type="text/javascript" src="../js/validar.js"></script>
        <script type="text/javascript" src="../js/diseño.js"></script>
    </body>
</html>
