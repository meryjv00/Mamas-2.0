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
        //self::$conexion = mysqli_connect('localhost', 'usuario', 'Chubaca2020', 'desafio2');
        self::$conexion = mysqli_connect('localhost', 'Maria', 'Chubaca2020', 'desafio2');
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
    static function getUsuario($mail, $password) {

        self::conexion();
        $activo = -1; // valor -1 para control de error en caso de consulta fallida. 
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE mail= ? AND contrasenia= ?");
        $stmt->bind_param("ss", $mail, $password);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $email = $fila['mail'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];

                $p = new Usuario($email, $dni, $nombre, $apellidos, $telefono);
                $_SESSION['usuario'] = $p;
                //almacenamos en sesion al usuario que ha realizado el Login.
                return $activo; // devuelve  0 o 1 para ver en controlador si el usuario esta activado.
            } else {
                return $activo; //Devuelve -1 porque la consulta en BD fallo o la contraseña es erronea.
            }
            mysqli_close(self::$conexion);
        }
    }

    static function getRol($email) {
        self::conexion();
        $rol = -1; // Asignamos -1 por defecto para controlar el error en obtencion de rol.
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionrol WHERE mail= ?");
        $stmt->bind_param("s", $email); //EVITAMOS INYECCION SQL
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                $rol = $fila['idRol'];
                return $rol;
            }
        } else {
            print "Fallo al obtener ROL en MySQL: " . mysqli_connect_error();
            return $rol; // Devuelve -1 para controlar el error fuera de  la funcion.
        }
        mysqli_close(self::$conexion);
    }

    static function isUsuario($email) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE mail= ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {

                $existe = true;
            } else {
                echo "Error al encontrar usuario: " . self::$conexion->error . '<br/>';
                $existe = false;
            }
            return $existe;
            mysqli_close(self::$conexion);
        }
    }

    static function insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass) {
        self::conexion();
        $consulta = "INSERT INTO usuarios VALUES ('" . $email . "','" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $pass . "','" . $tfno . "',0)";
        if (self::$conexion->query($consulta)) {
            $consulta = "INSERT INTO asignacionrol VALUES ('" . $email . "',0)";
            if (self::$conexion->query($consulta)) {
                $correcto = true;
            }
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function setPassword($email, $pass) {
        self::conexion();
        $consulta = "UPDATE usuarios SET contrasenia ='" . $pass . "' WHERE mail='" . $email . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al establecer contraseña: " . self::$conexion->error . '<br/>';
        }
        return correcto;
        mysqli_close(self::$conexion);
    }

}
