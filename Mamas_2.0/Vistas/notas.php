<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
        $notaTotal;
        ?>
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
        <main class="pb-5 pt-5 ml-4 mb-5">
            <div class="container-fluid row  altura d-flex justify-content-center align-items-center">
                <div class="col-md-7">
                    <div class="row">
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
                                    <div class="col-md-6 mx-auto col-sm-6 mb-4">
                                        <div class="card <?= $color ?> white-text">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="h2-responsive font-weight-bold mt-n2 mb-0"></p>
                                                    <p class="mb-0"><?= $examen->getContenido() ?><?php echo $correccion->getNotas()[0] . '/' . $notaTotal; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-5">
                    asdfasdf

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