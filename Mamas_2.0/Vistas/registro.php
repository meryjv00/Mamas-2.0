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
    </head>
    <body>
        <div class="container my-5 px-0 z-depth-1">
            <!--Section: Content-->
            <section class="p-5 my-md-5 text-center">
                <div class="my-5 mx-md-5">

                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Material form login -->
                            <div class="card" style="border: 2px solid antiquewhite">

                                <!--Card content-->
                                <div class="card-body">

                                    <!-- Form -->
                                    <form class="text-center" style="color: #757575;" action="../Controlador/controlador.php">

                                        <h3 class="font-weight-bold my-4 pb-2 text-center dark-grey-text display-4">Sign Up</h3>

                                        <!--Nombre y apellidos-->
                                        <div class="form-row">
                                            <div class="col">
                                                <!-- First name -->
                                                <div class="md-form">
                                                    <input type="text" id="nombre" name="nombre" class="form-control">
                                                    <label for="nombre">First name</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!-- Last name -->
                                                <div class="md-form">
                                                    <input type="text" id="lastname" name="apellido" class="form-control">
                                                    <label for="apellido">Last name</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="md-form mt-0">
                                            <input type="email" id="email" name="email" class="form-control mb-4">
                                            <label for="email">E-mail </label>
                                        </div>

                                        <!-- Dni -->
                                        <div class="md-form">
                                            <input type="text" id="dni" name="dni" class="form-control mb-4" >
                                            <label for="dni">Dni </label>
                                        </div>

                                        <!-- Tfno -->
                                        <div class="md-form">
                                            <input type="text" id="phone" name="tfno" class="form-control mb-4">
                                            <label for="tfno">Phone number</label>
                                        </div>

                                        <!-- Pass -->
                                        <div class="md-form">
                                            <input type="password" id="pass" name="pass" class="form-control">
                                            <label for="pass">Password </label>
                                        </div>

                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="button" class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 
                                                    waves-effect z-depth-1a">Sign up</button>
                                        </div>
                                        
                                        <div class="modal-footer mx-5 pt-3 mb-1">
                                            <span>Already have an account?
                                                <a href="inicio.php" style="color: #D681E8">Sign in</a>
                                            </span>
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
        <script type="text/javascript"></script>

    </body>
</html>
