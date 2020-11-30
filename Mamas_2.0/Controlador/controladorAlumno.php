<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Profesor.php';
include_once '../Modelo/Alumno.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Solucion.php';
include_once '../Modelo/Pregunta.php';
include_once '../Modelo/Asignatura.php';
include_once '../Modelo/Respuesta.php';
session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $asignaturas = $_SESSION['asignaturasImpartidas'];
    $examenesPendientes = $_SESSION['examenesPendientes'];
}
//-----------------HOME
if (isset($_REQUEST['home'])) {

    header('Location: ../Vistas/inicio.php');
}
//-----------------PERFIL
if (isset($_REQUEST['perfil'])) {

    header('Location: ../Vistas/perfil.php');
}
//-----------------CERRAR SESION
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    header('Location: ../index.php');
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

if (isset($_REQUEST['realizarExamen'])) {
    $idE = $_REQUEST['realizarExamen'];
    foreach ($examenesPendientes as $key => $examen) {
        if ($examen->getId() == $idE) {
            $examenS = $examen;
        }
    }
    $_SESSION['examenS'] = $examenS;
    header('Location: ../Vistas/realizarExamen.php');
}
if (isset($_REQUEST['entregarExamen'])) {
    $examenS = $_SESSION['examenS'];
    $idProf = $examenS->getProfesor();
    $preguntas = $examenS->getPreguntas();
    $solucion = new Solucion(0, $examenS->getId());
    $j = 1;
    foreach ($preguntas as $i => $pregunta) {
        if (isset($_REQUEST[$j])) {
            $r = $_REQUEST[$j];
            $j++;
            $idP = $pregunta->getId();
            $rep = new Respuesta(0, $usuario->getId(), $r, 0);
            gestionDatos::insertRespuestaAlumno($r, $usuario->getId(), $idP);
            $rep->setId(gestionDatos::getIdRespuesta() + 1);
            $solucion->addRespuesta($rep);
        } else {
            $r = "";
            $j++;
            $idP = $pregunta->getId();
            $rep = new Respuesta(0, $usuario->getId(), $r, 0);
            gestionDatos::insertRespuestaAlumno($r, $usuario->getId(), $idP);
            $rep->setId(gestionDatos::getIdRespuesta() + 1);
            $solucion->addRespuesta($rep);
        }
    }
    gestionDatos::insertSolucion($usuario->getId(), $examenS->getId());
    $solucion->setId(gestionDatos::getIdSolucion() + 1);
    foreach ($solucion->getRespuestas() as $respuesta) {
        gestionDatos::asignarRespuesta($solucion->getId(), $respuesta->getId());
    }
    $usuario->addSolucion($solucion);
    $_SESSION['usuario'] = $usuario;
    foreach ($examenesPendientes as $k => $examen) {
        if ($examen->getId() == $examenS->getId()) {
            unset($examenesPendientes[$k]);
        }
    }
    $_SESSION['examenesPendientes'] = $examenesPendientes;
    if (isset($_SESSION['examenesRealizados'])) {
        $realizados = $_SESSION['examenesRealizados'];
        $realizados[] = $examenS;
        $_SESSION['examenesRealizados'] = $realizados;
    }
    $mensaje = 'Examen Entregado,SUERTE!!';
    $_SESSION['mensaje'] = $mensaje;
    header('Location: ../Vistas/inicio.php');
}
if (isset($_REQUEST['salirAlumno'])) {
    header('Location: ../Vistas/inicioProfesor.php');
}
//---------------SIEMPRE AL FINAL----------
for ($i = 0; $i < count($asignaturas); $i++) {
    if (isset($_REQUEST[$i])) {
        $idAsignatura = $_REQUEST[$i];
        foreach ($asignaturas as $asignatura) {
            if ($asignatura->getIdAsignatura() == $idAsignatura) {
                $examenesPendientes = array();
                $examenesRealizados = array();
                $examenesCorregidos = array();
                $examenAsig = $asignatura->getExamenes();
                foreach ($examenAsig as $examen) {
                    if ($examen->getActivo() == 1) {
                        $examenesPendientes[] = $examen;
                    }
                }

                if ($usuario->getRol() == 0) {
                    $soluciones = $usuario->getSoluciones();
                    foreach ($examenesPendientes as $key => $examenP) {
                        foreach ($soluciones as $j => $solucion) {
                            if ($solucion->getExamen() == $examenP->getId()) {
                                if ($solucion->getCorreccion() != null) {
                                    $examenesCorregidos[] = $examenP;
                                } else {
                                    $examenesRealizados[] = $examenP;
                                    unset($examenesPendientes[$key]);
                                }
                            }
                        }
                    }
                }
                $_SESSION['examenesPendientesA'] = $examenesPendientes;
                $_SESSION['examenesRealizadosA'] = $examenesRealizados;
                $_SESSION['examenesCorregidosA'] = $examenesCorregidos;
                $_SESSION['profesorAsignaturaS'] = gestionDatos::getProfesor($idAsignatura);
                $_SESSION['asignaturaS'] = $asignatura;
                header('Location: ../Vistas/inicioAsignatura.php');
            }
        }
    }
}
