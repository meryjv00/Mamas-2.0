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
include_once '../Auxiliar/constantes.php';
include_once '../Modelo/Solucion.php';
include_once '../Modelo/Correccion.php';

class gestionDatos {

    static private $conexion;

    static function conexion() {
        //self::$conexion = mysqli_connect('localhost', 'maria', 'Chubaca2020', 'desafio2');
        self::$conexion = mysqli_connect('localhost', constantes::$usuarioBD, constantes::$passBD, constantes::$bd);
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

//======================================================================
// CONSULTAS
//======================================================================

    static function getUsuario($mail, $password) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ? AND contrasenia= ?");
        $stmt->bind_param("ss", $mail, $password);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);
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
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
            mysqli_close(self::$conexion);
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

    static function inicializarAlumno($idAl) {
        $asignaturas = array();
        $examenes = array();
        $preguntas = array();
        $asignaturas = self::getAsignaturasUsu2($idAl);
        for ($i = 0; $i < count($asignaturas); $i++) {
            $examenes = self::getExamenesActivos($asignaturas[$i]->getIdAsignatura());
            $asignaturas[$i]->setExamenes($examenes);
        }
        return $asignaturas;
    }

    static function inicializarProfesor($idP) {
        $asignaturas = array();
        $alumnos = array();
        $examenes = array();
        $preguntas = array();
        $asignaturas = self::getAsignaturasUsu2($idP);
        for ($i = 0; $i < count($asignaturas); $i++) {
            $examenes = self::getExamenes($asignaturas[$i]->getIdAsignatura());
            $preguntas = self::getPreguntas($asignaturas[$i]->getIdAsignatura());
            $alumnosMatriculados = self::getAlumnosAsignaturas($asignaturas[$i]->getIdAsignatura(), 0);
            $asignaturas[$i]->setExamenes($examenes);
            $asignaturas[$i]->setPreguntas($preguntas);
            $asignaturas[$i]->setAlumnos($alumnosMatriculados);
        }
        return $asignaturas;
    }

    static function cargarAlumno($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idUsuario= ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);
                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $email = $fila['email'];
                $nombre = $fila['nombre'];
                $dni = $fila['dni'];
                $apellidos = $fila['apellidos'];
                $telefono = $fila['telefono'];
                $activo = $fila['activo'];
                $imagen = $fila['imagen'];
                $p = new Alumno($idUsuario, $email, $dni, $nombre, $apellidos, $telefono, $activo, $imagen);
                $p->setRol(0);
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
            mysqli_close(self::$conexion);
        }
    }

//======================================================================
// GET
//======================================================================
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

    static function getIdAsignaturaN($nombre) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM asignatura WHERE nombre= ? ");
        $stmt->bind_param("s", $nombre);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);
                $id = $fila['idAsignatura'];
            }
        }
        return $id;
        mysqli_close(self::$conexion);
    }

    static function getSoluciones($idAl) {
        self::conexion();
        $soluciones = array();
        $respuestas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM solucion WHERE idUsuario= ? ");
        $stmt->bind_param("i", $idAl);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);
                $idSol = $fila['idSolucion'];
                $idEx = $fila['idExamen'];
                $solucion = new Solucion($idSol, $idEx);

                $correcion = self::getCorreccion($idSol);
                if ($correcion != 1) {
                    $correcion->setNotas(self::getNotas($idSol));
                    $correcion->setAnotacion(self::getAnotaciones($idSol));
                    $solucion->setCorreccion($correccion);
                }
                $respuestas = self::getRespuestas($idAl);

                $solucion->setRespuestas($respuestas);


                $soluciones[] = $solucion;
            }
        }
        return $soluciones;
        mysqli_close(self::$conexion);
    }

    static function getRespuestas($idAl) {
        self::conexion();
        $respuestas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM respuesta WHERE idUsuario= ? ");
        $stmt->bind_param("i", $idAl);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idR = $fila['idRespuesta'];
                $correcta = $fila['correcto'];
                $respuesta = $fila['respuesta'];
                $r = new Respuesta($idR, $idAl, $respuesta, $correcta);
                $respuestas[] = $r;
            }
        }
        return $respuestas;
        mysqli_close(self::$conexion);
    }

    static function getNotas($idSol) {
        self::conexion();
        $notas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM correcion WHERE idSolucion= ? ");
        $stmt->bind_param("i", $idSol);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $nota = $fila['nota'];
                $notas[] = $nota;
            }
        }
        return $notas;
        mysqli_close(self::$conexion);
    }

    static function getAnotaciones($idSol) {
        self::conexion();
        $anotaciones = array();
        $stmt = self::$conexion->prepare("SELECT * FROM correcion WHERE idSolucion= ? ");
        $stmt->bind_param("i", $idSol);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $anotacion = $fila['anotacion'];
                $anotaciones[] = $anotacion;
            }
        }
        return $anotaciones;
        mysqli_close(self::$conexion);
    }

    static function getCorreccion($idSol) {
        self::conexion();
        $corr = 1;
        $stmt = self::$conexion->prepare("SELECT * FROM correccion WHERE idSolucion= ? ");
        $stmt->bind_param("i", $idSol);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $profesor = $fila['idUsuario'];
                $corr = new Correccion($profesor);
            }
        }
        var_dump($corr);
        return $corr;
        mysqli_close(self::$conexion);
    }

    static function crearTipo($usuario) {
        self::conexion();
        $id = $usuario->getId();
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionrol WHERE idUsuario= ? ");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                //var_dump($fila);

                $rol = $fila['idRol'];
                if ($rol == 0) {
                    $alumno = new Alumno($usuario->getId(), $usuario->getEmail(), $usuario->getDni(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTelefono(), $usuario->getActivo(), $usuario->getImagen());
                    $alumno->setRol(0);
                    $soluciones = array();
                    $soluciones = self::getSoluciones($alumno->getId());
                    $alumno->setSoluciones($soluciones);
                    $user = $alumno;
                } else {
                    $profesor = new Profesor($usuario->getId(), $usuario->getEmail(), $usuario->getDni(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTelefono(), $usuario->getActivo(), $usuario->getImagen());
                    $profesor->setRol($rol);
                    $user = $profesor;
                }
            }
        }
        return $user;
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

    static function getIdUsuario($email) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE email= ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['idUsuario'];
            } else {
                echo "Error al encontrar usuario: " . self::$conexion->error . '<br/>';
            }
            return $id;
            mysqli_close(self::$conexion);
        }
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
    
    static function getUltEx() {
        self::conexion();
        $consulta = "SELECT max(idExamen) FROM examen";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['max(idExamen)'];
            }
        }
        return $id;
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

    static function checkRol($id) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT idRol from asignacionrol where idUsuario = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                $idRol = $fila['idRol'];
            } else {
                $idRol = false;
            }
        }
        return $idRol;
        mysqli_close(self::$conexion);
    }

    static function getIdAsignatura($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionasignatura WHERE idUsuario= ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $id[] = $fila['idAsignatura'];
            }
            return $id;
        }
    }

    static function cargarExamenes($idUsuario) {
        self::conexion();
        $examenes = array();
        $stmt = self::$conexion->prepare("SELECT * FROM examen WHERE idUsuario= ? AND idAsignatura= ?");
        $stmt->bind_param("ii", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idE = $fila['idExamen'];
                $contenido = $fila['contenido'];
                $descripcion = $fila['descripcion'];
                $activo = $fila['activo'];
                $e = new Examen($idE, $idUsuario, $contenido, $descripcion, $activo);
                $examenes[] = $e;
            }
            return $examenes;
        }

        mysqli_close(self::$conexion);
    }

    static function getExamenesActivos($idAs) {
        self::conexion();
        $examenes = array();
        $stmt = self::$conexion->prepare("SELECT * FROM examen WHERE idAsignatura= ? AND activo= 1");
        $stmt->bind_param("i", $idAs);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idE = $fila['idExamen'];
                $profesor = $fila['idUsuario'];
                $contenido = $fila['contenido'];
                $descripcion = $fila['descripcion'];
                $activo = $fila['activo'];
                $e = new Examen($idE, $profesor, $contenido, $descripcion, $activo);
                $preguntas = self::getPreguntasExamen($idE);
                $e->setPreguntas($preguntas);
                $examenes[] = $e;
            }
            return $examenes;
        }

        mysqli_close(self::$conexion);
    }

    static function getExamenes($id) {
        self::conexion();
        $examenes = array();
        $stmt = self::$conexion->prepare("SELECT * FROM examen WHERE idAsignatura= ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idE = $fila['idExamen'];
                $profesor = $fila['idUsuario'];
                $contenido = $fila['contenido'];
                $descripcion = $fila['descripcion'];
                $activo = $fila['activo'];
                $e = new Examen($idE, $profesor, $contenido, $descripcion, $activo);
                $preguntas = self::getPreguntasExamen($idE);
                $e->setPreguntas($preguntas);
                $examenes[] = $e;
            }
            return $examenes;
        }

        mysqli_close(self::$conexion);
    }

    static function getPreguntasExamen($idE) {
        $preguntas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM asignacionpregunta,pregunta where pregunta.idPregunta = asignacionpregunta.idPregunta "
                . "and asignacionpregunta.idExamen = ?");
        $stmt->bind_param("i", $idE);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idP = $fila['idPregunta'];
                $profesor = $fila['idUsuario'];
                $enunciado = $fila['enunciado'];
                $tipo = $fila['tipo'];
                $ponderacion = $fila['ponderacion'];
                $p = new Pregunta($idP, $profesor, $enunciado, $tipo, $ponderacion);
                $respuestas = self::getRespuestasPregunta($idP, $profesor);
                $p->setRespuestas($respuestas);
                $preguntas[] = $p;
            }
            return $preguntas;
        }
    }

    static function getPreguntas($idAsignatura) {
        self::conexion();
        $preguntas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM pregunta WHERE idAsignatura= ?");
        $stmt->bind_param("i", $idAsignatura);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idP = $fila['idPregunta'];
                $profesor = $fila['idUsuario'];
                $enunciado = $fila['enunciado'];
                $tipo = $fila['tipo'];
                $puntuacion = $fila['ponderacion'];
                $p = new Pregunta($idP, $profesor, $enunciado, $tipo, $puntuacion);
                $respuestas = self::getRespuestasPregunta($idP, $profesor);
                $p->setRespuestas($respuestas);
                $preguntas[] = $p;
            }
            return $preguntas;
        }
        mysqli_close(self::$conexion);
    }

    static function getRespuestasPregunta($idP, $idProf) {
        $respuestas = array();
        $stmt = self::$conexion->prepare("SELECT * FROM respuesta where idPregunta = ? AND idUsuario= ?");
        $stmt->bind_param("ii", $idP, $idProf);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idR = $fila['idRespuesta'];
                $profesor = $fila['idUsuario'];
                $oppal = $fila['respuesta'];
                $correcta = $fila['correcto'];
                $respuesta = new Respuesta($idR, $profesor, $oppal, $correcta);
                $respuestas[] = $respuesta;
            }
            return $respuestas;
        }
    }

    static function getUsuarioRol($rol) {
        self::conexion();
        $idAlumnos = array();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idRol= ?");
        $stmt->bind_param("i", $rol);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $idAlumnos[] = $fila['idUsuario'];
            }
        }
        return $idAlumnos;
    }

    static function getAlumnosAsignaturas($idA, $idR) {
        self::conexion();
        $alumnos = array();
        $stmt = self::$conexion->prepare("SELECT idUsuario from asignacionasignatura where idAsignatura = ? and idUsuario in (SELECT asignacionrol.idUsuario FROM usuarios,asignacionrol where usuarios.idUsuario = asignacionrol.idUsuario and asignacionrol.idRol = ?)");
        $stmt->bind_param("ii", $idA, $idR);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            while ($fila = $resultado->fetch_assoc()) {
                $alumno = self::cargarAlumno($fila['idUsuario']);
                $alumnos[] = $alumno;
            }
        }
        return $alumnos;
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

    static function getUsuarioNombre($idUsuario) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idUsuario =  ?");
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            if ($fila = $resultado->fetch_assoc()) {

                //obtenemos los datos  en variables individuales para la creacion del objeto usuario.
                $nombre = $fila['nombre'];
            }
            return $nombre;
            mysqli_close(self::$conexion);
        }
    }

    static function getUsuarioId($id) {
        self::conexion();
        $stmt = self::$conexion->prepare("SELECT * FROM usuarios WHERE idUsuario =  ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            //var_dump($resultado);
            if ($fila = $resultado->fetch_assoc()) {
                // var_dump($fila);
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
                $p->setRol(gestionDatos::getRol($id));
                //almacenamos en sesion al usuario que ha realizado el Login.
            }
            return $p;
            mysqli_close(self::$conexion);
        }
    }

//======================================================================
// DELETE
//======================================================================

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

    static function deleteAsignacionPreguntaExamen($idEx, $idP) {
        self::conexion();
        $consulta = "DELETE FROM asignacionpregunta WHERE idExamen =" . $idEx . " and idPregunta =" . $idP;
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al borrar la asignacion: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }
        static function deleteExamen($examen) {
        self::conexion();
        $consulta = "DELETE FROM examen WHERE idExamen =" . $examen->getId();
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al borrar la asignacion: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

//======================================================================
// UPDATE
//======================================================================

    static function updateExamenEstado($examen, $activo) {
        self::conexion();
        $consulta = "UPDATE examen SET activo=" . $activo . " WHERE idExamen ='" . $examen->getId() . "'";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al actualizar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function updateFoto($id) {
        self::conexion();
        $fotoBin = self::$conexion->real_escape_string(file_get_contents($_FILES["imagen"]["tmp_name"]));
        $sentencia = "UPDATE usuarios SET imagen = ('$fotoBin') WHERE idUsuario = " . $id;
        self::$conexion->query($sentencia);
        mysqli_close(self::$conexion);
    }

    static function updateTfno($usuario) {
        self::conexion();
        $sentencia = "UPDATE usuarios SET telefono = '". $usuario->getTelefono() ."' WHERE idUsuario = " . $usuario->getId();
        self::$conexion->query($sentencia);
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

//======================================================================
// INSERT
//======================================================================

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

    static function insertPregunta($pregunta, $idasignatura) {
        self::conexion();
        $consulta = "INSERT INTO pregunta VALUES (" . $pregunta->getId() . "," . $idasignatura . ",'" . $pregunta->getProfesor() . "','" . $pregunta->getEnunciado() . "','" . $pregunta->getTipo() . "','" . $pregunta->getPuntuacion() . "')";
        if (self::$conexion->query($consulta)) {
            $idPregunta = self::getIdPregunta();
        }
        return $idPregunta;
        mysqli_close(self::$conexion);
    }

    static function insertRespuesta($respuesta, $idUsuario, $idPregunta) {
        self::conexion();
        $consulta = "INSERT INTO respuesta VALUES ('','" . $idUsuario . "'," . $idPregunta . ",'" . $respuesta . "',0)";
        if (self::$conexion->query($consulta)) {
            $correcto = false;
        }
        mysqli_close(self::$conexion);
    }

    static function getIdPregunta() {
        self::conexion();
        $consulta = "SELECT max(idPregunta) FROM pregunta";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['max(idPregunta)'];
            }
        }
        return $id;
        mysqli_close(self::$conexion);
    }

    static function getIdSolucion() {
        self::conexion();
        $consulta = "SELECT max(idSolucion) FROM solucion";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['max(idSolucion)'];
            }
        }
        return $id;
        mysqli_close(self::$conexion);
    }

    static function asignarRespuesta($solId, $respId) {
        self::conexion();
        $consulta = "INSERT INTO asignacionrespuesta VALUES (" . $solId . "," . $respId . ")";
        if (self::$conexion->query($consulta)) {
            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function insertSolucion($usuarioId, $examenId) {
        self::conexion();
        $consulta = "INSERT INTO solucion VALUES (''," . $usuarioId . "," . $examenId . ")";
        if (self::$conexion->query($consulta)) {

            $correcto = true;
        } else {
            $correcto = false;
            echo "Error al insertar: " . self::$conexion->error . '<br/>';
        }
        return $correcto;
        mysqli_close(self::$conexion);
    }

    static function getIdRespuesta() {
        self::conexion();
        $consulta = "SELECT max(idRespuesta) FROM respuesta";
        if ($resultado = self::$conexion->query($consulta)) {
            if ($fila = $resultado->fetch_assoc()) {
                $id = $fila['max(idRespuesta)'];
            }
        }
        return $id;
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
        $consulta = "INSERT INTO examen VALUES (" . $examen->getId() . "," . $idasignatura . ",'" . $examen->getProfesor() . "','" . $examen->getContenido() . "','" . $examen->getDescripcion() . "','" . $examen->getActivo() . "')";
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

}
