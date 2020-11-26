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
                                <button type="submit" class="btn mean-fruit-gradient text-white 
                                        btn-rounded waves-effect z-depth-1a" name="verExamenes" value="Ver exámenes">
                                    Ver exámenes
                                </button>
                                <button type="submit" class="btn mean-fruit-gradient text-white 
                                        btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                    Crear exámenes
                                </button>
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
        <main class="pb-5 pt-5 ml-4">
            <div class="container-fluid my-5">
                <div class="row">
                    <div class="col-md-8 col-lg-6 mx-auto">
                        <!-- Section: Block Content -->
                        <section>
                            <form action="../Controlador/controladorProfesor.php">
                                <div class="list-group list-group-flush z-depth-1 rounded ">
                                    <div class="list-group-item active d-flex justify-content-start align-items-center py-3 purple lighten-3">
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

                        </aside>
                        <!-- Section: Block Content -->


                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 mx-auto">
                        <div class="card card-cascade narrower">
                            <!--Card image-->
                            <div class="view view-cascade gradient-card-header mean-fruit-gradient narrower pt-2 mx-4  justify-content-between align-items-center">
                                <h4 class="white-text text-center">Mis alumnos</h4>
                            </div>
                            <!--/Card image-->
                            <div class="px-4">
                                <div class="table-responsive">
                                    <!--Table-->
                                    <table class="table table-hover mb-0">
                                        <!--Table head-->
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="th-lg">
                                                    <i class="fas fa-envelope c1 pr-1"></i>
                                                    <a>Mail</a>
                                                </th>
                                                <th class="th-lg">
                                                    <i class="fas fa-id-card c1 pr-1"></i>
                                                    <a>Dni</a>
                                                </th>
                                                <th class="th-lg">
                                                    <i class="fas fa-address-book c1 pr-1"></i>
                                                    <a>Nombre completo</a>
                                                </th>
                                                <th class="th-lg">
                                                    <i class="fas fa-phone-alt c1 pr-1"></i>
                                                    <a>Telefono</a>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <!--Table head-->

                                        <!--Table body-->
                                        <tbody>
                                            <?php
                                            for ($i = 0; $i < count($asignaturas); $i++) {
                                                $alumnos = $asignaturas[$i]->getAlumnos();

                                                for ($j = 0; $j < count($alumnos); $j++) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($alumnos[$j]->getImagen() == "") {
                                                                ?>
                                                                <img class="rounded-circle" src="../img/defectousu.png" height="35px"/>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <img class="rounded-circle" src="data:image/png;base64,<?php echo base64_encode($alumnos[$j]->getImagen()); ?>" 
                                                                     alt="titulo foto" class="img-fluid" height="35px"  width="35px"/>
                                                                     <?php
                                                                 }
                                                                 ?>
                                                        </td>
                                                        <td><?= $alumnos[$j]->getEmail() ?></td>
                                                        <td><?= $alumnos[$j]->getDni() ?></td>
                                                        <td><?= $alumnos[$j]->getNombre() . ' ' ?><?= $alumnos[$j]->getApellidos() ?></td>
                                                        <td><?= $alumnos[$j]->getTelefono() ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <!--Table body-->
                                    </table>
                                    <!--Table-->
                                </div>
                            </div>
                        </div>

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
