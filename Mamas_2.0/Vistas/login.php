<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign in</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="../css/mdb.min.css">
        <!-- Your custom styles (optional) -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body onload="login()">

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
                                    <form class="text-center needs-validation" style="color: #757575;" action="../Controlador/controlador.php" method="POST" novalidate>

                                        <h3 class="font-weight-bold my-4 pb-2 text-center dark-grey-text display-4">Log in</h3>

                                        <div class="md-form form-group">
                                            <input type="email" id="email" name="email" class="form-control mb-4" required>
                                            <label class="form-control-label" for="email">E-mail</label>

                                        </div>
                                        <!-- password -->
                                        <div class="md-form form-group">
                                            <input type="password" id="password" name="password" class="form-control" required>
                                            <label class="form-control-label"  for="password">Password</label>

                                        </div>
                                        <?php
                                        session_start();
                                        if (isset($_SESSION['mensaje'])) {
                                            $mensaje = $_SESSION['mensaje'];
                                            echo $mensaje . '<br>';
                                            unset($_SESSION['mensaje']);
                                        }
                                        ?>

                                        <div class="text-center mb-3 pl-5 pr-5">
                                            <button type="submit" name="login"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">Log in</button>
                                        </div>

                                        <div class="modal-footer mx-5 pt-3 mb-1">
                                            <span>
                                                <a href="registro.php" style="color: #D681E8">Don't have an account?</a>
                                                or <a href="olvidado.php" style="color: #D681E8">Forgot password?</a>
                                            </span>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
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
        <script type="text/javascript" src="../js/validar.js">
        </script>
    </body>
</html>
