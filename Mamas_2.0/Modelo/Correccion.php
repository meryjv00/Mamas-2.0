<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Correccion
 *
 * @author isra9
 */
class Correccion {

    private $profesor;
    private $notas;
    private $anotacion;

    function __construct($profesor) {
        $this->notas = array();
        $this->profesor = $profesor;
    }

    function getProfesor() {
        return $this->profesor;
    }

    function getNotas() {
        return $this->notas;
    }

    function getAnotacion() {
        return $this->anotacion;
    }

    function setProfesor($profesor): void {
        $this->profesor = $profesor;
    }

    function setNotas($notas): void {
        $this->notas = $notas;
    }

    function setAnotacion($anotacion): void {
        $this->anotacion = $anotacion;
    }

    function addNota($nota) {
        $this->notas[] = $nota;
    }

  
}
