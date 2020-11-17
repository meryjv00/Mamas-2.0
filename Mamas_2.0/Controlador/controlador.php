<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
session_start();
//---------------LOGIN
if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $activo = gestionDatos::getUsuario($email, $password);
    if ($activo == -1) {
        $mensaje = 'Error al realizar el Login.';
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/login.php');
    } else if ($activo == 0) {
        $mensaje = 'Usuario desactivado , contacte con administrador';
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/login.php');
    } else if ($activo == 1) {
        $usuarioActivo = $_SESSION['usuario'];
        $rol = gestionDatos::getRol($email);
        if ($rol == -1) {
            $mensaje = 'Error al realizar el Login/Rol.'; //Pongo temporalmente /Rol para saber si salta un error en esta parte
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/login.php');
        } else {
            $usuarioActivo->setRol($rol);
            if ($rol == 0) {
                header('Location: ../Vistas/inicio.php');
            } else if ($rol == 1) {
                header('Location: ../Vistas/crudAdmin.php');
            }
        }
    }
}

//---------------REGISTRO
if (isset($_REQUEST['registro'])) {
    $email = $_REQUEST['email'];
    $dni = $_REQUEST['dni'];
    $nombre = $_REQUEST['nombre'];
    $apellidos = $_REQUEST['apellidos'];
    $tfno = $_REQUEST['tfno'];
    $pass = $_REQUEST['pass'];
    if (!gestionDatos::isUsuario($email)) {
        if (!gestionDatos::insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass)) {
            $mensaje = "No se ha podido insertar el usuario";
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/registro.php');
        }else{
            $mensaje = "¡Cuenta creada!";
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/login.php');
        }
    } else {
        $mensaje = "El email introducido ya existe";
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/registro.php');
    }

    
}