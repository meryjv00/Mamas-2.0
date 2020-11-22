<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignatura
 *
 * @author isra9
 */
class Asignatura {

    private $id;
    private $nombre;
    private $imagen;
    private $examenes = array();
    private $preguntas = array();
    private $alumnos = array();

    function __construct($id, $nombre, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }

    //GET
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getExamenes() {
        return $this->examenes;
    }

    function getPreguntas() {
        return $this->preguntas;
    }

    function getAlumnos() {
        return $this->alumnos;
    }

// SET
    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

    function setExamenes($examenes): void {
        $this->examenes = $examenes;
    }

    function setPreguntas($preguntas): void {
        $this->preguntas = $preguntas;
    }

    function setAlumnos($alumnos): void {
        $this->alumnos = $alumnos;
    }

    function addExamen($examen) {
        $this->examenes[] = $examen;
    }

    function addPregunta($pregunta) {
        $this->preguntas[] = $pregunta;
    }

    function addAlumno($alumno) {
        $this->alumnos[] = $alumno;
    }

}
