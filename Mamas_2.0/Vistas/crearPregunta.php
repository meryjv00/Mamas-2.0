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
        include_once '../Modelo/Profesor.php';
        include_once '../Modelo/Alumno.php';
        include_once '../Modelo/Asignatura.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $asignatura = $_SESSION['asignaturasImpartidas'];
        ?>
        <!--******************************************************************************-->
        <!--******************************************************************************-->
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
        <!--******************************************************************************-->
        <!--******************************************************************************-->
        <main class="pb-5 pt-5 mb-5">
            <div class="container-fluid row ">
                <div class="col-md-9 mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-4 bg-white">
                            <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                <!-- Title -->
                                <h1 class="card-header-title text-center titulo text-white pt-1">Crear pregunta</h1>
                            </div>
                            <div class="justify-content-center">
                                <!--Section: Content-->
                                <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text mt-3">

                                    <!--Grid row-->
                                    <div class="row d-flex justify-content-center">
                                        <!--Grid column-->
                                        <div class="col-md-10">
                                            <div class="form-row">
                                                <!--Asignatura-->
                                                <div class="col-md-6">
                                                    <span>Asignatura: </span>
                                                    <select class="browser-default custom-select " id="asignaturas">
                                                        <option>Seleccione una asignatura</option>
                                                        <?php for ($i = 0; $i < count($asignatura); $i++) { ?>
                                                            <option value="<?= $asignatura[$i]->getNombre() ?>" ><?php echo $asignatura[$i]->getNombre(); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <!-- Title -->
                                                <div class="col-md-6">
                                                    <span>Tipo de pregunta: </span>
                                                    <select id="tipoPregunta" class=" browser-default custom-select">
                                                        <option  value="SeleccionePregunta" selected>Seleccione tipo de pregunta</option>
                                                        <option  value="PreguntaCorta" >Pregunta corta</option>
                                                        <option  value="Test">Test</option>
                                                    </select>
                                                </div>
                                                <!--Puntuacion-->
                                                <div class="col-md-5 mt-3"> 
                                                    <span>Puntuación (sobre 100): </span>
                                                    <input type="number" id="puntuacion" class="form-control" placeholder="Puntuación" min="1" max="100" value="10">
                                                </div>

                                                <!--Enunciado-->
                                                <div class="col-md-12 mt-3 form-group shadow-textarea">
                                                    <label for="enunciado">Enunciado: </label>
                                                    <textarea class="form-control z-depth-1" id="enunciado" rows="3" placeholder="Escribe el enunciado aquí..."></textarea>
                                                </div>
                                                <!--BOTON AÑADIR PREGUNTA-->
                                                <button name="aniadirPregunta"  class="col-md-4  mb-2 mx-auto btn purple lighten-3 text-white 
                                                        btn-block btn-rounded waves-effect z-depth-1a" onclick="addPregunta()">Añadir pregunta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <!--AÑADIR OPCIONES-->
                    <div class="row">
                        <div id="addOpcion" class="col-md-10 mx-auto mt-3 card card-cascade narrower pb-4 bg-white d-none">
                            <div class=" view view-cascade gradient-card-header mean-fruit-gradient">
                                <h3 class="card-header-title text-center text-white pt-1">Añadir opciones</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <!--ACORDEON VER OPCIONES AÑADIDAS-->
                                    <div class="mt-3 accordion text-center" id="accordion1" >
                                        <div class="card z-depth-0 bordered ">
                                            <div class="card-header" id="heading1">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse1"
                                                            aria-expanded="false" aria-controls="collapse1">
                                                        Opciones añadidas
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse1" class="collapse show" aria-labelledby="heading1"
                                                 data-parent="#accordion1">
                                                <div class="card-body">
                                                    <table class="table table-hover mb-0">
                                                        <!--Table head-->
                                                        <thead>
                                                            <tr>
                                                                <th class="th-lg"><a>Id <i class="fas fa-sort ml-1"></i></a></th>
                                                                <th class="th-lg"><a>Opción <i class="fas fa-sort ml-1"></i></a></th>
                                                                <th class="th-lg"><a>Correcto <i class="fas fa-sort ml-1"></i></a></th>
                                                            </tr>
                                                        </thead>
                                                        <!--Table head-->

                                                        <!--Table body-->
                                                        <tbody id="bodyOpciones">
                                                        </tbody>
                                                        <!--Table body-->
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body card-body-cascade">
                                        <span>Introducir opción (si la opción es correcta marca el checkbox): </span>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <input type="text" required id="opcion" name="opcion" class="form-control mb-4" placeholder="Escribe aquí la opción" required>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="custom-control custom-checkbox mt-2" >
                                                    <input type="checkbox" class="custom-control-input" id="correcto" name="correcto">
                                                    <label class="custom-control-label" for="correcto"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center mx-auto">
                                            <button name="aniadirOpcion"  class="btn purple lighten-3 text-white 
                                                    btn-block btn-rounded waves-effect z-depth-1a" onclick="addOpcionT()">Añadir opción</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--AÑADIR PALABRAS CLAVES-->
                    <div class="row">
                        <!--AÑADIR PALABRAS CLAVE-->
                        <div id="addClave" class="mt-3 col-md-10 mx-auto card card-cascade narrower  d-none">
                            <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                <h3 class="card-header-title text-center text-white pt-1">Añadir palabras clave</h3>
                            </div>
                            <!--MOSTRAR PALABRAS CLAVE-->
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="mt-3 accordion text-center " id="accordion2" >
                                        <div class="card z-depth-0 bordered ">
                                            <div class="card-header" id="heading2">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link " type="button" data-toggle="collapse" data-target="#collapse2"
                                                            aria-expanded="false" aria-controls="collapse2">
                                                        Palabras clave añadidas
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse2" class="collapse show" aria-labelledby="heading2" data-parent="#accordion2">
                                                <div class="card-body">
                                                    <table class="table table-hover mb-0">
                                                        <!--Table head-->
                                                        <thead>
                                                            <tr>
                                                                <th class="th-lg"><a>Id <i class="fas fa-sort ml-1"></i></a></th>
                                                                <th class="th-lg"><a>Palabra clave <i class="fas fa-sort ml-1"></i></a></th>
                                                            </tr>
                                                        </thead>
                                                        <!--Table head-->
                                                        <!--Table body-->
                                                        <tbody id="bodyPalabrasClave">
                                                        </tbody>
                                                        <!--Table body-->
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body card-body-cascade">
                                        <span>Palabra clave:</span>
                                        <input type="text" id="palabraClave" name="palabraClave" class="form-control mb-4" 
                                               placeholder="Escribe aquí la palabra clave" required>

                                        <div class="col-md-6 text-center mx-auto">
                                            <button  name="aniadirPalabraClave"  class="btn purple lighten-3 text-white 
                                                     btn-block btn-rounded  waves-effect z-depth-1a" onclick="addPalabraClave()">Añadir palabra clave</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--VISTA PREVIA-->
                <div class="col-md-3 mt-5 card card-cascade narrower align-self-start">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                        <!-- Title -->
                        <h2 class="card-header-title text-center titulo text-white pt-1">Vista previa</h2>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                        <ul id="preguntasCreadas" class="list-group list-group-flush">
                        </ul>
                        <!-- Text -->
                        <form id="formuAddPreguntas" action="../Controlador/controladorProfesor.php" method="post" novalidate>
                            <div class="col-md-12 mx-auto text-center">
                                <button type="submit" name="aniadirPreguntas" class="btn purple lighten-3 text-white 
                                        btn-block btn-rounded my-4 waves-effect z-depth-1a" onclick="addPreguntas()">Crear preguntas
                                </button>
                                <input type="hidden" name="json" id="json"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <!--******************************************************************************-->
        <!--******************************************************************************-->
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
        <script type="text/javascript" src="../js/validar.js"></script><!-- comment -->
        <script type="text/javascript" src="../js/objetos.js"></script>
        <!--<script type="text/javascript" src="../js/obj.js"></script>-->
    </body>
</html>
