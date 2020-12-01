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
include_once '../Modelo/Examen.php';
include_once '../Modelo/Solucion.php';
include_once '../Modelo/Correccion.php';
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
        $examenesPendientes = array();

        foreach ($asignaturas as $asignatura) {
            $examenAsig = $asignatura->getExamenes();
            foreach ($examenAsig as $examen) {
                if ($examen->getActivo() == 1) {
                    $examenesPendientes[] = $examen;
                }
            }
        }
        $_SESSION['examenesPendientes'] = $examenesPendientes;
        header('Location: ../Vistas/inicio.php');
    } else {
        header('Location: ../Vistas/inicioProfesor.php');
    }
}

//-----------------CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
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
//------AUTOR: ISRAEL MOLINA PULPON
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
    $idEx = gestionDatos::getUltEx();
    $ex = new Examen($idEx + 1, $idP, $contenido, $descripcion, 0);
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
    //var_dump($preguntas);
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
                    gestionDatos::insertRespuesta($respuesta, $usuario->getId(), $idPregunta);
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
    if (isset($_SESSION['vienesEx'])) {
        unset($_SESSION['vienesEx']);
    }
    header('Location: ../Vistas/crearPregunta.php');
}
if (isset($_REQUEST['crearPreguntasEx'])) {
    $_SESSION['vienesEx'] = true;
    header('Location: ../Vistas/crearPregunta.php');
}
if (isset($_REQUEST['verPreguntasCreadas'])) {
    $examenS = $_SESSION['examenS'];
    $preguntasExamen = $examenS->getPreguntas();
    if (isset($_SESSION['preguntasCreadas'])) {
        $preguntasCreadas = $_SESSION['preguntasCreadas'];
    } else {
        $preguntasCreadas = array();
    }
    $preguntasDisponibles = array();
    //Recogemos todas las preguntas de su asignatura, ahora vamos a quitar aquellas que estan
    //ya asignadas a un examen o que estan en la pantalla para asignarlas, para que no
    //se puedan elegir de nuevo. 
    $asignatura = $_SESSION['asignaturasImpartidas'];
    $preguntas = $asignatura[0]->getPreguntas();
    foreach ($preguntas as $i => $pregunta) {
        foreach ($preguntasExamen as $j => $preguntaEx) {
            if ($pregunta->getId() == $preguntaEx->getId()) {
                unset($preguntas[$i]);
            }
        }
        foreach ($preguntasCreadas as $z => $preguntaC) {
            if ($pregunta->getId() == $preguntaC->getId()) {
                unset($preguntas[$i]);
            }
        }
    }$preguntasDisponibles = $preguntas;
    $_SESSION['preguntasDisponibles'] = $preguntasDisponibles;
    header('Location: ../Vistas/crudPreguntas.php');
}
if (isset($_REQUEST['verExamenS'])) {
    header('Location: ../Vistas/verExamen.php');
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
        $_SESSION['mensaje'] = "Marca el exámen que quieras ver";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $_SESSION['examenS'] = $examenes[$pos];
        $_SESSION['creadorEx'] = gestionDatos::getUsuarioId($examenes[$pos]->getProfesor());
        header('Location: ../Vistas/verExamen.php');
    }
}
//------AUTOR: ISRAEL MOLINA PULPON & MARIA JUAN VIÑAS
//--------------------------------IR A EXAMEN CORRECCION DESDE TABLA
if (isset($_REQUEST['corregirTabla'])) {
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
        $_SESSION['mensaje'] = "Marca el exámen que quieras corregir";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        if ($examenes[$pos]->getPreguntas() != null) {
            $_SESSION['examenS'] = $examenes[$pos];
            $_SESSION['creadorEx'] = gestionDatos::getUsuarioId($examenes[$pos]->getProfesor());
            //PONER METODO 'CORREGIR' CUANDO ESTE IMPLEMENTADO
            $alumnosExamen = array();
            $soluciones = array();
            $examenS = $_SESSION['examenS'];
            $alumnos = $asignaturas[0]->getAlumnos();
            foreach ($alumnos as $i => $alumno) {
                $soluciones = $alumno->getSoluciones();
                $correcto = false;
                foreach ($soluciones as $j => $solucion) {
                    if ($solucion->getExamen() == $examenS->getId() && $solucion->getCorreccion() == null) {//!!!!!! comprobar que no esté corregido
                        $correcto = true;
                    }
                }
                if ($correcto) {
                    $alumnosExamen[] = $alumno;
                }
            }
            if (isset($_SESSION['correccionS'])) {
                unset($_SESSION['correccionS']);
            }
            $_SESSION['alumnosExamen'] = $alumnosExamen;
            header('Location: ../Vistas/correccion.php');
        } else {
            $_SESSION['mensaje'] = "Marca un exámen que contenga preguntas";
            header('Location: ../Vistas/crudExamenes.php');
        }
    }
}
//----------------ASIGNAR PREGUNTAS
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
        $_SESSION['mensaje'] = "Marca el exámen al que quieras añadir preguntas";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        if ($examenes[$pos]->getActivo() == 0) {
            $_SESSION['examenS'] = $examenes[$pos];
            $_SESSION['creadorEx'] = gestionDatos::getUsuarioId($examenes[$pos]->getProfesor());
            header('Location: ../Vistas/asignarPreguntas.php');
        } else {
            $_SESSION['mensaje'] = "No puedes modificar preguntas de un exámen ACTIVADO";
            header('Location: ../Vistas/crudExamenes.php');
        }
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
    header('Location: ../Vistas/verExamen.php');
}

//-----------------------ACTIVAR EXAMEN
if (isset($_REQUEST['activarExamen'])) {
    $pulsado = false;
    $examenes = $asignaturas[0]->getExamenes();
    if (count($examenes) > 0) {
        $cont = 0;
        foreach ($examenes as $i => $examen) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $examen->setActivo(1);

                if (!gestionDatos::updateExamenEstado($examen, 1)) {
                    $mensaje = 'No se ha podido activar el examen';
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        $_SESSION['mensaje'] = "Marca el/los examen(es) que quieras activar";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $asignaturas[0]->setExamenes($examenes);
        $_SESSION['asignaturas'] = $asignaturas;
        header('Location: ../Vistas/crudExamenes.php');
    }
}
//----------------------DESACTIVAR EXAMEN
if (isset($_REQUEST['desactivarExamen'])) {
    $pulsado = false;
    $examenes = $asignaturas[0]->getExamenes();
    if (count($examenes) > 0) {
        $cont = 0;
        foreach ($examenes as $i => $examen) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $examen->setActivo(0);
                if (!gestionDatos::updateExamenEstado($examen, 0)) {
                    $mensaje = 'No se ha podido activar el examen';
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        $_SESSION['mensaje'] = "Marca el/los examen(es) que quieras desactivar";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $asignaturas[0]->setExamenes($examenes);
        $_SESSION['asignaturas'] = $asignaturas;
        header('Location: ../Vistas/crudExamenes.php');
    }
}
//----------------------BORRAR EXÁMEN
if (isset($_REQUEST['borrarExamen'])) {
    $pulsado = false;
    $examenes = $asignaturas[0]->getExamenes();
    if (count($examenes) > 0) {
        $cont = 0;
        foreach ($examenes as $i => $examen) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                if (!gestionDatos::deleteExamen($examen)) {
                    $mensaje = 'No se ha podido borrar el examen';
                    $_SESSION['mensaje'] = $mensaje;
                }
                unset($examenes[$i]);
            }
        }
    }
    if (!$pulsado) {
        $_SESSION['mensaje'] = "Marca el/los examen(es) que quieras borrar";
        header('Location: ../Vistas/crudExamenes.php');
    } else {
        $asignaturas[0]->setExamenes($examenes);
        $_SESSION['asignaturas'] = $asignaturas;
        header('Location: ../Vistas/crudExamenes.php');
    }
}

//------------------ASIGNAR PREGUNTAS
if (isset($_REQUEST['asignarP'])) {
    if ($_SESSION['examenS']->getActivo() == 0) {
        header('Location: ../Vistas/asignarPreguntas.php');
    } else {
        $_SESSION['mensaje'] = "No puedes modificar preguntas de un exámen ACTIVADO";
        header('Location: ../Vistas/verExamen.php');
    }
}
//------------------CRUD PREGUNTAS
if (isset($_REQUEST['crudP'])) {
    header('Location: ../Vistas/crudPreguntas.php');
}
if (isset($_REQUEST['limpiar'])) {
    unset($_SESSION['preguntasF']);
    header('Location: ../Vistas/crudPreguntas.php');
}

//------------------CRUD PREGUNTAS
if (isset($_REQUEST['filtrar'])) {
    if (isset($_SESSION['preguntasDisponibles'])) {
        $preguntas = $_SESSION['preguntasDisponibles'];
    } else {
        $preguntas = $asignaturas[0]->getPreguntas();
    }
    if (isset($_REQUEST['tipoPregunta'])) {
        $tip = $_REQUEST['tipoPregunta'];
    } else {
        $tip = -1;
    }
    $misPreguntas;
    if (isset($_REQUEST['misPreguntas'])) {
        $misPreguntas = true;
    } else {
        $misPreguntas = false;
    };


    $preguntasF = array();

    foreach ($preguntas as $i => $pregunta) {
        $guardada = false;
        if ($pregunta->getTipo() == $tip) {
            $preguntasF[] = $pregunta;
            $guardada = true;
        }
        if ($misPreguntas && $pregunta->getProfesor() == $usuario->getId() && !$guardada) {
            $preguntasF[] = $pregunta;
            $guardada = true;
        }
    }
    $_SESSION['preguntasF'] = $preguntasF;

    header('Location: ../Vistas/crudPreguntas.php');
}

//----------------ASIGNAR PREGUNTAS
if (isset($_REQUEST['asignarPregunta'])) {
    if (isset($_SESSION['preguntasF'])) {
        $preguntas = $_SESSION['preguntasF'];
    } else {
        $preguntas = $asignaturas[0]->getPreguntas();
    }
    if (isset($_SESSION['preguntasCreadas'])) {
        $datos = $_SESSION['preguntasCreadas'];
    } else {
        $datos = array();
    }
    $cont = 0;
    foreach ($preguntas as $i => $pregunta) {
        if (isset($_REQUEST[$i])) {
            $pulsado = true;
            $datos[] = $pregunta;
        }
    }
    if (!$pulsado) {
        $_SESSION['mensaje'] = "Marca las preguntas que quieras añadir al exámen";
        header('Location: ../Vistas/crudPreguntas.php');
    } else {
        $_SESSION['preguntasCreadas'] = $datos;
        header('Location: ../Vistas/asignarPreguntas.php');
    }
}
if (isset($_REQUEST['verExamenP'])) {
    header('Location: ../Vistas/asignarPreguntas.php');
}

//-----------------------QUITAR PREGUNTA (DESDE ASIGNACION PREGUNTA, NO AÑADIDA TODAVIA)
if (isset($_SESSION['preguntasCreadas'])) {
    $accion = "";
    $preguntasCreadas = $_SESSION['preguntasCreadas'];
    foreach ($preguntasCreadas as $i => $pregunta) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $pos = $i;
        }
    }
    if ($accion == 'Quitar') {
        $preguntaSeleccionada = $preguntasCreadas[$pos];
        foreach ($preguntasCreadas as $j => $pregunta) {
            if ($preguntaSeleccionada->getId() == $pregunta->getId()) {
                unset($preguntasCreadas[$j]);
            }
        }
        $_SESSION['preguntasCreadas'] = $preguntasCreadas;
        header('Location: ../Vistas/asignarPreguntas.php');
    }
}
if (isset($_REQUEST['verAlumnos'])) {
    header('Location: ../Vistas/verAlumnos.php');
}
//------------------CORREGIR EXÁMEN CARGAR PÁGINA
if (isset($_REQUEST['corregir'])) {
    $alumnosExamen = array();
    $soluciones = array();
    $examenS = $_SESSION['examenS'];
    $alumnos = $asignaturas[0]->getAlumnos();
    foreach ($alumnos as $i => $alumno) {
        $soluciones = $alumno->getSoluciones();
        $correcto = false;
        foreach ($soluciones as $j => $solucion) {
            if ($solucion->getExamen() == $examenS->getId() && $solucion->getCorreccion() == null) {//!!!!!! comprobar que no esté corregido
                $correcto = true;
            }
        }
        if ($correcto) {
            $alumnosExamen[] = $alumno;
        }
    }
    if (isset($_SESSION['correccionS'])) {
        unset($_SESSION['correccionS']);
    }
    $_SESSION['alumnosExamen'] = $alumnosExamen;
    header('Location: ../Vistas/correccion.php');
}
//-----------------------VER EXAMEN DE UN ALUMNO
if (isset($_SESSION['alumnosExamen'])) {
    $alumnosExamen = $_SESSION['alumnosExamen'];
    $examen = $_SESSION['examenS'];
    $accion = "";
    foreach ($alumnosExamen as $i => $alumno) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $pos = $i;
        }
    }
    if ($accion == 'Corregir') {
        $alumnoS = $alumnosExamen[$pos];
        $_SESSION['alumnoS'] = $alumnoS;
        $soluciones = $alumnoS->getSoluciones();
        foreach ($soluciones as $i => $solucion) {
            if ($solucion->getExamen() == $examen->getId()) {
                $_SESSION['correccionS'] = $solucion;
            }
        }
        header('Location: ../Vistas/correccion.php');
    }
}

//------AUTOR: ISRAEL MOLINA PULPON & MARIA JUAN VIÑAS
//-----------------------------CORREGIR EXAMEN DE UN ALUMNO
if (isset($_REQUEST['corregirExamen'])) {

    //recogemos datos y creamos el objeto correccion
    $examenS = $_SESSION['examenS'];
    $alumnoS = $_SESSION['alumnoS'];
    $notas = array();
    $notaTexto = $_REQUEST['nota'];
    $anotacion = $_REQUEST['anotacion'];
    $solucionAlumno = $_SESSION['correccionS'];
    $respuestasAlu = $solucionAlumno->getRespuestas();
    $preguntasS = $examenS->getPreguntas();


    foreach ($preguntasS as $i => $preguntaS) {
        $corregido = false;
        $respuestasS = $preguntaS->getRespuestas();
        foreach ($respuestasS as $j => $respuestaS) {
            if ($preguntaS->getTipo() == 1 && !$corregido) {
                //tipo test
                if ($respuestasAlu[$i]->getRespuesta() == $respuestaS->getRespuesta()) {
                    if ($respuestaS->getCorrecta() == 1) {
                        //respuesta correcta sumamos puntuacion
                        $notas[] = $preguntaS->getPuntuacion();
                        $corregido = true;
                    } else {
                        $notas[] = 0;
                        $corregido = true;
                    }
                } else if ($respuestasAlu[$i]->getRespuesta() == "") {
                    $notas[] = 0;
                    $corregido = true;
                }
            } else if ($preguntaS->getTipo() == 0 && !$corregido) {// tipo texto
                $n = array_shift($notaTexto);
                if ($n == "") {
                    $n = 0;
                } else {
                    $n = intval($n);
                }
                $notas[] = $n;
                $corregido = true;
            }
        }
    }
    //creamos el objeto Correccion y lo guardamos dentro de la solucion del alumno.
    $correccionProfesor = new Correccion($usuario->getId());
    $correccionProfesor->setAnotacion($anotacion);
    $correccionProfesor->setNotas($notas);

    gestionDatos::insertCorreccion($correccionProfesor, $solucionAlumno->getId());

    $solucionAlumno->setCorreccion($correccionProfesor);
    $usuario->addCorreccion($correccionProfesor);

    //cogemos el objeto alumno y sacamos todas sus soluciones para actualizar su solucion con su correccion dentro
    $solucionesAlumno = $alumnoS->getSoluciones();
    foreach ($solucionesAlumno as $i => $sol) {
        if ($sol->getId() == $solucionAlumno->getId()) {
            $solucionesAlumno[$i] = $solucionAlumno;
        }
    }

    //metemos el array actualizado Soluciones dentro del alumno

    $alumnoS->setSoluciones($solucionesAlumno);
    $_SESSION['alumnoS'] = $alumnoS;

    //actualizamos el alumno en el array alumnos de su asignatura
    $asignaturas = $_SESSION['asignaturasImpartidas'];

    for ($i = 0; $i < count($asignaturas); $i++) {
        $alumnos = $asignaturas[$i]->getAlumnos();

        for ($j = 0; $j < count($alumnos); $j++) {
            if ($alumnos[$j]->getId() == $alumnoS->getId()) {
                $alumnos[$j] = $alumnoS;
                $asignaturas[$i]->setAlumnos($alumnos);
            }
        }
    }
    $_SESSION['asignaturasImpartidas'] = $asignaturas;

    //Quitar alumno de alumnosS (desaparece visualmente) 
    $alumnoS = $_SESSION['alumnoS'];
    $alumnosS = $_SESSION['alumnosExamen'];
    foreach ($alumnosS as $i => $alumno) {
        if ($alumno->getId() == $alumnoS->getId()) {
            unset($alumnosS[$i]);
        }
    }
    $_SESSION['alumnosExamen'] = $alumnosS;

    //Aparezca exámen original
    unset($_SESSION['correccionS']);
    header('Location: ../Vistas/correccion.php');
}
//------------------------QUITAR PREGUNTA YA AÑADIDA A UN EXAMEN
if (isset($_SESSION['examenS'])) {
    $examen = $_SESSION['examenS'];
    $preguntas = $examen->getPreguntas();
    $accion = "";
    foreach ($preguntas as $i => $pregunta) {
        if (isset($_REQUEST[$i])) {
            $accion = $_REQUEST[$i];
            $pos = $i;
        }
    }
    if ($accion == 'Borrar') {
        $preguntaSeleccionada = $preguntas[$pos];
//Borrar en bd
        gestionDatos::deleteAsignacionPreguntaExamen($examen->getId(), $preguntaSeleccionada->getId());
//Borrar en el objeto
        unset($preguntas[$pos]);
        $examen->setPreguntas($preguntas);

        $asignatura = $_SESSION['asignaturasImpartidas'];
        $examenes = $asignatura[0]->getExamenes();
        foreach ($examenes as $j => $examen2) {
            if ($examen2->getId() == $examen->getId()) {
                $examenes[$j] = $examen;
                $asignatura[0]->setExamenes($examenes);
                $_SESSION['asignaturasImpartidas'] = $asignatura;
            }
        }
        header('Location: ../Vistas/verExamen.php');
    }
}

    