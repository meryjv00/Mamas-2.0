<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
session_start();
//-----------------IR AL CRUD DE USUARIOS
if (isset($_REQUEST['CRUDadmin'])) {
    $usuarios = gestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
    header('Location: ../Vistas/crudAdmin.php');
}
//------------------IR A LA PÁGINA DE INICIO
if (isset($_REQUEST['home'])) {
    header('Location: ../Vistas/inicioProfesor.php');
}
if (isset($_REQUEST['homeInicio'])) {
    header('Location: ../Vistas/inicio.php');
}