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
        include_once '../Modelo/Asignatura.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignaturas = $_SESSION['asignaturasImpartidas'];
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
                                Vista alumno
                            </button>

                        </form>
                    </ul>
                    <!-- Right -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                                <button type="submit" class="btn mean-fruit-gradient text-white disabled
                                        btn-rounded waves-effect z-depth-1a" name="verExamenes" value="Ver exámenes">
                                    Ver exámenes
                                </button>
                                <button type="submit" class="btn mean-fruit-gradient text-white disabled
                                        btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                    Crear exámenes
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
        <main class="pb-5 pt-5 ml-4">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-8 col-lg-6 mx-auto">
                        <!-- Section: Block Content -->
                        <section>
                            <form action="../Controlador/controladorProfesor.php">
                                <div class="list-group list-group-flush z-depth-1 rounded ">
                                    <div class="list-group-item active d-flex justify-content-start align-items-center py-3 mean-fruit-gradient">
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
                                            <?php
                                            foreach ($asignaturas as $asignatura) {
                                                ?>
                                                <p class="small mb-0 letra"><?php echo $asignatura->getNombre(); ?></p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <button name="examenCreado" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">Ex. Creados
                                        <span class="badge badge-info badge-pill"><?php echo count($_SESSION['examenes']); ?></span>
                                    </button>   
                                    <button name="examenCorregido" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">Ex. Corregidos
                                        <span class="badge badge-success badge-pill"><?php echo $_SESSION['exCorregidos']; ?></span>
                                    </button>
                                    <button name="examenPendiente" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">Ex. Pendientes
                                        <span class="badge badge-warning badge-pill"><?php echo count($_SESSION['exPendientes']); ?></span>
                                    </button>
                                </div>
                            </form>

                        </section>
                        <aside>
                            <div class="accordion mt-3 " id="accordionExample">
                                <div class="card z-depth-0 bordered">
                                    <div class="card-header mean-fruit-gradient text-center  " id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link titulo font-weight-bold " type="button" data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                Mis alumnos
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body">
                                            <?php
                                            for ($i = 0; $i < count($asignaturas); $i++) {
                                                $alumnos = array();
                                                $alumnos = $asignaturas[$i]->getAlumnos();

                                                for ($j = 0; $j < count($alumnos); $j++) {
                                                    ?>
                                                    <div class="accordion mt-3" id="accordion<?= $j ?>">
                                                        <div class="card z-depth-0 bordered">
                                                            <div class="card-header" id="heading<?= $j ?>">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse<?= $j ?>"
                                                                            aria-expanded="false" aria-controls="collapse<?= $j ?>">
                                                                                <?php
                                                                                if ($alumnos[$j]->getImagen() == "") {
                                                                                    ?>
                                                                            <img class="rounded-circle" src="../img/defectousu.png" height="50px"/>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <img src="data:image/png;base64,<?php echo base64_encode($alumnos[$j]->getImagen()); ?>" class="rounded-circle z-depth-0 " width="50" alt="avatar image">
                                                                        <?php } ?>

                                                                        <span class="pl-3"> <?php echo $alumnos[$j]->getNombre() . ' ' . $alumnos[$j]->getApellidos(); ?></span> 
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="collapse<?= $j ?>" class="collapse" aria-labelledby="heading<?= $j ?>"
                                                                 data-parent="#accordion<?= $j ?>">
                                                                <div class="card-body">
                                                                    <p><i class="fas fa-angle-right pr-2"></i> E-mail: <?php echo $alumnos[$j]->getEmail(); ?></p>
                                                                    <p><i class="fas fa-angle-right pr-2"></i> Dni: <?php echo $alumnos[$j]->getDni(); ?></p>
                                                                    <p><i class="fas fa-angle-right pr-2"></i> Telefono: <?php echo $alumnos[$j]->getTelefono(); ?></p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <!-- Section: Block Content -->


                    </div>
                </div>
            </div>
        </main>
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
    </body> 
</html>
