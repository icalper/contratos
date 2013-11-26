<?php

require './librerias/sesion.php';

$sesion = new manejadorSesion;

$sesion->terminar();

header("Location: index.php");
?>