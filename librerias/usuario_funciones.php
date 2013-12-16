<?php

$datos = array();
require 'librerias/db.php';


//$usuario, $nombre, $password, $depto, $privilegios

switch ($accion) {
    case "agregar":
        $usuario = filter_input(INPUT_POST, "usuario");
        $nombre = filter_input(INPUT_POST, "nombre");
        $password = filter_input(INPUT_POST, "password");
        $depto = filter_input(INPUT_POST, "depto");
        $privilegios = filter_input(INPUT_POST, "privilegios");
        if ($usuario == "" || $nombre == "" || $password == "" || $depto == "" || $privilegios == "") {
            $_SESSION['msg'] = array("blue", "Hay uno o más campos vacíos");
            break;
        }
        agregar($usuario, $nombre, $password, $depto, $privilegios);
        break;
    case "modificar":
        $idusuario = filter_input(INPUT_POST, "idUsuario");
        $usuario = filter_input(INPUT_POST, "usuario");
        $nombre = filter_input(INPUT_POST, "nombre");
        $password = filter_input(INPUT_POST, "password");
        $depto = filter_input(INPUT_POST, "depto");
        $privilegios = filter_input(INPUT_POST, "privilegios");
        if($password == ""){
            $modificar_sql = "UPDATE `contratos`.`usuario`
            SET
            `tipoUsuario` = '$privilegios',
            `depUsuario` = '$depto',
            `nomPersonaUsuario` = '$nombre'
        WHERE `idUsuario` = $idusuario;";
        }else{
            $modificar_sql = "UPDATE `contratos`.`usuario`
            SET
            `tipoUsuario` = '$privilegios',
            `depUsuario` = '$depto',
            `contraseña` = '$password',
            `nomPersonaUsuario` = '$nombre'
            WHERE `idUsuario` = $idusuario;";
        }
//        die($modificar_sql);
        if (mysql_query($modificar_sql)) {
            $_SESSION['msg'] = array("green", "El usuario ha sido modificado");
        } else {
            $_SESSION['msg'] = array("red", "El usuario NO ha sido modificado: ".  mysql_error());
        }
        break;
    case "eliminar":
        $idusuario = filter_input(INPUT_POST, "idUsuario");
        $eliminar_sql = "DELETE FROM contratos.usuario WHERE idUsuario = $idusuario";
        if (mysql_query($eliminar_sql)) {
            $_SESSION['msg'] = array("green", "El usuario ha sido eliminado");
        } else {
            $_SESSION['msg'] = array("red", "El usuario NO ha sido eliminado");
        }
        break;
    case "asignar":
        $idusuario = filter_input(INPUT_POST, "idUsuario");
        $numcontrato = filter_input(INPUT_POST, "numContrato");
        $asignar_sql = "INSERT INTO contratos.asignacion (idAsignacion, idUsuario, idContrato) "
            . "         VALUES (null, $idusuario, (SELECT idContrato FROM contratos.contrato WHERE numContrato = '$numcontrato'));";
        mysql_query($asignar_sql);
        header("Location: usuario.php?f=as&u=$idusuario");
        
        break;
    default :
}

function agregar($usuario, $nombre, $password, $depto, $privilegios) {
    $pass_md5 = md5($password);
    $agregar_sql = "INSERT INTO `contratos`.`usuario`(`idUsuario`, `nomUsuario`, `tipoUsuario`, `depUsuario`, `contraseña`, `nomPersonaUsuario`)
                    VALUES
                    (null, '$usuario', '$privilegios', '$depto', '$pass_md5', '$nombre');";
    if (!mysql_query($agregar_sql)) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
    } else {
        $msg = array("green", "Usuario " . $usuario . " ha sido registrado");
    }
    $_SESSION['msg'] = $msg;
}

function modificar() {
    
}

function getUsuario($idUsuario) {
    $getUsuario_sql = "SELECT idUsuario, nomUsuario, nomPersonaUsuario, tipoUsuario, depUsuario FROM contratos.usuario WHERE idUsuario = '$idUsuario'";
    $result = mysql_query($getUsuario_sql);
    $usuario = mysql_fetch_row($result, MYSQL_ASSOC);

    if (!$result) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
    }
    $_SESSION['msg'] = $msg;

    return $usuario;
}

function getUsuarios() {
    $usuarios = array();
    $getUsuarios_sql = "SELECT idUsuario, nomUsuario, tipoUsuario, nomPersonaUsuario FROM contratos.usuario WHERE tipoUsuario < 4";
    $result = mysql_query($getUsuarios_sql);

    if (!$result) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
        $_SESSION['msg'] = $msg;
    }


    while ($registro = mysql_fetch_array($result, MYSQL_BOTH)) {
        array_push($usuarios, $registro);
    }
    return $usuarios;
}

function getContratos($idUsuario){
    $contratos = array();
    $getContratos_sql = "SELECT idAsignacion, numContrato, tipo
                        FROM contratos.asignacion JOIN contratos.contrato 
                        ON asignacion.idContrato = contrato.idContrato 
                        WHERE idUsuario = $idUsuario;";
    $result = mysql_query($getContratos_sql);
    
    if (!$result) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
        $_SESSION['msg'] = $msg;
    }
    
    while ($registro = mysql_fetch_array($result, MYSQL_BOTH)) {
        array_push($contratos, $registro);
    }
    return $contratos;
    
}

function eliminarContrato($idAsignacion) {
    $eliminarContrato_sql = "DELETE FROM contratos.asignacion WHERE idAsignacion = $idAsignacion";
    
    mysql_query($eliminarContrato_sql);
}
