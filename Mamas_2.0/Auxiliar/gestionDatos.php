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
include_once '../Modelo/Usuario.php';
session_start();

class gestionDatos {

    //-----------------------------------BASICOS
    static private $conexion;

    static function conexion() {
        //self::$conexion = mysqli_connect('localhost', 'maria', 'Chubaca2020', 'desafio2');
        self::$conexion = mysqli_connect('localhost', 'usuario', 'Chubaca2020', 'desafio2');
        //self::$conexion = mysqli_connect('localhost', 'Maria', 'Chubaca2020', 'desafio2');
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
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ? AND contrasenia= ?");
        $stmt->bind_param("ss", $mail, $password);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $id = $fila['idUsuario'];
                $email = $fila['email'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];
                $rol = $fila['imagen'];
                $p = new Usuario($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                return $p;
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            mysqli_close(self::$conexion);
        }
    }

    static function getRol($id) {
        self::conexion();
        $rol = -1;
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionrol WHERE idUsuario= ? ");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $rol = $fila['idRol'];
            }
            return $rol;
        }
    }

    static function isUsuario($email) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ?");
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

    static function isDni($dni) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE dni= ?");
        $stmt->bind_param("s", $dni);
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

    static function getIdUsuario($email) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['idUsuario'];
            } else {
                echo "Error al encontrar usuario: " . self::$conexion->error . '<br/>';
            }
            return $id;
            mysqli_close(self::$conexion);
        }
    }

    static function insertUsuarioRol($id, $rol) {
        self::conexion();
        $consulta = "INSERT INTO asignacionrol VALUES ('" . $id . "','" . $rol . "')";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass) {
        self::conexion();
        $consulta = "INSERT INTO usuarios VALUES ('','" . $email . "','" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $pass . "','" . $tfno . "',NULL,0)";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
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

    static function getUsuarios() {
        self::conexion();
        $usuarios = Array();
        $consulta = "SELECT * FROM usuarios";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $id = $fila['idUsuario'];
                $email = $fila['email'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];
                $imagen = $fila['imagen'];
                $rol = self::getRol($id);
                $p = new Usuario($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                $p->setRol($rol);
                $usuarios[] = $p;
            }
        }
        return $usuarios;
        mysqli_close(self::$conexion);
    }

    static function updateUsuario($usuario) {
        self::conexion();
        $consulta = "UPDATE usuarios SET nombre='" . $usuario->getNombre() . "', telefono = '" . $usuario->getTelefono() . "', apellidos = '" .
                $usuario->getApellidos() . "' WHERE email ='" . $usuario->getEmail() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function deleteUsuario($usuario) {
        self::conexion();
        $consulta = "DELETE FROM usuarios WHERE email ='" . $usuario->getEmail() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al borrar usuario: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function updateActivo($usuario) {
        self::conexion();
        $consulta = "UPDATE usuarios SET activo=" . $usuario->getActivo() . " WHERE email ='" . $usuario->getEmail() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function updateRol($usuario) {
        self::conexion();
        $consulta = "UPDATE usuarios SET rol=" . $usuario->getRol() . " WHERE email ='" . $usuario->getEmail() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

}
