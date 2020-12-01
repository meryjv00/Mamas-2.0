<!DOCTYPE html>
<!--
Autor: Israel Molina Pulpon
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vista Examen</title>
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
        include_once '../Modelo/Pregunta.php';
        include_once '../Modelo/Respuesta.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
        $examen = $_SESSION['examenS'];
        $creador = $_SESSION['creadorEx'];
        ?>
        <!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
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
        <!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
        <main class="pt-5">
            <div class="container mt-5 ">
                <!--Section: Content-->
                <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                    <section class="mx-md-5 dark-grey-text">

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-12">

                                <!-- Card -->
                                <div class="card card-cascade wider reverse">
                                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                        <div class="row">
                                            <div class="mx-auto"></div>
                                            <h4 class="card-header-title  text-center titulo text-white pt-2 pb-2">Información exámen</h4>
                                            <div class="ml-auto mr-4 pb-2">
                                                <!-- Facebook -->
                                                <button name="corregir" data-toggle="tooltip" data-placement="top" title="Corregir exámen" class=" btn btn-outline-secondary btn-rounded btn-sm  purple lighten-3" ">
                                                    <i class="fas fa-file-signature" style="font-size: 20px ;color: white"></i>
                                                </button>
                                                <button name="asignarP" data-toggle="tooltip" data-placement="top" title="Asignar preguntas"  class=" btn btn-outline-secondary btn-rounded btn-sm  purple lighten-3" ">
                                                    <i class="far fa-file-powerpoint" style="font-size: 20px ;color: white"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card content -->
                                    <div class="card-body card-body-cascade text-center">
                                        <!-- Title --><?php
                                        if (isset($_SESSION['mensaje'])) {
                                            $mensaje = $_SESSION['mensaje'];
                                            ?>
                                            <div class="row">
                                                <div class="mx-auto text-center text-white badge badge-secondary mb-2"><?= $mensaje ?></div>
                                            </div>
                                            <?php
                                            unset($_SESSION['mensaje']);
                                        }
                                        ?>
                                        <h3 class="font-weight-bold "><a><?= $examen->getContenido() ?></a></h3>
                                        <!-- Data -->
                                        <p>Creado por: <?= $creador->getNombre(); ?></p>
                                        <p>Numero de preguntas: <?= count($examen->getPreguntas()); ?></p>
                                        <div class="mt-3">
                                            <h3>Descripción</h3>
                                            <p><?= $examen->getDescripcion() ?></p>
                                        </div>
                                        <div class="row pt-3 text-left">
                                            <div class="col-md-8 mx-auto border pb-3">
                                                <h3 class="text-center">Preguntas </h3>
                                                <?php
                                                $preguntas = $examen->getPreguntas();
                                                $contOpciones = 0;
                                                $contPregunta = 0;
                                                foreach ($preguntas as $i => $pregunta) {
                                                    $contPregunta++;
                                                    ?>
                                                    <section class="mx-auto mt-3 white-dark purple lighten-4 pt-1 rounded">
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
                                                            <div class="col-md-2 ml-auto">
                                                                <button type="submit" name="<?= $i ?>" value="Borrar" class=" btn purple lighten-2 text-white 
                                                                        btn-block waves-effect z-depth-1a"><i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <!-- Social shares -->

                                    </div>
                                    <!-- Card content -->

                                </div>
                                <!-- Card -->



                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                        <hr class="mb-5 mt-4">

                    </section>
                    <!--Section: Content-->
                </form>
            </div>
        </main>
        <!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
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
