<!DOCTYPE html>
<!--
autor:Israel Molina Pulpon
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
        $asignaturas = $_SESSION['asignaturasImpartidas'];
        $examenesPendientes = $_SESSION['examenesPendientes'];
        $examenes = $_SESSION['examenesC'];
        $solucionesUsuario = $usuario->getSoluciones();

        $not = array();
        $tem = array();
        $notaTotal;
        ?>
        <!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
        <header class="bg-white">
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top colorNav">
                <div class="container-fluid">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item">
                            <form name = "home" action = "../Controlador/controladorAlumno.php" method = "post">
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
        <!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
        <div class="container my-5 pt-5">
            <!-- Section: Block Content -->
            <section>
                <div class="row altura d-flex justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="card card-list">
                            <div class="card-header white d-flex justify-content-between align-items-center py-3">

                                <h5 class="h5-responsive font-weight-bold ml-auto letra mb-0"><?php echo $asignaturas[0]->getNombre(); ?></h5>
                            </div>
                            <div class="card-body">
                                <form name="formExamenes" action="../Controlador/controladorAlumno.php" method="post">
                                    <div class="view view-cascade gradient-card-header mean-fruit-gradient narrower d-flex py-2 mx-4 mb-3 justify-content-between align-items-center">
                                        <div class="mx-auto"> <h4 class="white-text text-center ">Mis exámenes</h4></div>



                                    </div>
                                    <table class="table text-center">
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
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold" scope="col" style="font-size: 20px"><i class="fas fa-file-alt pr-2 letra"></i>Contenido</th>
                                                <th class="font-weight-bold" scope="col" style="font-size: 20px"><i class="fas fa-question pr-2 letra"></i>Preguntas</th>
                                                <th class="font-weight-bold" scope="col" style="font-size: 20px"><i class="fas fa-check pr-2 letra"></i>Nota</th>
                                                <th class="font-weight-bold" scope="col" style="font-size: 20px"><i class="fas fa-clipboard-list pr-2 letra"></i>Ponderacion</th>
                                                <th class="font-weight-bold" scope="col" style="font-size: 20px"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php
                                            foreach ($examenes as $i => $examen) {
                                                $notaTotal = 0;
                                                foreach ($solucionesUsuario as $j => $solucion) {
                                                    $correccion = $solucion->getCorreccion();
                                                    if ($examen->getId() == $solucion->getExamen()) {
                                                        foreach ($examen->getPreguntas() as $z => $pregunta) {
                                                            $notaTotal += $pregunta->getPuntuacion();
                                                        }
                                                        if ($i % 2 == 0) {
                                                            $color = 'purple lighten-3';
                                                        } else {
                                                            $color = 'orange lighten-3';
                                                        }
                                                        ?>
                                                        <tr>

                                                            <td class="pt-2 pb-0"><?php echo $examen->getContenido(); ?></td>
                                                            <td class="pt-2 pb-0"><?php echo count($examen->getPreguntas()); ?></td>
                                                            <?php
                                                            $not[] = $correccion->getNotas()[0];
                                                            ?>
                                                            <td class="pt-2 pb-0"><?php echo $correccion->getNotas()[0]; ?></td>
                                                            <td class="pt-2 pb-0"><?php echo $notaTotal; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        <td></td> <td></td> <td></td> <td></td> 
                                        <td class="pt-2 pb-0 font-weight-bold font-weight-lighter" style="font-size: 20px"><i class="fas fa-poll pr-2 letra"></i>Nota media:<?php
                                            if (count($not)) {
                                                echo array_sum($not) / count($not);
                                            }
                                            ?></td>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
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
        <script type="text/javascript" src="../js/diseño.js"></script>

    </body>
</html>