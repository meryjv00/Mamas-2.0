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
    <body onload="validacionTfnoPass()">
        <?php
        require_once '../Modelo/Usuario.php';
        require_once '../Modelo/Asignatura.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignaturas = $_SESSION['asignaturas'];
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top deg">
                <div class="container-fluid">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item">

                            <!--CRUD ADMINISTRADOR-->
                            <?php if ($usuario->getRol() != 0) { ?> 
                                <form action="../Controlador/controladorProfesor.php"><?php
                                    if ($usuario->getRol() == 2) {
                                        ?>


                                        <a href="inicioProfesor.php" class="btn mean-fruit-gradient btn-rounded text-white">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </form>
                                    <?php
                                } else if ($usuario->getRol() == 1) {
                                    ?>
                                    <form action="../Controlador/controladorProfesor.php">
                                        <button type="submit" class="btn mean-fruit-gradient text-white
                                                btn-rounded waves-effect z-depth-1a" name="CRUDadmin" value="CRUDadmin">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <a href="inicioProfesor.php" class="btn mean-fruit-gradient btn-rounded text-white">
                                            <i class="fas fa-times"></i>
                                        </a>

                                        <?php
                                    }
                                    ?></form><?php
                            }
                            ?>
                            <form name="home" action="../Controlador/controlador.php" method="post">
                                <button type="submit" class="btn mean-fruit-gradient text-white
                                        btn-rounded waves-effect z-depth-1a" name="home" value="home">
                                    <i class="fas fa-home"></i>
                                </button>

                            </form>
                        </li> 
                    </ul>
                    <ul class="navbar-nav ml-auto mr-5">
                        <li class="nav-item">

                            <form name="cerrarSes" action="../Controlador/controlador.php" method="post">
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
            <div class="container-fluid row">
                <div class="col-md-4 mt-5 mx-auto">
                    <!-- Card -->
                    <div class="card bg-white ">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <?php
                                if ($usuario->getImagen() == "") {
                                    ?>
                                    <img class="rounded-circle" src="../img/defectousu.png" height="220px"/>
                                    <?php
                                } else {
                                    ?>
                                    <img class="rounded-circle" src="data:image/png;base64,<?php echo base64_encode($usuario->getImagen()); ?>" 
                                         alt="titulo foto" class="img-fluid" height="220px"  width="220px"/>
                                         <?php
                                     }
                                     ?>
                            </div>

                            <h2 class="font-weight-bold my-4 text-center letra"><?= $usuario->getNombre() . ' ' ?><?= $usuario->getApellidos() ?></h2>
                            <p class="grey-text font-weight-bold">
                                <?php
                                if ($usuario->getRol() == 0) {
                                    ?>
                                    Alumno - DAW:
                                    <?php
                                } else {
                                    ?>
                                    Profesor - DAW:
                                    <?php
                                }
                                ?>

                            <ul class="grey-text">
                                <?php
                                foreach ($asignaturas as $i => $asignatura) {
                                    ?>
                                    <li><?= $asignatura->getNombre() ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <hr>
                            <form name="aniadirfoto" id="add" action="../Controlador/controlador.php" method="post" enctype="multipart/form-data">
                                <p class="grey-text font-weight-bold">Editar foto perfil:</p>
                                <!--INPUT FOTO-->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagen" name="imagen"
                                               aria-describedby="inputGroupFileAddon01" required>
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>

                                </div>
                                <!--BOTON-->
                                <div class="text-center mb-3 pl-5 pr-5">
                                    <button type="submit" name="editarFotoPerfil"  class="btn mean-fruit-gradient text-white 
                                            btn-block btn-rounded my-4 waves-effect z-depth-1a">Editar foto</button>
                                </div>

                                <hr>
                            </form>
                            <p class="grey-text font-weight-bold">Datos personales:</p>
                            <ul class="grey-text">
                                <li>Nombre completo: <?= $usuario->getNombre() . ' ' ?><?= $usuario->getApellidos() ?></li>
                                <li>Email: <?= $usuario->getEmail() ?></li>
                                <li>Dni: <?= $usuario->getDni() ?></li>
                                <li>
                                    Teléfono: <?= $usuario->getTelefono() ?>
                                </li>
                            </ul>
                            <hr>
                            <!--TELEFONO-->
                            <form name="editarTfno" id="editarTfno" action="../Controlador/controlador.php" method="post" novalidate>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="grey-text font-weight-bold">Cambia tu número de teléfono:</p>
                                        <div class="md-form">
                                            <input type="text" id="tfno" name="tfno" class="form-control mb-4" pattern="^[0-9]{9}$" required>
                                            <label for="tfno">Introduce tu nuevo teléfono</label>
                                            <div id="tfnoError"></div>
                                        </div>

                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="editarTfno"  class="btn mean-fruit-gradient text-white 
                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Editar número de teléfono</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <hr>
                            <!--CONTRASEÑA-->
                            <form name="editarPass" id="editarPass" action="../Controlador/controlador.php" method="post" novalidate>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="grey-text font-weight-bold">Cambia tu contraseña:</p>
                                        <div class="md-form">
                                            <input type="password" id="pass" name="pass" class="form-control mb-4" minlength="3" maxlength="15" required>
                                            <label for="pass">Introduce tu nueva contraseña</label>
                                            <div id="passError"></div>
                                        </div>
                                        <div class="md-form">
                                            <input type="password" id="pass2" name="pass2" class="form-control mb-4" minlength="3" maxlength="15" required>
                                            <label for="pass2">Repite la contraseña</label>
                                            <div id="pass2Error"></div>
                                        </div>
                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="nuevaPass"  class="btn mean-fruit-gradient text-white 
                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Confirmar</button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                            <hr>
                        </div>
                        <!-- Content -->

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
    <script type="text/javascript" src="../js/validar.js"></script>
</body>
</html>
