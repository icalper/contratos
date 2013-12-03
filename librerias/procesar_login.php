<?php

require './sesion.php';
require './db.php';

$sesion = new manejadorSesion;

$usuario = filter_input(INPUT_POST, "usuario");
$password = filter_input(INPUT_POST, "password");
$passwordMD5 = md5($password);
$sql = "SELECT idUsuario, nomUsuario, tipoUsuario, contraseña FROM usuario WHERE nomUsuario = '$usuario'";
$result = mysql_query($sql);
//SELECT contrato.numContrato FROM contratos.contrato JOIN contratos.asignacion ON contrato.idContrato = asignacion.idContrato WHERE asignacion.idUsuario=1;
$registro = mysql_fetch_array($result);

if ($registro != FALSE) { //Si se encontro el usuario
    if ($passwordMD5 == $registro['contraseña']) { // Si las contraseñas coinciden
        $idUsuario = $registro['idUsuario'];
        $nombreUsuario = $registro['nomUsuario'];
        $privilegios = $registro['tipoUsuario'];
        $listaContratos = 0;
        
        if($privilegios == manejadorSesion::USUARIO_SUPERVISOR){
            $listaContratos=listaContratos($idUsuario);            
        }
        
        $sesion->registrar($nombreUsuario, $privilegios, $listaContratos);
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=password"); // Si las contraseñas no coinciden
    }
} else {
    header("Location: ../login.php?error=usuario"); // Si el usuario no existe
}

function listaContratos($idUsuario) {
    $listaContratos = array();
    $sql="SELECT contrato.numContrato FROM contratos.contrato JOIN contratos.asignacion ON contrato.idContrato = asignacion.idContrato WHERE asignacion.idUsuario=$idUsuario";
    $result = mysql_query($sql);
    
    while($contrato = mysql_fetch_row($result)){
        array_push($listaContratos, $contrato[0]);
    }
    
    return $listaContratos;
}
?>