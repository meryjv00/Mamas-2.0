<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestionDatos
 *
 * @author isra9
 */
include_once '../Modelo/usuario.php';

class gestionDatos {

    //-----------------------------------BASICOS
    static private $conexion;

    static function conexion() {
        self::$conexion = mysqli_connect('localhost', 'usuario', 'Chubaca2020', 'desafio2');
        print "Conexión realizada de forma procedimental: " . mysqli_get_server_info(self::$conexion) . "<br/>";
        if (mysqli_connect_errno(self::$conexion)) {
            print "Fallo al conectar a MySQL: " . mysqli_connect_error();
            die();
        }
    }

    static function cerrarBD() {
        mysqli_close(self::$conexion);
    }

    //------------------------------------Consultas
    static function getUsuario($usuario, $password) {
        session_start();
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ? AND password= ?");
        $stmt->bind_param("ss", $usuario, $password);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                $user = $fila['email'];
                $nombre = $fila['nombre'];
                $rol = $fila['rol'];
                $p = new Usuario($user, $nombre, $rol);
                $_SESSION['usuario'] = $p;
                return true;
            }
        } else {
            return false;
        }
        mysqli_close(self::$conexion);
    }

}
