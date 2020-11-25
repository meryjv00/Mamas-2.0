<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Auxiliar/gestionDatos.php';
include_once '../Modelo/Usuario.php';
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

if (isset($_REQUEST['aniadirPreguntas'])) {
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
        $p = new Pregunta(0, $profesor, $enunciado, $tipo, $puntuacion);
        foreach ($asignaturas as $q => $asignatura) {
            if ($idAsig == $asignatura->getIdAsignatura()) {
                $idPregunta = gestionDatos::insertPregunta($p, $idAsig);
                //INSERTAR OPCIONES O PALABRAS CLAVE
                $datos = $preguntas[$i]->datos;
                foreach ($datos as $j => $dato) {
                    if ($tipo == 0) {
                        $nombre = $dato->nombre;
                        $respuesta = new Respuesta(0, $profesor, $nombre, 0);
                    } else {
                        $opcion = $dato->opcion;
                        if ($dato->correcto) {
                            $correcto = 1;
                        } else {
                            $correcto = 0;
                        }
                        $respuesta = new Respuesta(0, $profesor, $opcion, $correcto);
                    }
                    $p->addRespuesta($respuesta);
                    gestionDatos::insertRespuesta($respuesta, $idPregunta);
                }
                $asignatura->addPregunta($p);
            }
        }
        $_SESSION['asignaturasImpartidas'] = $asignaturas;
    }
}