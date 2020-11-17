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
        <header class="row">
            <div class="col-3 bg-secondary"><p>LOGO</p></div>

        </header>
        <section id="form" class="row">
            <div class="col-2"></div>
            <div id="formularioLogin" class="card col-8">

                <h5 class="card-header info-color white-text text-center py-4">
                    <strong>Inicio de Sesion</strong>
                </h5>

                <!--Card content-->
                <div class="card-body px-lg-5 pt-0">

                    <!-- Form -->
                    <form class="text-center" style="color: #757575;" method="POST" action="../Controlador/Controlador.php">

                        <!-- Email -->
                        <div class="md-form">
                            <input type="email" id="email" class="form-control">
                            <label for="email">E-mail</label>
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <input type="password" id="password" class="form-control">
                            <label for="password">Password</label>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div>
                                <!-- Forgot password -->
                                <a href="../Vistas/olvidado.php">¿Has olvidado tu contraseña?</a>
                            </div>
                        </div>

                        <!-- Sign in button -->
                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>

                        <!-- Register -->
                        <p>Not a member?
                            <a href="../Vistas/registro.php">Registrarse</a>
                        </p>

                    </form>
                </div>

            </div>
            <div class="col-2"></div>
        </section>
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
