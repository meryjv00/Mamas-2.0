<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Creaccion Examen</title>
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
                            <!--HOME PAGINA INICIO-->
                            <button type="submit" class="btn mean-fruit-gradient text-white
                                    btn-rounded waves-effect z-depth-1a" name="home" value="home">
                                <i class="fas fa-home"></i>
                            </button>
                            <!--HOME PAGINA INICIO-->
                            <a href="crearExamen.php" class="btn mean-fruit-gradient btn-rounded text-white">
                                <i class="fas fa-arrow-left"></i>
                            </a>
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
            <div class="container-fluid row ">
                <div class="col-md-9 mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-5 bg-transparent">
                            <div class="view view-cascade gradient-card-header">
                                <!-- Title -->
                                <h2 class="card-header-title font-weight-bold text-center letra display-4 titulo2 pt-2 pb-2 ">Nuevo Examen</h2>
                            </div>
                            <div class="justify-content-center">
                                <form name="formPreg" action="../Controlador/controladorProfesor.php" method="post" novalidate>

                                    <!--Section: Content-->
                                    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text mt-3">
                                        <!--Grid row-->
                                        <div class="row d-flex justify-content-center">
                                            <!--Grid column-->
                                            <div class="col-md-10">
                                                <div class="form-row mb-4">
                                                    <!--Asignatura-->
                                                    <div class="col pr-3">
                                                        <label for="asignaturas">Asignatura</label>

                                                        <select class="browser-default custom-select " name="asignaturas" id="asignaturas">
                                                            <option value="0" selected>Seleccione una asignatura</option>
                                                            <?php for ($i = 0; $i < count($asignatura); $i++) { ?>
                                                                <option value="<?php echo $asignatura[$i]->getIdAsignatura(); ?>" name="<?php echo $asignatura[$i]->getNombre(); ?>"><?php echo $asignatura[$i]->getNombre(); ?></option>
                                                            <?php } ?>
                                                        </select>

                                                        <div class="pt-5">
                                                            <label for="descripcion">Descripcion</label>
                                                            <textarea style="resize: none"  rows="5" cols="10" id="descripcion" name="descripcion" class="form-control mb-4" placeholder="Descripcion"></textarea>
                                                        </div>
                                                    </div>
                                                    <!--Contenido-->
                                                    <div class="col">
                                                        <label for="contenido">Contenido</label>
                                                        <input type="text" id="contenido" name="contenido" class="form-control mb-4" >
                                                        <div class=" pt-3">
                                                            <label for="contenido">Fecha inicio</label>
                                                            <input type="date" name="fechainicio" id="fechainicio" class="form-control mb-4" placeholder="Enunciado">
                                                            <label for="contenido">Fecha Fin</label>
                                                            <input type="date" name="fechafin" id="fechafin" class="form-control mb-4" placeholder="Enunciado">
                                                        </div>
                                                        <!--BOTON CREAR EXAMEN-->
                                                        <div class="col-md-12"></div>
                                                        <button type="submit" name="crearExamen"  class="btn mean-fruit-gradient text-white 
                                                                btn-block btn-rounded my-4 waves-effect z-depth-1a">Crear Examen</button>
                                                    </div>
                                                </div>
                                                <!--Grid column-->
                                            </div>
                                            <!--Grid row-->
                                    </section>
                                    <!--Section: Content-->
                                </form>
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
        <script type="text/javascript" src="../js/validar.js"></script>
        <script type="text/javascript" src="../js/diseño.js"></script>
    </body>
</html>
