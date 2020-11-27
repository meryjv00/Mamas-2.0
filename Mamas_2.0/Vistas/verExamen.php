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
        include_once '../Modelo/Examen.php';
        include_once '../Modelo/Pregunta.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
        $examen = $_SESSION['examenS'];
        $creador = $_SESSION['creadorEx'];
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top deg">
                <div class="container-fluid ml-5 mr-5">
                    <!--Left-->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                            <!--CRUD ADMINISTRADOR-->
                            <?php
                            if ($usuario->getRol() == 2) {
                                ?>
                                <button type="submit" class="btn mean-fruit-gradient text-white
                                        btn-rounded waves-effect z-depth-1a" name="CRUDadmin" value="CRUDadmin">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <?php
                            }
                            ?>
                            <!--HOME PAGINA INICIO-->
                            <button type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="home" value="home">
                                <i class="fas fa-home"></i>
                            </button>

                            <button type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="homeInicio" value="homeInicio">
                                <i class="far fa-eye pr-1"></i> alumno
                            </button>


                    </ul>
                    <!-- Right -->
                    <ul class="navbar-nav">
                        <li class="nav-item">

                            <button type="submit" class="btn mean-fruit-gradient text-white 
                                    btn-rounded waves-effect z-depth-1a" name="verExamenes" value="Ver exámenes">
                                <i class="far fa-eye pr-1"></i> exámenes
                            </button>
                            <button type="submit" class="btn mean-fruit-gradient text-white 
                                    btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                <i class="fas fa-plus pr-1"></i> exámenes
                            </button>
                            <button type="submit" class="btn mean-fruit-gradient text-white 
                                    btn-rounded waves-effect z-depth-1a" name="crearPreguntas" value="Crear preguntas">
                                <i class="fas fa-plus pr-1"></i>  preguntas
                            </button>
                            <button type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="perfil" value="Ver perfil">
                                <i class="fas fa-user"></i>
                            </button>
                            <button type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>

                        </li> 
                    </ul>
                </div>
            </nav>
        </header>
        <main class="pt-5">
            <div class="container mt-5 ">
                <!--Section: Content-->
                <section class="mx-md-5 dark-grey-text">

                    <!-- Grid row -->
                    <div class="row">

                        <!-- Grid column -->
                        <div class="col-md-12">

                            <!-- Card -->
                            <div class="card card-cascade wider reverse">
                                <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                    <!-- Title -->
                                    <h2 class="card-header-title  text-center titulo text-white pt-2 pb-2  ">Examen</h2>
                                </div>
                                <!-- Card image -->
                                <div class="view view-cascade overlay pt-4">


                                </div>

                                <!-- Card content -->
                                <div class="card-body card-body-cascade text-center">
                                    <!-- Title -->
                                    <h3 class="font-weight-bold"><a><?= $examen->getContenido() ?></a></h3>
                                    <!-- Data -->
                                    <p>Creado por: <?= $creador->getNombre(); ?></p>
                                    <p>Numero de preguntas: <?= count($examen->getPreguntas()); ?></p>
                                    <div class="mt-5">
                                        <h3>Descripcion</h3>
                                        <p><?= $examen->getDescripcion() ?></p>
                                    </div>

                                    <!-- Social shares -->

                                </div>
                                <!-- Card content -->
                                <div class="col-md-12 pb-2">
                                    <!-- Facebook -->
                                    <button name="corregirA" title="corregir auto" class="btn btn-outline-secondary btn-rounded btn-sm px-2 purple lighten-3" ">
                                        <i class="fas fa-magic" style="font-size: 20px" ></i>
                                    </button>
                                    <button name="corregirM" title="corregir manual" class="btn btn-outline-secondary btn-rounded btn-sm px-2 purple lighten-3" ">
                                        <i class="fas fa-file-signature" style="font-size: 20px"></i>
                                    </button>
                                    <button name="asignarP" title="asignar Preguntas"  class="btn btn-outline-secondary btn-rounded btn-sm px-2 purple lighten-3" ">
                                        <i class="far fa-file-powerpoint" style="font-size: 20px"></i>
                                    </button>

                                </div>
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
        </main>
    </div>
    <footer class="footer-copyright text-center text-white py-3 z-depth-2">
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
