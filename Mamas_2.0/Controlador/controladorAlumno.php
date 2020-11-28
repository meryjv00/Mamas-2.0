<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Profesor.php';
        include_once '../Modelo/Alumno.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Pregunta.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Respuesta.php';
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
