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
    $password = md5($_REQUEST['password']);
    gestionDatos::getUsuario($email, $password);

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
                header('Location: ../Vistas/inicio.php');
            } else if ($usuario->getRol() == 1) {
                header('Location: ../Vistas/crudProfesor.php');
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
    $pass = md5($_REQUEST['pass']);
    if (!gestionDatos::isUsuario($email)) {
        if (!gestionDatos::insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass)) {
            $mensaje = "No se ha podido insertar el usuario";
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/registro.php');
        } else {
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