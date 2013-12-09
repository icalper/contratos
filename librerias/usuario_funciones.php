<?php

$datos = array();


//$usuario, $nombre, $password, $depto, $privilegios

switch ($accion) {
    case "agregar":
        $usuario = filter_input(INPUT_POST, "usuario");
        $nombre = filter_input(INPUT_POST, "nombre");
        $password = filter_input(INPUT_POST, "password");
        $depto = filter_input(INPUT_POST, "depto");
        $privilegios = filter_input(INPUT_POST, "privilegios");
        if($usuario == "" || $nombre == "" || $password == "" || $depto == "" || $privilegios == ""){
            $_SESSION['msg']= array("blue","Hay uno o más campos vacíos");
            break;
        }
        agregar($usuario, $nombre, $password, $depto, $privilegios);
        break;
    case "modificar":
        break;
    case "eliminar":
        break;
    case "eliminar_definitivo":
        break;
    default :
}

function agregar($usuario, $nombre, $password, $depto, $privilegios) {
    require 'librerias/db.php';
    $pass_md5 = md5($password);
    $agregar_sql = "INSERT INTO `contratos`.`usuario`(`idUsuario`, `nomUsuario`, `tipoUsuario`, `depUsuario`, `contraseña`, `nomPersonaUsuario`)
                    VALUES
                    (null, '$usuario', '$privilegios', '$depto', '$pass_md5', '$nombre');";
    if (!mysql_query($agregar_sql)) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
    } else {
        $msg = array("green","Usuario " . $usuario . " ha sido registrado");
    }
    $_SESSION['msg']=$msg;
}

function modificar() {
    
}

function eliminar() {
    
}
