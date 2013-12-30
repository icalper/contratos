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
$fechainicio = strtotime(filter_input(INPUT_POST, "fechainicio"));
$cmmonto = filter_input(INPUT_POST, "cmmonto");
$termino = strtotime(filter_input(INPUT_POST, "termino"));
$plazoejecucion = filter_input(INPUT_POST, "plazoejecucion");
$sap = filter_input(INPUT_POST, "sap");
$unidadinversion = filter_input(INPUT_POST, "unidadinversion");

if($accion == "crear"){
    if ($tipoc == "aa"){
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `inicio`, `termino`) VALUES ('$especialidad', '$contrato', '$descripcion', '$fechainicio', '$termino')";
    } elseif ($tipoc == "co") {
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `compañia`, `inicioContractual`, `cmMonto`, `plazoEjecucion`, `sap`, `unidadInversion`, `terminoReal`) VALUES ('$especialidad', '$contrato', '$descripcion', '$compania', '$fechainicio', '$cmmonto', '$plazoejecucion', '$sap', '$unidadinversion', '$termino')";
    } elseif ($tipoc == "cs")  {
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `compañia`, `inicio`, `cmMonto`, `plazoEjecucion`, `sap`, `unidadInversion`, `termino`) VALUES ('$especialidad', '$contrato', '$descripcion', '$compania', '$fechainicio', '$cmmonto', '$plazoejecucion', '$sap', '$unidadinversion', '$termino')";
    } elseif ($tipoc == "cci") {
        $crearContrato_sql = "INSERT INTO contratos.$contratos_tablas[$tipoc] (`especialidad`, `numContrato`, `descripcion`, `compañia`, `inicio`, `plazoEjecucion`) VALUES ('$especialidad', '$contrato', '$descripcion', '$compania', '$fechainicio', '$plazoejecucion')";
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
