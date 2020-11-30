<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Examenes CRUD</title>
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
        include_once '../Modelo/Correccion.php';
        include_once '../Modelo/Solucion.php';
        session_start();
        $alumnosExamen = array();
        $soluciones = array();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
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
        <div class="container my-5 pt-5">
            <!-- Section: Block Content -->
            <section>
                <div class="row altura d-flex justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="card card-list">
                            <div class="card-header white d-flex justify-content-between align-items-center py-3">

                                <h5 class="h5-responsive font-weight-bold ml-auto letra mb-0"><?php echo $asignatura[0]->getNombre(); ?></h5>
                            </div>
                            <div class="card-body">
                                <form name="formExamenes" action="../Controlador/controladorProfesor.php" method="post">
                                    <div class="view view-cascade gradient-card-header mean-fruit-gradient narrower d-flex py-2 mx-4 mb-3 justify-content-between align-items-center">
                                        <div class="mx-auto"></div>
                                        <h4 class="white-text text-center ">Mis exámenes</h4>
                                        <div class="ml-auto pr-3">
                                            <button type="submit" name="verExamen" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Ver en detalle">
                                                <i class="far fa-eye" style="font-size: 18px"></i>
                                            </button>
                                            <button type="submit" name="asignarPreguntas" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Asignar preguntas">
                                                <i class="far fa-file-powerpoint px-1" style="font-size: 20px"></i>
                                            </button>
                                            <button name="corregirTabla"  data-toggle="tooltip" data-placement="top" title="Corregir exámen" class="btn btn-outline-white btn-rounded btn-sm px-2">
                                                <i class="fas fa-file-signature" style="font-size: 20px ;color: white"></i>
                                            </button>
                                            <button type="submit" name="activarExamen" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Activar">
                                                <i class="fas fa-check-circle" style="font-size: 20px"></i>
                                            </button>
                                            <button type="submit" name="desactivarExamen" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                    data-toggle="tooltip" data-placement="top" title="Desactivar">
                                                <i class="fas fa-times-circle" style="font-size: 20px"></i>
                                            </button>
                                            <button type="submit" name="borrarExamen" class="btn btn-outline-white btn-rounded btn-sm px-2 waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                                                <i class="far fa-trash-alt mt-0" style="font-size: 20px"></i>
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
                                                <th scope="col">Pendientes</th>
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
                                                    <td><?php
                                                        $alumnos = $asignatura[0]->getAlumnos();
                                                        foreach ($alumnos as $i => $alumno) {
                                                            $soluciones = $alumno->getSoluciones();
                                                            $correcto = false;
                                                            foreach ($soluciones as $j => $solucion) {
                                                                if ($solucion->getExamen() == $examen->getId() && $solucion->getCorreccion() == null) {
                                                                    $correcto = true;
                                                                }
                                                            }
                                                            if ($correcto) {
                                                                $alumnosExamen[] = $alumno;
                                                            }
                                                        }
                                                        if (count($alumnosExamen) == 0) {
                                                            ?> <i class="fas fa-check-double"></i><?php
                                                        } else {
                                                            echo count($alumnosExamen);
                                                        }
                                                        ?></td>
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
            <!-- Section: Block Content -->
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
