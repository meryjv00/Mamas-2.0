<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
        include_once '../Modelo/Solucion.php';
        include_once '../Modelo/Correccion.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
        $examen = $_SESSION['examenSeleccionado'];
        $solucion = $_SESSION['solucionSeleccionada'];
        $correccion = $solucion->getCorreccion();
        $notas = $correccion->getNotas();
        $respuestasSolucion = $solucion->getRespuestas();
        $notaTotal = $_SESSION['notaTotal'];
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top colorNav">
                <div class="container-fluid">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item">
                            <!--CRUD ADMINISTRADOR-->
                            <form name="home" action="../Controlador/controladorAlumno.php" method="post">
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
                            <form name="cerrarSes" action="../Controlador/controladorAlumno.php" method="post">
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
        <main class="pt-5">
            <div class="container mt-5 ">
                <!--Section: Content-->
                <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                    <section class="mx-md-5 dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-cascade wider reverse">
                                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                        <h4 class="card-header-title  text-center titulo text-white pt-2 pb-2">Exámen</h4>
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
                                        <span class="badge fa-2x badge-pill badge-secondary mb-2"><?php echo $notas[0] . '/' . $notaTotal; ?></span>
                                        <p>Numero de preguntas: <?= count($examen->getPreguntas()); ?></p>

                                        <div class="mt-3">
                                            <h3 class="font-weight-bold">Descripción</h3>
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
                                                    <section class="mx-auto mt-3 white-dark purple lighten-4 py-3 pt-1 rounded">
                                                        <div class="row px-4">
                                                            <div class="col-md-12">
                                                                <h5><?= $contPregunta . '. ' ?><?= $pregunta->getEnunciado() ?><?= ' (' . $pregunta->getPuntuacion() . ' puntos)' ?> </h5> 
                                                            </div>

                                                            <?php
                                                            $respuestas = $pregunta->getRespuestas();
                                                            ?>

                                                            <div class="col-md-12">
                                                                <?php
                                                                foreach ($respuestas as $j => $respuesta) {
                                                                    $contOpciones++;
                                                                    if ($pregunta->getTipo() == 1) {
                                                                        if ($respuestasSolucion[$i]->getRespuesta() == $respuesta->getRespuesta()) {
                                                                            if ($respuesta->getCorrecta() == 1) {
                                                                                $color = "#237965";
                                                                            } else {
                                                                                $color = "#E25B64";
                                                                            }
                                                                            ?>
                                                                            <i class="fas fa-hand-point-right letra" style="color: <?= $color ?>"></i>
                                                                            <?php
                                                                        }
                                                                        if ($respuesta->getCorrecta() == 0) {
                                                                            $icono = "fas fa-times";
                                                                        } else {
                                                                            $icono = "fas fa-check";
                                                                        }
                                                                        ?>  <span><?= $contOpciones . ') ' . $respuesta->getRespuesta() ?> <i class="<?= $icono ?> letra"></i></span><br>
                                                                        <?php
                                                                    } else {
                                                                        if ($contOpciones == 1) {
                                                                            ?><textarea style="resize: none;" readonly  rows="5" cols="10"  class="form-control mb-3" ><?= $respuestasSolucion[$i]->getRespuesta() ?></textarea><?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    <?php
                                                                }
                                                                $contOpciones = 0;
                                                                ?>
                                                            </div>
                                                        </div>

                                                    </section>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-md-8 mx-auto border pb-3 mt-3">
                                                <section class="mx-auto mt-3 white-dark text-left orange lighten-3 pt-1 rounded py-2 my-2">
                                                    <div class="row px-4">
                                                        <div class="col-md-12 mx-auto">
                                                            <h5 class="text-center">Anotación</h5>
                                                            <textarea style="resize: none;"  readonly  rows="5" cols="10"  class="form-control mb-3" ><?= $correccion->getAnotacion()[0] ?></textarea>

                                                        </div>
                                                    </div>
                                                </section>

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
    </div>
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
