<?php
$aColumns = array('numServicio','numContrato', 'especialidad', 'descripcion', 'tipoContrato', 'compañia', 'residente', 'supCivil', 'supMecanica', 'supPlantas', 'supElectrica', 'supInstrumentos', 'multianualidad', 'inicioContractual', 'terminoContractual', 'inicioReal', 'terminoReal', 'plazoEjecucion', 'montoContratado', 'cmPlazoProrroga', 'cmMonto', 'unidadInversion', 'sap', 'pagado20112012', 'saldo20112012', 'estimado2013', 'saldo2013', 'estado', 'reFisica', 'finiquito', 'observaciones', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

$row_id = filter_input(INPUT_POST, "row_id");
$column = filter_input(INPUT_POST, "column");
$value = filter_input(INPUT_POST, "value");

$id = substr($row_id, 4);

$sql="UPDATE `contratos`.`contratoServicio` SET `$aColumns[$column]`='$value' WHERE `numServicio`='$id';";

echo mysql_query($sql);

mysql_close($cn);
//echo $sql;
?>