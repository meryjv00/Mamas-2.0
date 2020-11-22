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
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Examen.php';
include_once '../Modelo/Pregunta.php';
include_once '../Modelo/Respuesta.php';
include_once '../Modelo/Alumno.php';
include_once '../Modelo/Profesor.php';

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
                $imagen = $fila['imagen'];
                $p = new Usuario($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);

                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
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
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);
                $rol = $fila['idRol'];
            }
        }
        return $rol;
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
        $consulta = "INSERT INTO asignacionrol VALUES (" . $id . "," . $rol . ")";
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
        $consulta = "INSERT INTO usuarios VALUES (default,'" . $email . "','" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $pass . "','" . $tfno . "',default,default)";
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

                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $id = $fila['idUsuario'];
                $email = $fila['email'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];
                $imagen = $fila['imagen'];
                $p = new Usuario($id, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                $p->setRol(self::getRol($id));
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
        $consulta = "UPDATE asignacionrol SET idRol=" . $usuario->getRol() . " WHERE idUsuario =" . $usuario->getId();
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function getIdAsig($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionasignatura WHERE idUsuario= ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $id[] = $fila['idAsignatura'];
            }
            return $id;
        }
    }

    static function getIdAsignatura($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionasignatura WHERE idUsuario= ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $id[] = $fila['idAsignatura'];
            }
            return $id;
        }
    }

    static function getIdUsu($id) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM asignatura WHERE idAsignatura= ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['idUsuario'];
            }
            //almacenamos en sesion al usuario que ha realizado el Login.
        }
        return $id;
        mysqli_close(self::$conexion);
    }

    static function getExamenes($id) {
        self::conexion();
        $examenes = array();
        $stmt = self::$conexion->prepare("SELECT * FROM examen WHERE idAsignatura= ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idE = $fila['idExamen'];
                $profesor = $fila['idUsuario'];
                $contenido = $fila['contenido'];
                $descripcion = $fila['descripcion'];
                $activo = $fila['activo'];
                $e = new Examen($idE, $profesor, $contenido, $descripcion, $activo);
                $examenes[] = $e;
            }
            return $examenes;
        }

        mysqli_close(self::$conexion);
    }

    static function getPreguntas($id) {
        self::conexion();
        $preguntas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM pregunta WHERE idAsignatura= ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idP = $fila['idPregunta'];
                $profesor = $fila['idUsuario'];
                $enunciado = $fila['enunciado'];
                $tipo = $fila['tipo'];
                $puntuacion = $fila['ponderacion'];
                $p = new Pregunta($id, $profesor, $enunciado, $tipo, $puntuacion);
                $preguntas[] = $p;
            }
            return $preguntas;
        }
        mysqli_close(self::$conexion);
    }

    static function getUsuarioRol($rol) {
        self::conexion();
        $idAlumnos = array();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idRol= ?");
        $stmt->bind_param("i", $rol);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idAlumnos[] = $fila['idUsuario'];
            }
        }
        return $idAlumnos;
    }

    static function getAlumnosMatriculados($idA, $idU) {
        self::conexion();
        $alumnos = array();
        foreach ($idU as $value) {
            $stmt = self::$conexion->prepare("SELECT * FROM asignacionAsignatura WHERE idAsignatura= ? AND idUsuario= ?");
            $stmt->bind_param("ii", $idA, $value);
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                var_dump($resultado);
                if ($fila = $resultado->fetch_assoc()) {
                    $alumnos[] = $fila['idUsuario'];
                }
            }
        }
        return $alumnos;

        mysqli_close(self::$conexion);
    }

    static function cargarUsuario($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idUsuario= ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                var_dump($fila);
                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $email = $fila['email'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];
                $imagen = $fila['imagen'];
                $p = new Usuario($idUsuario, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
            mysqli_close(self::$conexion);
        }
    }

}
