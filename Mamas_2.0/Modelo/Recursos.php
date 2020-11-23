<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Examen.php';
include_once '../Modelo/Pregunta.php';
include_once '../Modelo/Respuesta.php';
include_once '../Modelo/Alumno.php';
include_once '../Modelo/Profesor.php';

function crearPregunta($id, $profesor, $enunciado, $tipo, $puntuacion) {
    $asignaturas = $_SESSION['asignaturas'];
    $p = new Pregunta($id, $profesor, $enunciado, $tipo, $puntuacion);
}

function crearPreguntaExamen($id, $profesor, $enunciado, $tipo, $puntuacion, $examen) {
    $asignaturas = $_SESSION['asignaturas'];
    $p = new Pregunta($id, $profesor, $enunciado, $tipo, $puntuacion);
}

function crearExamen($param) {
    
}

function verPregunta($param) {
    
}

function verExamen($param) {
    
}

function verExamenDetalle($param) {
    
}
