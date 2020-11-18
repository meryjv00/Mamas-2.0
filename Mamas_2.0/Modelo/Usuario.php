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
    private $rol;
    private $activo;

    //-----------------------CONSTRUCTOR
    function __construct($email, $dni, $nombre, $apellidos, $telefono, $rol, $activo) {
        $this->email = $email;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->rol = $rol;
        $this->activo = $activo;
    }

    //-----------------------GETTERS
    function getRol() {
        return $this->rol;
    }

    function getActivo() {
        return $this->activo;
    }

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

    function setRol($rol): void {
        $this->rol = $rol;
    }

    function setActivo($activo): void {
        $this->activo = $activo;
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
