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
include_once '../Modelo/Asignatura.php';

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
            $id = self::getUltId();
            $correcto = self::insertUsuarioAsignatura($id);
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function getUltId() {
        $consulta = "SELECT max(idUsuario) FROM usuarios";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['max(idUsuario)'];
            }
        }
        return $id;
    }

    static function insertUsuarioAsignatura($id) {
        $correcto = true;
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . ",1)";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . ",2)";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . ",3)";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . ",4)";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . ",5)";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        return $correcto;
    }

    static function insertProfesor($email, $dni, $nombre, $apellidos, $tfno, $pass, $idAsig) {
        self::conexion();
        $consulta = "INSERT INTO usuarios VALUES (default,'" . $email . "','" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $pass . "','" . $tfno . "',default,default)";
        if (self::$conexion->query($consulta)) {
            $id = self::getUltId();
            $correcto = self::insertProfesorAsignatura($id, $idAsig);
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function insertProfesorAsignatura($id, $idAsig) {
        $correcto = true;
        $consulta = "INSERT INTO asignacionasignatura VALUES(" . $id . "," . $idAsig . ")";
        if (!self::$conexion->query($consulta)) {
            $correcto = false;
        }
        return $correcto;
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

    static function checkRol($id) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT idRol from asignacionrol where idUsuario = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $idRol = $fila['idRol'];
            } else {
                $idRol = false;
            }
        }
        return $idRol;
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

    static function getAlumnosMatriculados($idA, $idR) {
        self::conexion();
        $alumnos = array();
        foreach ($idU as $value) {
            $stmt = self::$conexion->prepare("SELECT * FROM usuarios,asignacionasignatura,asignacionrol WHERE asignacionasignatura.idAsignatura= ? AND asignacionrol.idRol= ?");
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

    static function inicializarProfesor($idU) {
        $id = self::getIdAsignatura($idU);
        $asignaturas = array();
        $alumnos = array();
        for ($i = 0; $i < count($id); $i++) {
            $a = self::getAsignaturas($id[$i]);
            $examenes = self::getExamenes($id[$i]);
            $preguntas = self::getPreguntas($id[$i]);
            $alumnosMatriculados = self::getAlumnosMatriculados($id[$i], 0);
            foreach ($alumnosMatriculados as $value) {
                $alumnos[] = self::cargarUsuario($value);
            }
            $a->setExamenes($examenes);
            $a->setPreguntas($preguntas);
            $a->setAlumnos($alumnos);
            $asignaturas[] = $a;
        }
        return $asignaturas;
    }

    static function cargarAlumno($idUsuario) {
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
                $p = new Alumno($idUsuario, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
            mysqli_close(self::$conexion);
        }
    }

    static function insertPregunta($pregunta, $idasignatura) {
        self::conexion();
        $consulta = "INSERT INTO pregunta VALUES (" . $pregunta->getId() . "," . $idasignatura . ",'" . $pregunta->getProfesor() . "','" . $pregunta->getEnunciado() . "','" . $pregunta->getTipo() . "','" . $pregunta->getPuntuacion() . "')";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function asignarPregunta($pregunta, $examen) {
        self::conexion();
        $consulta = "INSERT INTO asignacionPregunta VALUES (" . $examen->getId() . "," . $pregunta->getId() . ")";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function insertExamen($examen, $idasignatura) {
        self::conexion();
        $consulta = "INSERT INTO examen VALUES (" . $pregunta->getId() . "," . $idasignatura . ",'" . $pregunta->getProfesor() . "','" . $pregunta->getContenido() . "','" . $pregunta->getDescripcion() . "','" . $pregunta->getActivo() . "')";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function insertarFotoAsignatura() {
        self::conexion();
        $fotoBin = self::$conexion->real_escape_string(file_get_contents($_FILES["imagen"]["tmp_name"]));
        $sentencia = "UPDATE asignatura SET imagen = ('$fotoBin') WHERE idAsignatura = 5";
        self::$conexion->query($sentencia);
        mysqli_close(self::$conexion);
    }

    static function getAsignaturas() {
        $asignaturas = Array();
        self::conexion();
        $consulta = "SELECT * FROM asignatura";

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $idAsignatura = $fila['idAsignatura'];
                $nombre = $fila['nombre'];
                $imagen = $fila['imagen'];
                $as = new Asignatura($idAsignatura, $nombre, $imagen);
                $asignaturas[] = $as;
            }
        }
        return $asignaturas;
        mysqli_close(self::$conexion);
    }

    static function getAsignaturasUsu2($id) {
        $asignaturas = Array();
        self::conexion();
        $consulta = "SELECT * FROM asignatura,asignacionasignatura WHERE asignatura.idAsignatura = asignacionasignatura.idAsignatura "
                . "and asignacionasignatura.idUsuario = " . $id;

        if ($resultado = self::$conexion->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {
                $idAsignatura = $fila['idAsignatura'];
                $nombre = $fila['nombre'];
                $imagen = $fila['imagen'];
                $as = new Asignatura($idAsignatura, $nombre, $imagen);
                $asignaturas[] = $as;
            }
        }
        return $asignaturas;
        mysqli_close(self::$conexion);
    }

    static function updateFoto($id) {
        self::conexion();
        $fotoBin = self::$conexion->real_escape_string(file_get_contents($_FILES["imagen"]["tmp_name"]));
        $sentencia = "UPDATE usuarios SET imagen = ('$fotoBin') WHERE idUsuario = " . $id;
        self::$conexion->query($sentencia);
        mysqli_close(self::$conexion);
    }

    static function getUsuarioId($id) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idUsuario =  ?");
        $stmt->bind_param("i", $id);
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

    static function updateTfno($usuario) {
        self::conexion();
        $consulta = "UPDATE usuarios SET telefono='" . $usuario->getTelefono() . "' WHERE idUsuario =" . $usuario->getId();
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function updatePass($usuario, $pass) {
        self::conexion();
        $consulta = "UPDATE usuarios SET contrasenia='" . $pass . "' WHERE idUsuario =" . $usuario->getId();
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
