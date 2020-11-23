<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro un nuevo usuario</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="../css/mdb.min.css">
        <!-- Your custom styles (optional) -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    </head>
    <body onload="validarRegistro()">
        <?php
        require_once '../Modelo/Usuario.php';
        session_start()
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top">
                <div class="container-fluid ml-5 mr-5">
                    <!--Left-->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li>
                            <a href="crudAdmin.php" class="btn mean-fruit-gradient btn-rounded text-white">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Right -->
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <form name="cerrarSes" action="../Controlador/controladorCrud.php" method="post">
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
        <div class="pt-5"></div>
        <div class="container my-5 px-0 z-depth-1">
            <!--Section: Content-->
            <section class="pb-5 my-md-5 text-center">
                <div class="my-5 mx-md-5">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Material form login -->
                            <div class="card mt-5" style="border: 2px solid antiquewhite">

                                <!--Card content-->
                                <div class="card-body">

                                    <!-- Form -->
                                    <form id="registro" class="text-left" style="color: #757575;" method="POST" action="../Controlador/controladorCrud.php" novalidate>

                                        <h3 class="font-weight-bold my-4 pb-2 text-center  tit">Registrar usuario</h3>
                                        <?php
                                        if (isset($_SESSION['usu'])) {
                                            $usu = $_SESSION['usu'];
                                            unset($_SESSION['usu']);
                                        } else {
                                            $usu = new Usuario("", "", "", "", "", "", "", "");
                                        }
                                        ?>
                                        <!--Nombre y apellidos-->
                                        <div class="form-row">
                                            <div class="col">
                                                <!-- First name -->
                                                <div class="md-form">
                                                    <input type="text" id="nombre" name="nombre" class="form-control"  value="<?= $usu->getNombre() ?>"
                                                           minlength="2" maxlength="25" required>
                                                    <label for="nombre">Nombre</label>
                                                    <div id="nombreError"></div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!-- Last name -->
                                                <div class="md-form">
                                                    <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= $usu->getApellidos() ?>"
                                                           minlength="6" maxlength="25" required>
                                                    <label for="apellidos">Apellidos</label>
                                                    <div id="apellidosError"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Email -->
                                        <div class="md-form mt-0">
                                            <input type="email" id="email" name="email" class="form-control mb-4" required value="<?= $usu->getEmail() ?>">
                                            <label for="email">E-mail </label>
                                            <div id="emailError"></div>
                                        </div>

                                        <!-- Dni -->
                                        <div class="md-form">
                                            <input type="text" id="dni" name="dni" class="form-control mb-4" value="<?= $usu->getDni() ?>"
                                                   pattern="^[0-9]{8}[A-Z]{1}$" required>
                                            <label for="dni">Dni </label>
                                            <div id="dniError"></div>
                                        </div>

                                        <!-- Tfno -->
                                        <div class="md-form">
                                            <input type="text" id="tfno" name="tfno" class="form-control mb-4" value="<?= $usu->getTelefono() ?>"
                                                   pattern="^[0-9]{9}$" required>
                                            <label for="tfno">Teléfono</label>
                                            <div id="tfnoError"></div>
                                        </div>

                                        <!-- Pass -->
                                        <div class="md-form">
                                            <input type="password" id="pass" name="pass" minlength="3" maxlength="15" class="form-control" required>
                                            <label for="pass">Contraseña </label>
                                            <div id="passError"></div>
                                        </div>
                                        <!-- Repeat password -->
                                        <div class="md-form">
                                            <input type="password" id="pass2" name="pass2" class="form-control" required>
                                            <label for="pass2">Repite la contraseña </label>
                                            <div id="pass2Error"></div>
                                        </div>
                                        <!--Rol-->
                                        <div class="md-form ml-4">
                                            <div class="container-fluid">
                                                <!--ALUMNO-->
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="alumno" name="rol" value="Alumno" checked>
                                                    <label class="custom-control-label" for="alumno">Alumno</label>
                                                </div>
                                                <!--PROFESOR-->
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="custom-control custom-radio" id="prof">
                                                            <input type="radio" class="custom-control-input" id="profesor" name="rol"value="Profesor" >
                                                            <label class="custom-control-label" for="profesor">Profesor</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div id="admin" class="custom-control custom-checkbox d-none" >
                                                            <input type="checkbox" class="custom-control-input" id="adminis" name="adminis">
                                                            <label class="custom-control-label" for="adminis">¿Administrador?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--ASIGNATURAS-->
                                                <div id="asignaturas" class="row d-none pt-2">
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="DWES" name="asig" value="DWES" checked>
                                                            <label class="custom-control-label" for="DWES">DWES</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="DWEC" name="asig" value="DWEC" >
                                                            <label class="custom-control-label" for="DWEC">DWEC</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="DAW" name="asig" value="DAW" >
                                                            <label class="custom-control-label" for="DAW">DAW</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="DI" name="asig" value="DI" >
                                                            <label class="custom-control-label" for="DI">DI</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="EIE" name="asig" value="EIE"  >
                                                            <label class="custom-control-label" for="EIE">EIE</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <?php
                                        if (isset($_SESSION['mensaje'])) {
                                            $mensaje = $_SESSION['mensaje'];
                                            echo $mensaje . '<br>';
                                            unset($_SESSION['mensaje']);
                                        }
                                        ?>
                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="crearUsuario" class="btn mean-fruit-gradient text-white btn-block 
                                                    btn-rounded my-4 waves-effect z-depth-1a">Registrar</button>
                                        </div>

                                    </form>
                                    <!-- Form -->

                                </div>

                            </div>
                            <!-- Material form login -->
                        </div>
                    </div>

                </div>

            </section>
            <!--Section: Content-->
        </div>

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
    </body>
</html>
