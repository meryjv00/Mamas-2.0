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
    </head>
    <body>
        <?php
        require_once '../Modelo/Usuario.php';
        session_start();
        $usu = $_SESSION['usuario'];
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">
                <a class="navbar-brand" href="">Mamás 2.0</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav mr-auto smooth-scroll">
                        <li class="nav-item ">
                            <form class="nav-link" name="cerrarSes" action="../Controlador/controlador.php" method="post">
                                <input type="submit" class="btn mean-fruit-gradient text-white
                                       btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                            </form>
                        </li>
                    </ul>
                    <!-- Social Icon  -->
                    <ul class="navbar-nav nav-flex-icons">
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fab fa-facebook light-green-text-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fab fa-twitter light-green-text-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fab fa-instagram light-green-text-2"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container my-5 px-0 z-depth-1">
            <!--Section: Content-->
            <section class="pb-5 text-center">
                <div class="my-5 mx-md-5">
                    <!--<a href="../index.php"><img src="../img/log0.png" width="250px"/></a>-->

                    <div class="row">
                        <div class="col-md-8 mx-auto">

                            <!-- Material form login -->
                            <div class="card mt-5" style="border: 2px solid antiquewhite">

                                <!--Card content-->
                                <div class="card-body">

                                    <!-- Form -->
                                    <form class="text-center needs-validation" style="color: #757575;" action="../Controlador/controlador.php" method="POST" novalidate>

                                        <h3 class="font-weight-bold my-4 pb-2 text-center tit">Bienvenido <?= $usu->getNombre() ?></h3>

                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="admin"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">
                                                Entrar como administrador
                                            </button>
                                        </div>
                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="profesor"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">
                                                Entrar como profesor
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="footer-copyright text-center text-white fixed-bottom py-3 z-depth-2">
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
        <script type="text/javascript" src="../js/validar.js">
        </script>
    </body>
</html>
