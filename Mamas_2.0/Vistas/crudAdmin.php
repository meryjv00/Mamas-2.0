<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestión de usuarios</title>
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
        require_once '../Modelo/Usuario.php';
        session_start();
        $usuarios = $_SESSION['usuarios'];
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top deg">
                <div class="container">
                    <!--Left-->
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li>
                            <a href="elegirAdmin.php" class="btn mean-fruit-gradient btn-rounded text-white">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Right -->
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <form name="cerrarSes" action="../Controlador/controladorCrud.php" method="post">
                                <input type="submit" class="btn mean-fruit-gradient text-white
                                       btn-rounded waves-effect z-depth-1a" name="nuevoUsuario" value="Añadir usuario">
                                <input type="submit" class="btn mean-fruit-gradient text-white
                                       btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                            </form>
                        </li> 
                    </ul>
                </div>
            </nav>
        </header>
        <div class="pt-5"></div>
        <main class="container my-5 z-depth-1 ">
            <!--Section: Content-->
            <section class="pb-5 text-center ">
                <div class="row">  
                    <div class="col-md-12 mx-auto">
                        <!--<img src="../img/log0.png" width="220px"/>-->
                        <!--BORDE-->
                        <div class="card mb-5 mt-5" style="border: 2px solid antiquewhite">
                            <div class="card-body">
                                <form class="text-center needs-validation" style="color: #757575;" action="../Controlador/controladorCrud.php" method="POST" novalidate>
                                    <h3 class="font-weight-bold my-4 pb-2 text-center tit">Gestión de usuarios</h3>
                                    <?php
                                    if (isset($_SESSION['mensaje'])) {
                                        $mensaje = $_SESSION['mensaje'];
                                        echo $mensaje . '<br>';
                                        unset($_SESSION['mensaje']);
                                    }
                                    ?>
                                    <!------------------TABLA------------------------->
                                    <div class="card card-cascade narrower">

                                        <!--Card image-->
                                        <div class="view view-cascade gradient-card-header mean-fruit-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                                            <div>
                                                <button type="submit" name="cambiarRolAlumno" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Establecer como alumno">
                                                    <i class="fas fa-user" style="font-size: 20px"></i>
                                                </button>
                                                <button type="submit" name="cambiarRolProfesor" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Establecer como profesor">
                                                    <i class="fas fa-chalkboard-teacher" style="font-size: 20px"></i>
                                                </button>
                                                <button type="submit" name="cambiarRolAdmnistrador" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Establecer como administrador">
                                                    <i class="fas fa-user-cog mt-0" style="font-size: 20px"></i>
                                                </button>
                                            </div>
                                            <a href="" class="white-text ml-auto">Usuarios</a>
                                            <div class="ml-auto">
                                                <button type="submit" name="activarUsuario" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Activar">
                                                    <i class="fas fa-check-circle" style="font-size: 20px"></i>
                                                </button>
                                                <button type="submit" name="desactivarUsuario" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Desactivar">
                                                    <i class="fas fa-times-circle" style="font-size: 20px"></i>
                                                </button>
                                                <button type="submit" name="editarUsuario" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Editar">
                                                    <i class="fas fa-pencil-alt mt-0" style="font-size: 20px"></i>
                                                </button>
                                                <button type="submit" name="borrarUsuario" class="btn btn-outline-white btn-rounded btn-sm px-2"
                                                        data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                    <i class="far fa-trash-alt mt-0" style="font-size: 20px"></i>
                                                </button>
                                            </div>

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
                                                                <a>Nombre</a>
                                                            </th>
                                                            <th class="th-lg">
                                                                <i class="fas fa-address-book c1 pr-1"></i>                                                                
                                                                <a>Apellidos</a>
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
                                                        foreach ($usuarios as $i => $usuario) {
                                                            ?>
                                                            <tr>
                                                                <th scope="row">
                                                                    <input class="form-check-input" type="checkbox" id="checkbox1" name="<?= $i ?>">
                                                                </th>
                                                                <td>
                                                                    <?php
                                                                    if ($usuario->getRol() == 0) {
                                                                        ?>
                                                                        <i class="fas fa-user c1"></i>
                                                                        <?php
                                                                    } else if ($usuario->getRol() == 1) {
                                                                        ?>
                                                                        <i class="fas fa-chalkboard-teacher c1"></i>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <i class="fas fa-user-cog c1"></i>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?= $usuario->getEmail() ?>
                                                                </td>
                                                                <td><?= $usuario->getDni() ?></td>
                                                                <?php
                                                                if ($usuario->getActivo() == 0) {
                                                                    $color = "#E25B64";
                                                                } else {
                                                                    $color = "#5ACA91";
                                                                }
                                                                ?>
                                                                <td>
                                                                    <input class="form-control" type="text" name="nombre[]" value="<?= $usuario->getNombre() ?>"
                                                                           style="border-color: <?= $color ?>" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="apellidos[]" value="<?= $usuario->getApellidos() ?>"
                                                                           style="border-color:<?= $color ?>" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="tfno[]" value="<?= $usuario->getTelefono() ?>"
                                                                           style="border-color:<?= $color ?>"/>  
                                                                </td>
                                                                <td>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <!--Table body-->
                                                </table>
                                                <!--Table-->
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
        <script type="text/javascript" src="../js/validar.js"></script>
        <script type="text/javascript" src="../js/diseño.js"></script>
</body>
</html>
