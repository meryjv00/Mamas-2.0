<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Crear pregunta para exámen</title>
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
    <body onload="validarPregunta()">
        <?php
        include_once '../Modelo/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
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
                                        btn-rounded waves-effect z-depth-1a" name="crearExamenes" value="Crear exámenes">
                                    Crear exámenes
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
                            <div class="row view view-cascade gradient-card-header">
                                <!-- Title -->
                                <div class="col-md-9"></div>
                                <select id="tipoPregunta" class="col-md-3 mx-auto browser-default custom-select">
                                    <option  value="PreguntaCorta" selected>Pregunta corta</option>
                                    <option  value="Test">Test</option>
                                </select>
                                <h2 class="col-md-12 card-header-title font-weight-bold text-center letra display-4 titulo2 pt-2 pb-2 ">Crear pregunta</h2>
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
                                                    <div class="col">
                                                        <select class="browser-default custom-select" id="asignaturas">
                                                            <option value="0" selected>Seleccione una asignatura</option>
                                                            <option value="1">DWES</option>
                                                            <option value="2">DWEC</option>
                                                            <option value="3">DAW</option>
                                                            <option value="3">DI</option>
                                                            <option value="3">EIE</option>
                                                        </select>
                                                    </div>
                                                    <!--Puntuacion-->
                                                    <div class="col">
                                                        <input type="number" id="puntuacion" class="form-control mb-4" placeholder="Puntuación" min="1" max="100" value="10">
                                                    </div>
                                                    <!--Enunciado-->
                                                    <input type="text" id="enunciado" class="form-control mb-4" placeholder="Enunciado">

                                                    <!--MOSTRAR OPCIONES EXAMEN-->
                                                    <div class="accordion text-center d-none" id="accordion1" style="width: 620px">
                                                        <div class="card z-depth-0 bordered">
                                                            <div class="card-header" id="heading1">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse1"
                                                                            aria-expanded="false" aria-controls="collapse1">
                                                                        Opciones añadidas
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="collapse1" class="collapse" aria-labelledby="heading1"
                                                                 data-parent="#accordion1">
                                                                <div class="card-body">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--MOSTRAR PALABRAS CLAVE-->
                                                    <div class="accordion text-center " id="accordion2" style="width: 620px">
                                                        <div class="card z-depth-0 bordered">
                                                            <div class="card-header" id="heading2">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse2"
                                                                            aria-expanded="false" aria-controls="collapse2">
                                                                        Palabras clave añadidas
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                                                 data-parent="#accordion2">
                                                                <div class="card-body">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--AÑADIR OPCION-->
                                                    <div id="addOpcion" class="mt-3 col-md-12 card card-cascade narrower d-none">
                                                        <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                                            <h2 class="card-header-title text-center titulo text-white pt-1">Añadir opción</h2>
                                                        </div>
                                                        <div class="card-body card-body-cascade">
                                                            <p style="font-size: 25px;color: #4D2034"><i class="fas fa-angle-right pr-2" ></i>Introducir opción</p>
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <input type="text" required id="opcion" name="opcion" class="form-control mb-4" placeholder="Escribe aquí la opción, si es correcta marca el checkbox >>">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox mt-2" >
                                                                        <input type="checkbox" class="custom-control-input" id="correcto" name="correcto" 
                                                                               style="width: 200px; height: 200px">
                                                                        <label class="custom-control-label" for="correcto"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 text-center mx-auto">
                                                                <button type="submit" name="aniadirOpcion"  class="btn mean-fruit-gradient text-white 
                                                                        btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir opción</button>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <!--AÑADIR PALABRAS CLAVE-->
                                                    <div id="addClave" class="mt-3 col-md-12 card card-cascade narrower ">
                                                        <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                                            <h2 class="card-header-title text-center titulo text-white pt-1">Añadir palabra clave</h2>
                                                        </div>
                                                        <div class="card-body card-body-cascade">
                                                            <p style="font-size: 25px;color: #4D2034"><i class="fas fa-angle-right pr-2" ></i>Introducir palabra clave</p>

                                                            <input type="text" id="palabraClave" name="palabraClave" class="form-control mb-4" 
                                                                   placeholder="Escribe aquí la palabra clave" required>

                                                            <div class="col-md-8 text-center mx-auto">
                                                                <button type="submit" name="aniadirPalabraClave"  class="btn mean-fruit-gradient text-white 
                                                                        btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir palabra clave</button>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <!--BOTON AÑADIR PREGUNTA-->
                                                    <div class="col-md-12"></div>
                                                    <div class="col-md-8 text-center mx-auto">
                                                        <button type="submit" name="aniadirPregunta"  class="btn mean-fruit-gradient text-white 
                                                                btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir pregunta</button>
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

                <div class="col-md-3 mt-5 card card-cascade narrower">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                        <!-- Title -->
                        <h2 class="card-header-title text-center titulo text-white pt-1">VISTA PREVIA</h2>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                        <!-- Text -->
                        <form name="formPregunta" action="../Controlador/controladorProfesor.php" class="row" method="post">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="aniadirPreguntas"  class="btn mean-fruit-gradient text-white 
                                        btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir preguntas al exámen</button>
                            </div>
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
        <script type="text/javascript" src="../js/validar.js"></script>
    </body>
</html>
