<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profesor
 *
 * @author isra9
 */
include_once 'Usuario.php';

class Profesor extends Usuario {

    private $correcciones;

    public function __construct($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen) {
        $this->correcciones = array();
        parent::__construct($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
    }

    function getCorrecciones() {
        return $this->correcciones;
    }

    function setCorrecciones($correcciones): void {
        $this->correcciones = $correcciones;
    }

    function addCorreccion($correc) {
        $this->correcciones[] = $correc;
    }

}
