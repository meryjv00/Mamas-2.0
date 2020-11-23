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
    </head>
    <body>
        <?php
        session_start();

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;

        require_once '../phpmailer/src/Exception.php';
        require_once '../phpmailer/src/PHPMailer.php';
        require_once '../phpmailer/src/SMTP.php';
        require_once '../Auxiliar/gestionDatos.php';
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LdU7-QZAAAAAChZ7pnDbgTL--nSmYG6aJxTMj2f';
        $recaptcha_response = $_POST['recaptcha_response'];
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if ($recaptcha->score >= 0.7) {
            $emailDestino = $_REQUEST['email'];

            $mail = new PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'AuxiliarDAW2@gmail.com';
                $mail->Password = 'Chubaca20';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('AuxiliarDAW2@gmail.com');
                $mail->addAddress($emailDestino);

                $mail->isHTML(true);
                $mail->Subject = 'Recupera tu cuenta';

                $az = rand(1, 99999);

                $mail->Body = 'Nueva contraseña:<b>' . $az . '</b>';
                $mail->AltBody = 'Contraseña olvidada';

                $mail->send();

                if (gestionDatos::setPassword($emailDestino, md5($az))) {
                    $_SESSION['mensaje'] = 'Correo enviado';
                } else {
                    $_SESSION['mensaje'] = 'No se ha podido establecer la contraseña';
                }
                header('Location: ../Vistas/login.php');
            } catch (Exception $e) {
                $_SESSION['mensaje'] = 'No se ha podido enviar el correo';
            }
        } else {
            $mensaje = 'Error captcha no superado.';
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/olvidado.php');
        }
        ?>
        
    </body>
</html>
