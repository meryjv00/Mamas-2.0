<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forgot password?</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="../css/mdb.min.css">
        <!-- Your custom styles (optional) -->
        <link rel="stylesheet" href="../css/style.css">
        <script src='https://www.google.com/recaptcha/api.js?render=6LdU7-QZAAAAANmiNBKJU677B_eGaE-tJsZL0TMT'>
        </script>
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('6LdU7-QZAAAAANmiNBKJU677B_eGaE-tJsZL0TMT', {action: 'login'})
                        .then(function (token) {
                            var recaptchaResponse = document.getElementById('recaptchaResponse');
                            recaptchaResponse.value = token;
                        });
            });
        </script>
    </head>
    <body onload="validacionLogin()">
        <div class="container my-5 px-0 z-depth-1">
            <!--Section: Content-->
            <section class="pb-5 my-md-5 text-center">
                <div class="my-5 mx-md-5">
                    <a href="../index.php"><img src="../img/log0.png" width="250px"/></a>
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Material form login -->
                            <div class="card" style="border: 2px solid antiquewhite">

                                <!--Card content-->
                                <div class="card-body">

                                    <!-- Form -->
                                    <form id="login" class="text-left needs-validation" style="color: #757575;" action="../Controlador/enviar.php" method="POST" novalidate>
                                        <h1 class="font-weight-bold my-4 pb-2 text-center tit">Forgot password?</h1>
                                        <div class="md-form form-group ml-5 mr-5 ">
                                            <input type="email" id="email" name="email" class="form-control mb-4 " required>
                                            <label class="form-control-label" for="email">E-mail</label>
                                            <div name="emailError" class="" id="emailError"></div>
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
                                            <button type="submit" name="olvidado"  class="btn mean-fruit-gradient text-white btn-block btn-rounded my-4 waves-effect z-depth-1a">Send</button>
                                        </div>
                                        <div class="mx-5 pt-3 mb-1 text-right " >
                                            <a href="login.php" style="color: #D681E8"> >> Back</a>
                                        </div>

                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
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
