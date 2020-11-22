<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
session_start();
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
            $id = $usuario->getId();
            $rol = gestionDatos::getRol($id);
            $usuario->setRol($rol);
            $_SESSION['usuario'] = $usuario;
            if (!isset($_SESSION['usuario'])) {
                $mensaje = 'Error al realizar el Login.';
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../Vistas/login.php');
            } else {
                $usuario = $_SESSION['usuario'];
                if ($usuario->getActivo() == 0) {
                    $mensaje = 'Usuario desactivado , contacte con administrador';
                    $_SESSION['mensaje'] = $mensaje;
                    header('Location: ../Vistas/login.php');
                } else if ($usuario->getActivo() == 1) {
                    if ($usuario->getRol() == 2) {
                        header('Location: ../Vistas/elegirAdmin.php');
                    } else if ($usuario->getRol() == 0) {
                        //Obtiene las asignaturas que está matriculado
                        $asignaturas = gestionDatos::getAsignaturasUsu2($id);
                        $_SESSION['asignaturas'] = $asignaturas;
                        //Se obtienen todas las asignaturas para mostrarlas al inicio
                        $todasAsignaturas = gestionDatos::getAsignaturas();
                        $_SESSION['todasAsignaturas'] = $todasAsignaturas;
                        header('Location: ../Vistas/inicio.php');
                    } else if ($usuario->getRol() == 1) {
                        //Obtiene las asignaturas que imparte
                        $asignaturas = gestionDatos::getAsignaturasUsu2($id);
                        $_SESSION['asignaturas'] = $asignaturas;
                        //Se obtienen todas las asignaturas para mostrarlas al inicio
                        $todasAsignaturas = gestionDatos::getAsignaturas();
                        $_SESSION['todasAsignaturas'] = $todasAsignaturas;
                        header('Location: ../Vistas/inicioProfesor.php');
                    }
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

//-----------------IR AL CRUD DE USUARIOS
if (isset($_REQUEST['CRUDadmin'])) {
    $usuarios = gestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
    header('Location: ../Vistas/crudAdmin.php');
}
//-----------------IR A LA PÁGINA PRINCIPAL PROFESORADO
if (isset($_REQUEST['CRUDprofesor'])) {
    header('Location: ../Vistas/inicioProfesor.php');
}
if (isset($_REQUEST['home'])) {
    header('Location: ../Vistas/inicio.php');
}
//-----------------VER PERFIL
if (isset($_REQUEST['perfil'])) {
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR FOTO PERFIL
if (isset($_REQUEST['editarFotoPerfil'])) {
    $usu = $_SESSION['usuario'];
    gestionDatos::updateFoto($usu->getId());
    //Obtiene el usuario con la foto actualizada y lo guarda en sesión
    $usuario = gestionDatos::getUsuarioId($usu->getId());
    $_SESSION['usuario'] = $usuario;
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR NUMERO TELEFONO
if (isset($_REQUEST['editarTfno'])) {
    $usu = $_SESSION['usuario'];
    $tfno = $_REQUEST['tfno'];
    $usu->setTelefono($tfno);
    if (!gestionDatos::updateTfno($usu)) {
        $mensaje = 'No se ha podido cambiar número de teléfono';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR CONTRASEÑA
if (isset($_REQUEST['nuevaPass'])) {
    $usu = $_SESSION['usuario'];
    $pass = md5($_REQUEST['pass']);
    if (!gestionDatos::updatePass($usu, $pass)) {
        $mensaje = 'No se ha podido cambiar la contraseña';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}