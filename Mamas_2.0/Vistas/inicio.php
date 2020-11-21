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
        session_start();
        $asignaturas = $_SESSION['asignaturas'];
        ?>
        <header>
            <nav class="row navbar navbar-expand-lg navbar-dark fixed-top deg">
                <div class="container-fluid">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item">
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
        <main class="pb-5 pt-5">
            <div class="container-fluid row">
                <div class="col-md-9 d-flex justify-content-center p1 p2">
                    <div class="row">
                        <h1 class="col-md-12 font-weight-bold text-center tit ml-5 mt-5">Mis asignaturas</h1>
                        <?php
                        foreach ($asignaturas as $i => $asignatura) {
                            ?>
                            <div class="col-md-3 card card-cascade narrower card-ecommerce mt-3 ml-3 mr-3 " style="height: 280px" >
                                <!-- Card image -->
                                <div class="view overlay zoom" style="height: 200px">
                                    <img src="data:image/png;base64,<?php echo base64_encode($asignatura->getImagen()); ?>" alt="titulo foto" class="img-fluid"
                                         />
                                    <div class="mask flex-center">
                                        <p class="white-text"><i class="fas fa-arrow-right" style="color:#543b54;font-size: 40px"></i></p>
                                    </div>
                                </div>
                                <!-- Card image -->
                                <!-- Card content -->
                                <div class="card-body card-body-cascade text-center">
                                    <!-- Category & Title -->
                                    <a href="" class="text-muted">
                                        <h5><?= $asignatura->getNombre() ?></h5>
                                    </a>
                                    <!-- Card content -->
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </div>

                <div class="col-md-3 mt-5 card card-cascade narrower">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                        <!-- Title -->
                        <h2 class="card-header-title text-center titulo">Exámenes sin realizar</h2>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                        <!-- Text -->
                        <form name="cerrarSes" action="../Controlador/controlador.php" method="post">
                            <p  style="font-size: 25px"><i class="fas fa-angle-right pr-2" ></i>Exámen 1</p>
                            <p class="card-text">Tema 4 - GUIT: Exámen tipo test u4</p>
                            <input type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="cerrarSesion" value="Realizar exámen"/>
                        </form>

                        <hr>
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
    </body>
</html>
