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
    $preguntas = $examenS->getPreguntas();
    $solucion = new Solucion(0, $examenS->getId());
    for ($i = 0; $i < count($preguntas); $i++) {
        $respuesta = $_REQUEST[$i];
        $r = new Respuesta(0, $usuario->getId(), $respuesta, 0);
        gestionDatos::insertRespuesta($respuesta, $preguntas[$i]->getId());
        $r->setId(gestionDatos::getIdRespuesta());
        $solucion->addRespuesta($r);
    }
    gestionDatos::insertSolucion($solucion);
    $solucion->setId(gestionDatos::getIdSolucion($solucion));
    $usuario->addSolucion($solucion);
    $_SESSION['usuario'] = $usuario;
    foreach ($examenesPendientes as $k => $examen) {
        if ($examen->getId() == $examenS->getId()) {
            unset($examenesPendientes[$k]);
        }
    }
    $_SESSION['examenesPendientes'] = $examenesPendientes;
    $mensaje = 'Examen Entregado,SUERTE!!';
    $_SESSION['mensaje'] = $mensaje;
    header('Location: ../Vistas/inicio.php');
}