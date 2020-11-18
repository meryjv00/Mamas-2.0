<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Entrar como...</title>
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
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top">
                <div class="container">
                    <!--Left-->
                    <ul class="navbar-nav mr-auto smooth-scroll"></ul>
                    <!-- Right -->
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <form name="cerrarSes" action="../Controlador/controlador.php" method="post">
                                <input type="submit" class="btn mean-fruit-gradient text-white
                                       btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Cerrar sesión">
                            </form>
                        </li> 
                    </ul>
                </div>
            </nav>
        </header>
        <div class="pt-5"></div>
        <main class="container my-5 px-0 z-depth-1 ">
            <!--Section: Content-->
            <section class="pb-5 text-center ">
                <div class="row">  
                    <div class="col-md-8 mx-auto">
                        <img src="../img/log0.png" width="220px"/>
                        <!--BORDE-->
                        <div class="card mb-5" style="border: 2px solid antiquewhite">

                            <div class="card-body">

                                <form class="text-center needs-validation" style="color: #757575;" action="../Controlador/controlador.php" method="POST" novalidate>

                                    <h3 class="font-weight-bold my-4 pb-2 text-center tit">Bienvenido <?= $usu->getNombre() ?></h3>

                                    <div class="text-center mb-3 pl-5 pr-5">
                                        <button type="submit" name="CRUDadmin"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">
                                            Entrar como administrador
                                        </button>
                                    </div>
                                    <div class="text-center mb-3 pl-5 pr-5">
                                        <button type="submit" name="CRUDprofesor"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">
                                            Entrar como profesor
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

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
