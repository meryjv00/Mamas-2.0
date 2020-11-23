<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pregunta
 *
 * @author isra9
 */
class Pregunta {

    private $id;
    private $profesor;
    private $enunciado;
    private $tipo;
    private $puntuacion;
    private $respuestas = array();

    function __construct($id, $profesor, $enunciado, $tipo, $puntuacion) {
        $this->id = $id;
        $this->profesor = $profesor;
        $this->enunciado = $enunciado;
        $this->tipo = $tipo;
        $this->puntuacion = $puntuacion;
    }

    function getId() {
        return $this->id;
    }

    function getProfesor() {
        return $this->profesor;
    }

    function getEnunciado() {
        return $this->enunciado;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getPuntuacion() {
        return $this->puntuacion;
    }

    function getRespuestas() {
        return $this->respuestas;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setProfesor($profesor): void {
        $this->profesor = $profesor;
    }

    function setEnunciado($enunciado): void {
        $this->enunciado = $enunciado;
    }

    function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    function setPuntuacion($puntuacion): void {
        $this->puntuacion = $puntuacion;
    }

    function setRespuestas($respuestas): void {
        $this->respuestas = $respuestas;
    }

    function addRespuesta($respuesta) {
        $this->respuestas[] = $respuesta;
    }

}
