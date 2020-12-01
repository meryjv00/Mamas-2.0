<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Solucion
 *
 * @author isra9
 */
class Solucion {

    private $id;
    private $examen;
    private $respuestas;
    private $correccion;

    function __construct($id, $examen) {
        $this->respuestas = array();
        $this->correccion = array();
        $this->id = $id;
        $this->examen = $examen;
    }

    function getId() {
        return $this->id;
    }

    function getExamen() {
        return $this->examen;
    }

    function getRespuestas() {
        return $this->respuestas;
    }

    function getCorreccion() {
        return $this->correccion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setExamen($examen): void {
        $this->examen = $examen;
    }

    function setRespuestas($respuestas): void {
        $this->respuestas = $respuestas;
    }

    function setCorreccion($correccion): void {
        $this->correccion = $correccion;
    }

    function addRespuesta($respuesta) {
        $this->respuestas[] = $respuesta;
    }

    function addCorreccion($correcc) {
        $this->correccion[] = $correcc;
    }

}
