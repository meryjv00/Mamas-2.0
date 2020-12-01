<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Examen
 *
 * @author isra9
 */
class Examen {

    private $id;
    private $profesor;
    private $contenido;
    private $descripcion;
    private $preguntas;
    private $activo;

    function __construct($id, $profesor, $contenido, $descripcion, $activo) {
        $this->id = $id;
        $this->profesor = $profesor;
        $this->contenido = $contenido;
        $this->descripcion = $descripcion;
        $this->activo = $activo;
        $this->preguntas = array();
    }

    //GET
    function getId() {
        return $this->id;
    }

    function getProfesor() {
        return $this->profesor;
    }

    function getContenido() {
        return $this->contenido;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPreguntas() {
        return $this->preguntas;
    }

    function getActivo() {
        return $this->activo;
    }

//SET
    function setId($id): void {
        $this->id = $id;
    }

    function setProfesor($profesor): void {
        $this->profesor = $profesor;
    }

    function setContenido($contenido): void {
        $this->contenido = $contenido;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setPreguntas($preguntas): void {
        $this->preguntas = $preguntas;
    }

    function setActivo($activo): void {
        $this->activo = $activo;
    }

    function addPregunta($pregunta) {
        $this->preguntas[] = $pregunta;
    }

}
