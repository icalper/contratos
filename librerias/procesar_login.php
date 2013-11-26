<?php

require './sesion.php';
require './db.php';

$sesion = new manejadorSesion;

$usuario = filter_input(INPUT_POST, "usuario");
$password = filter_input(INPUT_POST, "password");
$passwordMD5 = md5($password);
$sql = "SELECT nomUsuario, tipoUsuario, contraseña FROM usuario WHERE nomUsuario = '$usuario'";
$result = mysql_query($sql);

$registro = mysql_fetch_array($result);

if ($registro != FALSE) { //Si se encontro el usuario
    if ($passwordMD5 == $registro['contraseña']) { // Si las contraseñas coinciden
        $nombreUsuario = $registro['nomUsuario'];
        $privilegios = $registro['tipoUsuario'];
        $sesion->registrar($nombreUsuario, $privilegios);
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=password"); // Si las contraseñas no coinciden
    }
} else {
    header("Location: ../login.php?error=usuario"); // Si el usuario no existe
}
?>