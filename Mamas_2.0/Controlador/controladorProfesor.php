<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/Asignatura.php';
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
    header('Location: ../Vistas/inicio.php');
}

//-----------------CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    unset($_SESSION['usuario']);
    header('Location: ../index.php');
}

//-----------------VER PERFIL
if (isset($_REQUEST['perfilP'])) {
    header('Location: ../Vistas/perfil.php');
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