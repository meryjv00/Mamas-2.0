<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignatura
 *
 * @author Mery
 */
class Asignatura {
    private $idAsignatura;
    private $nombre;
    private $imagen;
    
    function __construct($idAsignatura, $nombre, $imagen) {
        $this->idAsignatura = $idAsignatura;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }
    
    function getIdAsignatura() {
        return $this->idAsignatura;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setIdAsignatura($idAsignatura): void {
        $this->idAsignatura = $idAsignatura;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setImagen($imagen): void {
        $this->imagen = $imagen;
    }



}
