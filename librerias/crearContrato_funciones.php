<?php

require 'db.php';

$tipoc = filter_input(INPUT_POST, "tipoc");
$contratos_tablas = array(
                            co => "contratoobra",
                            cs => "contratoservicio",
                            cci => "contratocomprainstalacion",
                            aa => "acuerdoadministrativo"
                        );
$contrato = filter_input(INPUT_POST, "contrato");
$especialidad = filter_input(INPUT_POST, "especialidad");
$compania = filter_input(INPUT_POST, "compania");
$descripcion = filter_input(INPUT_POST, "descripcion");
$fechainicio = filter_input(INPUT_POST, "fechainicio");

if($accion == "crear"){
    if ($tipoc == "aa"){
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `inicio`) VALUES ('$especialidad', '$contrato', '$descripcion', '$fechainicio')";
    } elseif ($tipoc == "co") {
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `compañia`, `inicioContractual`) VALUES ('$especialidad', '$contrato', '$descripcion', '$compania', '$fechainicio')";
    } else {
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `compañia`, `inicio`) VALUES ('$especialidad', '$contrato', '$descripcion', '$compania', '$fechainicio')";
    }
    
    $crearContrato_sql2 = "INSERT INTO contrato VALUES (null,'$contrato','$tipoc')";
    $result = mysql_query($crearContrato_sql2);
    
    if (!$result) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
        $_SESSION['msg'] = $msg;
    }
    
    $result = mysql_query($crearContrato_sql);
    
    if (!$result) {
        $error = mysql_errno();
        $msg = array("red", $error . " : " . mysql_error());
        $_SESSION['msg'] = $msg;
    }
    
    header("Location: crearContrato.php?c=$tipoc");
}

?>
