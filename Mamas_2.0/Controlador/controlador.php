<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
//---------------LOGIN
if (isset($_REQUEST['login'])) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LdU7-QZAAAAAChZ7pnDbgTL--nSmYG6aJxTMj2f';
    $recaptcha_response = $_POST['recaptcha_response'];
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->score >= 0.7) {
        $email = $_REQUEST['email'];
        $password = md5($_REQUEST['password']);
        $usuario = gestionDatos::getUsuario($email, $password);
        if (isset($usuario)) {
            $usuario->setRol(gestionDatos::getRol($usuario->getId()));
            $_SESSION['usuario'] = $usuario;
            if (!isset($_SESSION['usuario'])) {
                $mensaje = 'Error al realizar el Login.';
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../Vistas/login.php');
            } else {
                if ($usuario->getActivo() == 0) {
                    $mensaje = 'Usuario desactivado , contacte con administrador';
                    $_SESSION['mensaje'] = $mensaje;
                    header('Location: ../Vistas/login.php');
                } else if ($usuario->getActivo() == 1) {
                    if ($usuario->getRol() == 0) {
                        header('Location: ../Vistas/inicio.php');
                    } else if ($usuario->getRol() == 1 || $usuario->getRol() == 2) {
                        $asig = gestionDatos::inicializarProfesor($usuario->getId());
                        $_SESSION['asignaturasImpartidas'] = $asig;
                        $_SESSION['examenes'] = $asig[0]->getExamenes();
                        $_SESSION['exCorregidos'] = 0;
                        $_SESSION['exPendientes'] = $_SESSION['examenes'];
                        header('Location: ../Vistas/inicioProfesor.php');
                    }
                    //Obtiene las asignaturas que imparte
                    $asignaturas = gestionDatos::getAsignaturasUsu2($usuario->getId());
                    $_SESSION['asignaturas'] = $asignaturas;
                    //Se obtienen todas las asignaturas para mostrarlas al inicio
                    $todasAsignaturas = gestionDatos::getAsignaturas();
                    $_SESSION['todasAsignaturas'] = $todasAsignaturas;
                }
            }
        } else {
            $mensaje = 'Email o contraseña incorrectos.';
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/login.php');
        }
    } else {
        $mensaje = 'Error captcha no superado.';
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/login.php');
    }
}

//---------------REGISTRO
if (isset($_REQUEST['registro'])) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LetBuUZAAAAACJbleMS9s-GX9s5jhcdRL4gtPP8';
    $recaptcha_response = $_POST['recaptcha_response'];
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    if ($recaptcha->score >= 0.7) {
        // REGISTRO SE ENVIA
        $email = $_REQUEST['email'];
        $dni = $_REQUEST['dni'];
        $nombre = $_REQUEST['nombre'];
        $apellidos = $_REQUEST['apellidos'];
        $tfno = $_REQUEST['tfno'];
        $pass = md5($_REQUEST['pass']);
        if (!gestionDatos::isUsuario($email)) {
            if (!gestionDatos::isDni($dni)) {
                if (!gestionDatos::insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass)) {
                    $mensaje = "No se ha podido insertar el usuario";
                    $_SESSION['mensaje'] = $mensaje;
                    header('Location: ../Vistas/registro.php');
                } else {
                    if (gestionDatos::insertUsuarioRol(gestionDatos::getIdUsuario($email), 0)) {
                        $mensaje = "¡Cuenta creada!";
                        $_SESSION['mensaje'] = $mensaje;
                        header('Location: ../Vistas/login.php');
                    } else {
                        $mensaje = "No se ha podido insertar el rol";
                        $_SESSION['mensaje'] = $mensaje;
                        header('Location: ../Vistas/registro.php');
                    }
                }
            } else {

                $r_usu = new Usuario(0, $email, "", $nombre, $apellidos, $tfno, 0, 0);
                $_SESSION['usu'] = $r_usu;
                $mensaje = "El dni introducido ya está registrado";
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../Vistas/registro.php');
            }
        } else {
            $r_usu = new Usuario(0, "", $dni, $nombre, $apellidos, $tfno, 0, 0);
            $_SESSION['usu'] = $r_usu;
            $mensaje = "El email introducido ya está registrado";
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/registro.php');
        }
    } else {
        $mensaje = 'Error captcha no superado.';
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/registro.php');
    }
}

//-----------------CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    unset($_SESSION['usuario']);
    header('Location: ../index.php');
}

if (isset($_REQUEST['home'])) {
    header('Location: ../Vistas/inicio.php');
}
//-----------------IR A LA PÁGINA PRINCIPAL PROFESORADO
if (isset($_REQUEST['salirVista'])) {
    header('Location: ../Vistas/inicioProfesor.php');
}
//-----------------VER PERFIL
if (isset($_REQUEST['perfil'])) {
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR FOTO PERFIL
if (isset($_REQUEST['editarFotoPerfil'])) {
    gestionDatos::updateFoto($usuario->getId());
    //Obtiene el usuario con la foto actualizada y lo guarda en sesión  
    $_SESSION['usuario'] = gestionDatos::getUsuarioId($usuario->getId());
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR NUMERO TELEFONO
if (isset($_REQUEST['editarTfno'])) {
    $tfno = $_REQUEST['tfno'];
    $usuario->setTelefono($tfno);
    if (!gestionDatos::updateTfno($usuario)) {
        $mensaje = 'No se ha podido cambiar número de teléfono';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR CONTRASEÑA
if (isset($_REQUEST['nuevaPass'])) {
    $pass = md5($_REQUEST['pass']);
    if (!gestionDatos::updatePass($usuario, $pass)) {
        $mensaje = 'No se ha podido cambiar la contraseña';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}
