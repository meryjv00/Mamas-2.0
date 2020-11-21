<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../Modelo/Usuario.php';
include_once '../Auxiliar/gestionDatos.php';
session_start();

//-----------------CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    unset($_SESSION['usuario']);
    header('Location: ../index.php');
}

//------------------EDITAR USUARIO
if (isset($_REQUEST['editarUsuario'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        $cont = 0;
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $cont++;
                $pos = $i;
            }
        }
    }
    if (!$pulsado || $cont >= 2) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        $usu = $usuarios[$pos];

        $nombres = $_REQUEST['nombre'];
        $apellidos = $_REQUEST['apellidos'];
        $tfnos = $_REQUEST['tfno'];

        $usu->setNombre($nombres[$pos]);
        $usu->setApellidos($apellidos[$pos]);
        $usu->setTelefono($tfnos[$pos]);

        if (!gestionDatos::updateUsuario($usu)) {
            $mensaje = 'No se ha podido actualizar el usuario';
            $_SESSION['mensaje'] = $mensaje;
        }
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//------------------ELIMINAR USUARIO
if (isset($_REQUEST['borrarUsuario'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                if (!gestionDatos::deleteUsuario($usuario)) {
                    $mensaje = 'No se ha podido borrar el usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        $usuarios = gestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//------------------CREAR USUARIO
if (isset($_REQUEST['nuevoUsuario'])) {
    header('Location: ../Vistas/registroAdmin.php');
}

if (isset($_REQUEST['crearUsuario'])) {
    $email = $_REQUEST['email'];
    $dni = $_REQUEST['dni'];
    $nombre = $_REQUEST['nombre'];
    $apellidos = $_REQUEST['apellidos'];
    $tfno = $_REQUEST['tfno'];
    $pass = md5($_REQUEST['pass']);
    $rol = $_REQUEST['rol'];

    if (!gestionDatos::isUsuario($email)) {
        if (!gestionDatos::isDni($dni)) {
            //Crear alumno

            if (!gestionDatos::insertUsuario($email, $dni, $nombre, $apellidos, $tfno, $pass)) {
                $mensaje = "No se ha podido insertar el usuario";
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../Vistas/registroAdmin.php');
            } else {
                if ($rol == 'Alumno') {
                    if (gestionDatos::insertUsuarioRol(gestionDatos::getIdUsuario($email), 0)) {
                        $mensaje = "¡Cuenta creada!";
                        $_SESSION['mensaje'] = $mensaje;
                    }
                } else if ($rol == 'Profesor') {
                    if (gestionDatos::insertUsuarioRol(gestionDatos::getIdUsuario($email), 1)) {
                        $mensaje = "¡Cuenta creada!";
                        $_SESSION['mensaje'] = $mensaje;
                    }
                } else if ($rol == 'Administrador') {
                    if (gestionDatos::insertUsuarioRol(gestionDatos::getIdUsuario($email), 2)) {
                        $mensaje = "¡Cuenta creada!";
                        $_SESSION['mensaje'] = $mensaje;
                    }
                }
                $usuarios = gestionDatos::getUsuarios();
                $_SESSION['usuarios'] = $usuarios;
                header('Location: ../Vistas/crudAdmin.php');
            }
        } else {
            $r_usu = new Usuario(0, $email, "", $nombre, $apellidos, $tfno, 0, 0);
            $_SESSION['usu'] = $r_usu;
            $mensaje = "El dni introducido ya está registrado";
            $_SESSION['mensaje'] = $mensaje;
            header('Location: ../Vistas/registroAdmin.php');
        }
    } else {
        $r_usu = new Usuario(0, "", $dni, $nombre, $apellidos, $tfno, 0, 0);
        $_SESSION['usu'] = $r_usu;
        $mensaje = "El email introducido ya está registrado";
        $_SESSION['mensaje'] = $mensaje;
        header('Location: ../Vistas/registroAdmin.php');
    }
}

//--------------------ACTIVAR USUARIO
if (isset($_REQUEST['activarUsuario'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $usuario->setActivo(1);
                if (!gestionDatos::updateActivo($usuario)) {
                    $mensaje = 'No se ha podido activar el usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//--------------------DESACTIVAR USUARIO
if (isset($_REQUEST['desactivarUsuario'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $usuario->setActivo(0);
                if (!gestionDatos::updateActivo($usuario)) {
                    $mensaje = 'No se ha podido activar el usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//--------------------CAMBIAR ROL ALUMNO
if (isset($_REQUEST['cambiarRolAlumno'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $usuario->setRol(0);
                if (!gestionDatos::updateRol($usuario)) {
                    $mensaje = 'No se ha podido cambiar el rol del usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        $usuarios = gestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//--------------------CAMBIAR ROL PROFESOR
if (isset($_REQUEST['cambiarRolProfesor'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $usuario->setRol(1);
                if (!gestionDatos::updateRol($usuario)) {
                    $mensaje = 'No se ha podido cambiar el rol del usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        $usuarios = gestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        header('Location: ../Vistas/crudAdmin.php');
    }
}

//--------------------CAMBIAR ROL ADMINISTRADOR
if (isset($_REQUEST['cambiarRolAdmnistrador'])) {
    $usuarios = $_SESSION['usuarios'];
    if (count($usuarios) > 0) {
        foreach ($usuarios as $i => $usuario) {
            if (isset($_REQUEST[$i])) {
                $pulsado = true;
                $usuario->setRol(2);
                if (!gestionDatos::updateRol($usuario)) {
                    $mensaje = 'No se ha podido cambiar el rol del usuario con mail: ' . $usuario->getEmail();
                    $_SESSION['mensaje'] = $mensaje;
                }
            }
        }
    }
    if (!$pulsado) {
        header('Location: ../Vistas/crudAdmin.php');
    } else {
        $usuarios = gestionDatos::getUsuarios();
        $_SESSION['usuarios'] = $usuarios;
        header('Location: ../Vistas/crudAdmin.php');
    }
}