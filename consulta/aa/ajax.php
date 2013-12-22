<?php
$aColumns = array('numAcuerdo', 'numContrato', 'especialidad', 'descripcion', 'tipoContrato', 'residente', 'supPlantas', 'supElectrico', 'supMecanica', 'supCivil', 'supInstrumento', 'supUasipa', 'proyecto', 'inicio', 'termino');
$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

$row_id = filter_input(INPUT_POST, "row_id");
$column = filter_input(INPUT_POST, "column");
$value = filter_input(INPUT_POST, "value");

$id = substr($row_id, 4);

$sql="UPDATE `contratos`.`acuerdoadministrativo` SET `$aColumns[$column]`='$value' WHERE `numAcuerdo`='$id';";

echo mysql_query($sql);

mysql_close($cn);
//echo $sql;
?>