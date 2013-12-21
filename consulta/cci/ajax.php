<?php
$aColumns = array('numCompra','numContrato', 'especialidad', 'descripcion', 'tipoContrato', 'compañia', 'supervisor', 'inicio', 'plazoEjecucion', 'estado', 'observaciones');

$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

$row_id = filter_input(INPUT_POST, "row_id");
$column = filter_input(INPUT_POST, "column");
$value = filter_input(INPUT_POST, "value");

$id = substr($row_id, 4);

$sql="UPDATE `contratos`.`contratoCompraInstalacion` SET `$aColumns[$column]`='$value' WHERE `numCompra`='$id';";

echo mysql_query($sql);

mysql_close($cn);
//echo $sql;
?>