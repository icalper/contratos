<!-- http://ProgramarEnPHP.wordpress.com -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Importar de Excel a la Base de Datos ::</title>
</head>

<body>
<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL  -->
Selecciona el archivo a importar:
<form name="importa" method="post" action="importar2.php" enctype="multipart/form-data" >
<input type="file" name="excel" />
<input type='submit' name='enviar'  value="Importar"  />
<input type="hidden" value="upload" name="action" />
</form>
<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

<?php 
error_reporting(E_ALL ^ E_NOTICE);
extract($_POST);
if ($action == "upload"){
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito";
	else echo "Error Al Cargar el Archivo";
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)){ 
/** Clases necesarias */
require_once('Classes/PHPExcel.php');
require_once('Classes/PHPExcel/Reader/Excel2007.php');

// Cargando la hoja de cálculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);

//conectamos con la base de datos 
$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=5;$i<=47;$i++){
	$_DATOS_EXCEL[$i]['numeroDeContratoRMIN'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['especialidad'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['descripcion'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['tipoContrato']= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['compañia']= $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorResidente'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorFaseCivil'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorFaseMecanica'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorFasePlan'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorFaseElectrica'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supervisorFaseInstrumentos'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['plurianualidad'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['fechaDeInicio'] = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['fechaDeTerminacion'] = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['plazoDeEjecucion'] = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['montoContratadoMultianual'] = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['montoContratado'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['convenioModificatorioDePlazoProrroga'] = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['convenioModificatorioDeMonto'] = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['unidadDeInversion'] = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['pedidoSAP'] = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['pagado20112012'] = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['saldo20112012'] = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estimado2013'] = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estimadoConvenio'] = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['saldo2013'] = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['avanceFisico'] = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['avanceFinanciero'] = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estado'] = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['enero'] = $objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['febrero'] = $objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['marzo'] = $objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['abril'] = $objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['mayo'] = $objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['junio'] = $objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['julio'] = $objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['agosto'] = $objPHPExcel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['septiembre'] = $objPHPExcel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['octubre'] = $objPHPExcel->getActiveSheet()->getCell('AN'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['noviembre'] = $objPHPExcel->getActiveSheet()->getCell('AO'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['diciembre'] = $objPHPExcel->getActiveSheet()->getCell('AP'.$i)->getCalculatedValue();
}		
}
//si por algo no cargo el archivo bak_ 
else{echo "Necesitas primero importar el archivo";}
$errores=0;
//recorremos el arreglo multidimensional 
//para ir recuperando los datos obtenidos
//del excel e ir insertandolos en la BD
foreach($_DATOS_EXCEL as $campo => $valor){
	$sql = "INSERT INTO alumnos VALUES (NULL,'";
	foreach ($valor as $campo2 => $valor2){
		$campo2 == "diciembre" ? $sql.= $valor2."');" : $sql.= $valor2."','";
	}
	$result = mysql_query($sql);
	if (!$result){ echo "Error al insertar registro ".$campo;$errores+=1;}
}	
/////////////////////////////////////////////////////////////////////////

echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
//una vez terminado el proceso borramos el 
//archivo que esta en el servidor el bak_
unlink($destino);
}

?>
</body>
</html>