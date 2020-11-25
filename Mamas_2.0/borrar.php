<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$datos = $_REQUEST['datos']; // datos contiene una cadena STRING con el formato que usa JSON datos={"nombre":"israel","puntuacion":8}

$datosInicialesT = json_decode($datos, true); //Array normal toca recorrerlo para recoger datos
$datosInicialesF = json_decode($datos, false); // Array asociativo los datos van por referencia

echo'valores True objeto';
var_dump($datosInicialesT);

echo json_encode($datosInicialesT); // te lo vuelve a pasar a formato CADENA
var_dump($datosInicialesT);

echo 'valores false cadena'; // array asociativo , por lo tanto puedes llamar por el nombre de campo al valor
var_dump($datosInicialesF);
echo json_encode($datosInicialesF); // te lo vuelve a pasar a formato CADENA
var_dump($datosInicialesF);


echo $datosInicialesF->nombre;
echo'<br>' . $datosInicialesF->puntuacion;

