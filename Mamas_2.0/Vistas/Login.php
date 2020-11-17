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

        <?php
        // put your code here
        ?>
        <div class="container my-5 px-0 z-depth-1 ">

            <!--Section: Content-->
            <section class="p-5 my-md-5 text-center " >
                <div class="col-md-6 mx-auto">
                    <!-- Material form login -->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                            <!-- Form -->
                            <form class="text-center" style="color: #757575;" action="../Controlador/controlador.php" method="POST">

                                <h3 class="font-weight-bold my-4 pb-2 text-center dark-grey-text">Log in</h3>

                                <!-- email -->


                                <div class="md-form">
                                    <input type="email" id="email" class="form-control mb-4">
                                    <label class="purple-text" for="email">e-mail</label>
                                </div>
                                <!-- password -->
                                <div class="md-form">
                                    <input type="password" id="password" class="form-control">
                                    <label for="password">Contraseña</label>
                                </div>
                                <small id="olvidado" class="form-text text-right blue-text">
                                    <a href="">¿Contraseña olvidada?</a>
                                </small>

                                <div class="text-center">
                                    <button type="submit" id="login" class="btn purple-gradient  my-4 waves-effect">Iniciar Sesion</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
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
