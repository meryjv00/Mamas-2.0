<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author isra9
 */
include_once 'Usuario.php';

class Alumno extends Usuario {

    private $soluciones;

    public function __construct($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen) {
        $soluciones = array();
        parent::__construct($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
    }

    function getSoluciones() {
        return $this->soluciones;
    }

    function setSoluciones($soluciones): void {
        $this->soluciones = $soluciones;
    }

    function addSolucion($solucion) {
        $this->soluciones[] = $solucion;
    }

}
