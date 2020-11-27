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
    <body onload="validacionExamen()">
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

                        </form>
                    </ul>
                    <!-- Right -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form name="formu" action="../Controlador/controladorProfesor.php" method="post">
                                <button type="submit" class="btn mean-fruit-gradient text-white 
                                        btn-rounded waves-effect z-depth-1a" name="verExamenes" value="Ver exámenes">
                                    <i class="far fa-eye pr-1"></i> exámenes
                                </button>
                                <button type="submit" class="btn mean-fruit-gradient text-white 
                                        btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                    <i class="fas fa-plus pr-1"></i> exámenes
                                </button>
                                <button type="submit" class="btn mean-fruit-gradient text-white 
                                        btn-rounded waves-effect z-depth-1a" name="crearPreguntas" value="Crear preguntas">
                                    <i class="fas fa-plus pr-1"></i>  preguntas
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

        <main class="pt-5 pb-5 ml-4 align-content-center">
            <div class="container-fluid row ">
                <div class="col-md-2 "></div> 
                <div class=" col-md-8 mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-5 bg-white">
                            <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                <!-- Title -->
                                <h2 class="card-header-title  text-center titulo text-white pt-2 pb-2  ">Nuevo exámen</h2>
                            </div>
                            <div class="justify-content-center">
                                <form id="formExamen" name="formExamen" action="../Controlador/controladorProfesor.php" method="post" novalidate>

                                    <!--Section: Content-->
                                    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text mt-3">
                                        <!--Grid row-->
                                        <div class="row d-flex justify-content-center">
                                            <!--Grid column-->
                                            <div class="col-md-10">
                                                <div class="form-row">
                                                    <!--Asignatura-->
                                                    <div class="form-row col-12">
                                                        <div class="col-md-6 col-s-12">
                                                            <label  for="asignaturas">Asignatura</label>

                                                            <select class="browser-default custom-select " name="asignaturas" id="asignaturas" required>
                                                                <option value="Seleccione una asignatura" selected>Seleccione una asignatura</option>
                                                                <?php for ($i = 0; $i < count($asignatura); $i++) { ?>
                                                                    <option value="<?php echo $asignatura[$i]->getIdAsignatura(); ?>" name="<?php echo $asignatura[$i]->getNombre(); ?>"><?php echo $asignatura[$i]->getNombre(); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div name="asignaturaError"  id="asignaturasError"></div>

                                                        </div>
                                                        <div class="pl-3 col-md-6 col-s-12">
                                                            <label for="contenido">Contenido</label>
                                                            <input type="text" id="contenido" name="contenido" class="form-control mb-4" required>
                                                            <div name="contenidoError"  id="contenidoError"></div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2 form-row col-12">
                                                        <div class=" col-md-6 col-s-12">
                                                            <label for="descripcion">Descripcion</label>
                                                            <textarea style="resize: none"  rows="5" cols="10" id="descripcion" name="descripcion" class="form-control mb-4" placeholder="Descripcion" required></textarea>
                                                            <div name="descripcionError"  id="descripcionError"></div>
                                                        </div>
                                                        <!--Contenido-->
                                                        <div class="pl-3 col-md-6 col-s-12">

                                                            <label for="fechai">Fecha inicio</label>
                                                            <input type="date" name="fechainicio" id="fechainicio" class="form-control mb-4" placeholder="Enunciado">
                                                            <label for="fechaf">Fecha Fin</label>
                                                            <input type="date" name="fechafin" id="fechafin" class="form-control" placeholder="Enunciado">
                                                        </div>
                                                        <!--BOTON CREAR EXAMEN-->
                                                        <div class="col-md-6 col-s-12 mx-auto">
                                                            <button type="submit" name="crearExamen"  class="btn purple lighten-3 text-white 
                                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a" onclick="addExamen()">Crear Examen</button>
                                                        </div>
                                                    </div>
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

                </div><div class="col-md-2 "></div> 



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
