<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Pregunta.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Respuesta.php';
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $asignaturas = $_SESSION['asignaturasImpartidas'];
}
//-----------------IR AL CRUD DE USUARIOS
if (isset($_REQUEST['CRUDadmin'])) {
    $usuarios = gestionDatos::getUsuarios();
    $_SESSION['usuarios'] = $usuarios;
    header('Location: ../Vistas/crudAdmin.php');
}
//------------------IR A LA PÁGINA DE INICIO
if (isset($_REQUEST['home'])) {
    header('Location: ../Vistas/inicioProfesor.php');
}
if (isset($_REQUEST['homeInicio'])) {
    if ($_SESSION['origen'] = 'alumno') {
        header('Location: ../Vistas/inicio.php');
    } else {
        header('Location: ../Vistas/inicioProfesor.php');
    }
}

//-----------------CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    unset($_SESSION['usuario']);
    header('Location: ../index.php');
}

//-----------------VER PERFIL
if (isset($_REQUEST['perfil'])) {
    header('Location: ../Vistas/perfilP.php');
}

//-----------------EDITAR FOTO PERFIL
if (isset($_REQUEST['editarFotoPerfil'])) {
    gestionDatos::updateFoto($usuario->getId());
    //Obtiene el usuario con la foto actualizada y lo guarda en sesión  
    $_SESSION['usuario'] = gestionDatos::getUsuarioId($usuario->getId());
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR NUMERO TELEFONO
if (isset($_REQUEST['editarTfno'])) {
    $tfno = $_REQUEST['tfno'];
    $usuario->setTelefono($tfno);
    if (!gestionDatos::updateTfno($usuario)) {
        $mensaje = 'No se ha podido cambiar número de teléfono';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}

//-----------------EDITAR CONTRASEÑA
if (isset($_REQUEST['nuevaPass'])) {
    $pass = md5($_REQUEST['pass']);
    if (!gestionDatos::updatePass($usuario, $pass)) {
        $mensaje = 'No se ha podido cambiar la contraseña';
        $_SESSION['mensaje'] = $mensaje;
    }
    header('Location: ../Vistas/perfil.php');
}

//------------------VER EXAMENES
if (isset($_REQUEST['verExamenes'])) {

    header('Location: ../Vistas/crudExamenes.php');
}

//------------------CREAR EXAMENES
if (isset($_REQUEST['crearExamenes'])) {

    header('Location: ../Vistas/crearExamen.php');
}
if (isset($_REQUEST['crearExamen'])) {
    $idAsignatura = $_REQUEST['asignaturas'];
    $descripcion = $_REQUEST['descripcion'];
    $contenido = $_REQUEST['contenido'];
    $fechai = $_REQUEST['fechainicio'];
    $fechaf = $_REQUEST['fechafin'];
    $idP = $usuario->getId();

    $ex = new Examen(0, $idP, $contenido, $descripcion, 0);
    for ($i = 0; $i < count($asignaturas); $i++) {
        if ($asignaturas[$i]->getIdAsignatura() == $idAsignatura) {
            $asignaturas[$i]->addExamen($ex);
        }
    }
    $_SESSION['asignaturasImpartidas'] = $asignaturas;
    gestionDatos::insertExamen($ex, $idAsignatura);
    header('Location: ../Vistas/crudExamenes.php');
}
if (isset($_REQUEST['aniadirPreguntas'])) {
    if (isset($_SESSION['preguntasCreadas'])) {
        $preguntasEx = $_SESSION['preguntasCreadas'];
    } else {
        $preguntasEx = Array();
    }
    $datos = $_REQUEST['json'];
    $preguntas = json_decode($datos, false); // Array asociativo los datos van por referencia
    var_dump($preguntas);
    //echo $datosInicialesF[0]->datos[0]->id;
    for ($i = 0; $i < count($preguntas); $i++) {
        //INSERTAR PREGUNTA
        $profesor = $usuario->getId();
        $enunciado = $preguntas[$i]->enunciado;
        $tipo = $preguntas[$i]->tipo;
        $puntuacion = $preguntas[$i]->puntuacion;
        $asignatura = $preguntas[$i]->asignatura;

        $idAsig = gestionDatos::getIdAsignaturaN($asignatura);
        $numero = count($preguntas);
        $idPregunta = gestionDatos::getIdPregunta();
        $p = new Pregunta($idPregunta + 1, $profesor, $enunciado, $tipo, $puntuacion);
        foreach ($asignaturas as $q => $asignatura) {
            if ($idAsig == $asignatura->getIdAsignatura()) {
                $idPregunta = gestionDatos::insertPregunta($p, $idAsig);
                //INSERTAR OPCIONES O PALABRAS CLAVE
                $datos = $preguntas[$i]->datos;
                foreach ($datos as $j => $dato) {
                    if ($tipo == 0) {
                        $nombre = $dato->nombre;
                        $idRespuesta = gestionDatos::getIdRespuesta();
                        $respuesta = new Respuesta($idRespuesta + 1, $profesor, $nombre, 0);
                    } else {
                        $opcion = $dato->opcion;
                        if ($dato->correcto) {
                            $correcto = 1;
                        } else {
                            $correcto = 0;
                        }
                        $idRespuesta = gestionDatos::getIdRespuesta();
                        $respuesta = new Respuesta($idRespuesta + 1, $profesor, $opcion, $correcto);
                    }
                    $p->addRespuesta($respuesta);
                    gestionDatos::insertRespuesta($respuesta, $idPregunta);
                }
                $preguntasEx[] = $p;
                $asignatura->addPregunta($p);
            }
        }
        $_SESSION['asignaturasImpartidas'] = $asignaturas;
    }
    if (isset($_SESSION['vienesEx'])) {
        $_SESSION['preguntasCreadas'] = $preguntasEx;
        unset($_SESSION['vienesEx']);
        header('Location: ../Vistas/asignarPreguntas.php');
    } else {
        $_SESSION['mensaje'] = 'Preguntas creadas! Para ver todas tus preguntas accede a "Asignar preguntas"';
        header('Location: ../Vistas/crudExamenes.php');
    }
}
//--------CREAR PREGUNTAS
if (isset($_REQUEST['crearPreguntas'])) {
    header('Location: ../Vistas/crearPregunta.php');
}
if (isset($_REQUEST['crearPreguntasEx'])) {
    $_SESSION['vienesEx'] = true;
    header('Location: ../Vistas/crearPregunta.php');
}
if (isset($_REQUEST['verPreguntasCreadas'])) {
    header('Location: ../Vistas/verPreguntas.php');
}

if (isset($_REQUEST['verExamen'])) {
    $examenes = $asignaturas[0]->getExamenes();
    if (count($examenes) > 0) {
        $cont = 0;
        foreach ($examenes as $i => $examen) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $cont++;
                $pos = $i;
            }
        }
    }
    if (!$pulsado || $cont >= 2) {
        $_SESSION['mensaje'] = "Marca el checkbox del exámen a realizar acción";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $_SESSION['examenS'] = $examenes[$pos];
        header('Location: ../Vistas/verExamen.php');
    }
}

if (isset($_REQUEST['asignarPreguntas'])) {

    $examenes = $asignaturas[0]->getExamenes();
    if (count($examenes) > 0) {
        $cont = 0;
        foreach ($examenes as $i => $examen) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $cont++;
                $pos = $i;
            }
        }
    }
    if (!$pulsado || $cont >= 2) {
        $_SESSION['mensaje'] = "Marca el checkbox del exámen a realizar acción";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $_SESSION['examenS'] = $examenes[$pos];
        header('Location: ../Vistas/asignarPreguntas.php');
    }
}

//---------------------ASIGNAR PREGUNTAS A UN EXÁMEN
if (isset($_REQUEST['aniadirPreguntasExamen'])) {
    $preguntasCreadas = $_SESSION['preguntasCreadas'];
    $examenS = $_SESSION['examenS'];

    $asignatura = $_SESSION['asignaturasImpartidas'];
    $examenes = $asignatura[0]->getExamenes();
    foreach ($examenes as $j => $examen) {
        if ($examen->getId() == $examenS->getId()) {
            
            foreach ($preguntasCreadas as $i => $pregunta) {
                gestionDatos::asignarPregunta($preguntasCreadas[$i], $examenS);
                //Add pregunta al exámen
                $examen->addPregunta($pregunta);
            }
        }
    }
    $asignatura[0]->setExamenes($examenes);
    $_SESSION['asignaturasImpartidas'] = $asignatura;
    unset($_SESSION['preguntasCreadas']);
    header('Location: ../Vistas/crudExamenes.php');
}
