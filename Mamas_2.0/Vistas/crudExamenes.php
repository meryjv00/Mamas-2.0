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
        include_once '../Modelo/Examen.php';
        include_once '../Modelo/Pregunta.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
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

                <div class="row">
                    <div class="col-12">
                        <div class="card card-list">
                            <div class="card-header white d-flex justify-content-between align-items-center py-3">
                                <h3 class="h5-responsive font-weight-bold mb-0">Examenes</h3>
                                <h5 class="h5-responsive font-weight-bold mb-0"><?php echo $asignatura[0]->getNombre(); ?></h5>
                            </div>
                            <div class="card-body">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
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
                                                <th scope="row"><a class="text-primary"><?php echo $examen->getId(); ?></a></th>
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
                            </div>
                            <form name="crudExamenes" action="../Controlador/controladorProfesor.php" method="post">
                                <div class="card-footer white py-3 d-flex justify-content-between">
                                    <button type="submit" name="crearExamenes" class="btn btn-secondary btn-md px-3 my-0 mr-0">Crear nuevo examen</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
            <!-- Section: Block Content -->
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
