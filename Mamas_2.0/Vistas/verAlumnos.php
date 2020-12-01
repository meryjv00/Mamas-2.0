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
        $asignatura = $asignaturas[0];
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
        <main class="pb-5 pt-5">
            <div class="container-fluid my-5">
                <div class="row mt-4">
                    <div class="col-lg-7 mx-auto">
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
