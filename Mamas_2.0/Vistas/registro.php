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
        <div class="container my-5 px-0 z-depth-2">
            <!--Section: Content-->
            <section class="p-5 my-md-5 text-center">
                <div class="my-5 mx-md-5">

                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <!-- Material form login -->
                            <div class="card">

                                <!--Card content-->
                                <div class="card-body">

                                    <!-- Form -->
                                    <form class="text-center" style="color: #757575;" action="../Controlador/controlador.php">

                                        <h3 class="font-weight-bold my-4 pb-2 text-center dark-grey-text">Sign In</h3>

                                        <!-- Email -->
                                        <div class="md-form">
                                            <input type="email" id="email" name="email" class="form-control mb-4">
                                            <label for="email">E-mail *</label>
                                        </div>

                                        <!-- Dni -->
                                        <div class="md-form">
                                            <input type="text" id="dni" name="dni" class="form-control mb-4" >
                                            <label for="dni">Dni *</label>
                                        </div>

                                        <!-- Nombre -->
                                        <div class="md-form">
                                            <input type="text" id="name" name="name" class="form-control mb-4">
                                            <label for="name">Name *</label>
                                        </div>

                                        <!-- Apellidos -->
                                        <div class="md-form">
                                            <input type="text" id="surnames" name="surnames" class="form-control mb-4">
                                            <label for="surnames">Surnames *</label>
                                        </div>

                                        <!-- Nick -->
                                        <div class="md-form">
                                            <input type="text" id="nick" name="nick" class="form-control mb-4">
                                            <label for="nick">Nick</label>
                                        </div>
                                        
                                        <!-- Tfno -->
                                        <div class="md-form">
                                            <input type="text" id="phone" name="phone" class="form-control mb-4">
                                            <label for="phone">Phone</label>
                                        </div>

                                        <!-- Pass -->
                                        <div class="md-form">
                                            <input type="password" id="pass" name="pass" class="form-control">
                                            <label for="pass">Password *</label>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" class="btn purple-gradient btn-rounded my-4 waves-effect">Sign in</button>
                                        </div>
                                        <span>You already have an account?
                                            <a href="inicio.php" class="text-secondary">Log in</a>
                                        </span>
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
