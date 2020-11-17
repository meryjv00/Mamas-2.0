<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author isra9
 */
class Usuario {

    //-----------------------ATRIBUTOS
    private $email;
    private $dni;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $activo;
    private $roles;

    //-----------------------CONSTRUCTOR
    function __construct($email, $dni, $nombre, $apellidos, $telefono, $activo) {
        $this->email = $email;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->activo = $activo;
        $this->roles = Array();
    }

    //-----------------------GETTERS
    function getEmail() {
        return $this->email;
    }

    function getDni() {
        return $this->dni;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getActivo() {
        return $this->activo;
    }

    //------------------------SETTERS
    function setEmail($email): void {
        $this->email = $email;
    }

    function setDni($dni): void {
        $this->dni = $dni;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos): void {
        $this->apellidos = $apellidos;
    }

    function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    function setActivo($activo): void {
        $this->activo = $activo;
    }

    //----------------------------ROLES
    function setRol($rol) {
        $this->roles[] = $rol;
    }

    function getRol($i) {
        return $this->roles[$i];
    }

    function sizeRol() {
        return count($this->roles);
    }

    //---------------------------TO STRING
    public function __toString() {
        echo(
        ' Email: ' . $this->email .
        ' Nombre: ' . $this->nombre .
        ' Apellidos: ' . $this->apellidos .
        ' Dni: ' . $this->dni .
        ' Telefono: ' . $this->telefono
        );
    }

}
