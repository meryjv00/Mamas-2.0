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
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignaturas = $_SESSION['asignaturasImpartidas'];
        $examenes = $_SESSION['examenesMostrar'];
        $controlador = '../Controlador/controladorAlumno.php';
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
                                        <div class="mx-auto"></div>
                                        <h4 class="white-text text-center ">Mis exámenes</h4>
                                        <div class="ml-auto pr-3">
                                            <button type="submit" name="verExamenAlumno" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Ver corrección">
                                                <i class="far fa-eye" style="font-size: 18px"></i>
                                            </button>
                                            <button type="submit" name="verExamenesAlumno" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Limpiar filtros">
                                                <i class="fas fa-broom" style="font-size: 18px"></i>
                                            </button>
                                            <button type="submit" name="verExamenesPendientes" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Ver exámenes pendientes">
                                                <i class="fas fa-exclamation-triangle" style="font-size: 18px"></i>
                                            </button>
                                            <button type="submit" name="verExamenesRealizados" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Ver exámenes realizados">
                                                <i class="fas fa-check" style="font-size: 18px"></i>
                                            </button>
                                            <button type="submit" name="verExamenesCorregidos" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Ver exámenes corregidos">
                                                <i class="fas fa-check-double" style="font-size: 18px"></i>
                                            </button>
                                        </div>

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
                                                <th scope="col"></th>
                                                <th scope="col">Contenido</th>
                                                <th scope="col">Activo</th>
                                                <th scope="col">Preguntas</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php
                                            foreach ($examenes as $i => $examen) { // crea una fila para cada examen
                                                ?>
                                                <tr>
                                                    <th scope="row"> <input class="form-check-input" type="checkbox" id="checkbox1" name="<?= $i ?>">
                                                    </th>

                                                    <td><?php echo $examen->getContenido(); ?></td>
                                                    <td><span class="badge badge-<?php
                                                        if ($examen->getActivo() == 0) {
                                                            //Cambia el color de verde en activado y rojo en desactivado
                                                            echo'danger';
                                                        } else {
                                                            echo'success';
                                                        }
                                                        ?>"><?php
                                                                  if ($examen->getActivo() == 0) {
                                                                      //Cambia el color de verde en activado y rojo en desactivado
                                                                      echo'Desactivado';
                                                                  } else {
                                                                      echo'Activado';
                                                                  }
                                                                  ?></span></td>
                                                    <td class="pt-2 pb-0"><?php echo count($examen->getPreguntas()); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
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
