<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Respuesta
 *
 * @author isra9
 */
class Respuesta {

    private $id;
    private $creador;
    private $respuesta;
    private $correcta;

    function __construct($id, $creador, $respuesta, $correcta) {
        $this->id = $id;
        $this->creador = $creador;
        $this->respuesta = $respuesta;
        $this->correcta = $correcta;
    }

    function getId() {
        return $this->id;
    }

    function getCreador() {
        return $this->creador;
    }

    function getRespuesta() {
        return $this->respuesta;
    }

    function getCorrecta() {
        return $this->correcta;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setCreador($creador): void {
        $this->creador = $creador;
    }

    function setRespuesta($respuesta): void {
        $this->respuesta = $respuesta;
    }

    function setCorrecta($correcta): void {
        $this->correcta = $correcta;
    }


    
}
