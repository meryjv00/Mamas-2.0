<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asignar preguntas</title>
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
        include_once '../Modelo/Pregunta.php';
        include_once '../Modelo/Respuesta.php';
        include_once '../Modelo/Examen.php';
        include_once '../Modelo/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
        $examenS = $_SESSION['examenS'];
        if (isset($_SESSION['preguntasCreadas'])) {
            $preguntasCreadas = $_SESSION['preguntasCreadas'];
        }
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
                <div class=" col-md-8 mx-auto mt-5">
                    <div class="row">
                        <div class="col-md-10 mx-auto card card-cascade narrower pb-5 bg-white">
                            <div class="view view-cascade gradient-card-header mean-fruit-gradient">
                                <!-- Title -->
                                <h2 class="card-header-title  text-center titulo text-white pt-2 pb-2 ">Asignar preguntas a exámen</h2>
                            </div>
                            <div class="justify-content-center">
                                <form name="formPreg" action="../Controlador/controladorProfesor.php" method="post">
                                    <!--Section: Content-->
                                    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text mt-3">
                                        <!--Grid row-->
                                        <div class="row d-flex justify-content-center">
                                            <!--Grid column-->
                                            <div class="col-md-10">
                                                <div class="form-row">
                                                    <!--Asignatura-->
                                                    <div class="form-row col-12">
                                                        <div class="col-md-6 col-s-12 mx-auto">
                                                            <button type="submit" name="crearPreguntasEx"  class="btn purple lighten-3 text-white 
                                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Crear preguntas
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6 col-s-12 mx-auto">
                                                            <button type="submit" name="verPreguntasCreadas"  class="btn purple lighten-3 text-white 
                                                                    btn-block btn-rounded my-4 waves-effect z-depth-1a">Ver preguntas creadas
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row mt-3">
                                                    <div class="border w-100">
                                                        <h1 class="text-center"><?= $examenS->getContenido() ?></h1>
                                                        <p class="pl-4"><?= $examenS->getDescripcion() ?></p>
                                                    </div>
                                                </div>
                                                <div class="form-row mt-3">
                                                    <div class="border w-100">
                                                        <h1 class="text-center">Preguntas</h1>
                                                        <?php
                                                        if (isset($preguntasCreadas)) {
                                                            echo '<hr>';
                                                            foreach ($preguntasCreadas as $i => $pregunta) {
                                                                echo 'ID PREGUNTA: ' . $pregunta->getId() . '<br>';
                                                                echo 'ENUNCIADO: ' . $pregunta->getEnunciado() . ' <br>';
                                                                $respuestas = $pregunta->getRespuestas();
                                                                if ($pregunta->getTipo() == 0) {
                                                                    echo 'PALABRAS CLAVE: <br>';
                                                                } else {
                                                                    echo 'OPCIONES: <br>';
                                                                }
                                                                foreach ($respuestas as $j => $respuesta) {
                                                                    echo 'ID:' . $respuesta->getId() . ' ';
                                                                    echo $respuesta->getRespuesta() . '<br>';
                                                                }
                                                                echo '<hr>';
                                                            }
                                                        } else {
                                                            ?>
                                                            <p class="pl-4 font-weight-bold">
                                                                Añade nuevas preguntas desde "Crear pregunta" o  desde 
                                                                "Ver preguntas creadas" para elegir una pregunta ya creada.
                                                            </p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <button type="submit" name="aniadirPreguntasExamen"  class="col-md-6 mx-auto btn purple lighten-3 text-white 
                                                            btn-block btn-rounded my-4 waves-effect z-depth-1a">Añadir preguntas al exámen
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                            </div>
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
