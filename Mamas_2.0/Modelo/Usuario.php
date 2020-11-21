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
    private $id;
    private $email;
    private $dni;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $rol;
    private $activo;
    private $imagen;

    //-----------------------CONSTRUCTOR
    function __construct($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen) {
        $this->id = $id;
        $this->email = $email;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->activo = $activo;
        $this->imagen = $imagen;
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

    function getId() {
        return $this->id;
    }

    function getImagen() {
        return $this->imagen;
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

    function setId($id): void {
        $this->id = $id;
    }

    function setImagen($imagen): void {
        $this->imagen = $imagen;
    }

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
