<?php
require '../librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_ADMIN;
$sesion = new manejadorSesion;

if ($sesion->getPrivilegios() < $nivelAcceso) {    // Codigo para la seguridad por privilegios
    header("Location: ../index.php");
}
?>
<?php 
$titulo="Importar Contratos de Obra desde archivo excel"; 
require 'importar.head';
?>
<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<h1><?php echo $titulo; ?></h1>
<p>Para importar, seleccione el archivo y a continuación presione el botón "Importar"</p>
<h3>Importar unicamente los formatos prediseñados para Contratos de Obra</h3>
<h3>Selecciona el archivo a importar:</h3>
<form id="contact" name="importa" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data" >
    <div class="form_settings">
<input class="contact" type="file" name="excel" />
<input class="submit" type='submit' name='enviar'  value="Importar"  />
<input type="hidden" value="upload" name="action" />
    </div>
</form>


<?php 
//error_reporting(E_ALL ^ E_NOTICE);
extract($_POST);
if ($action == "upload"){
//cargamos el archivo al servidor con el mismo nombre
//solo le agregue el sufijo bak_ 
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bak_".$archivo;
	if (copy($_FILES['excel']['tmp_name'],$destino)) {
        echo "<h2 style=\"color: #09BCE8;\">Archivo Cargado Con Exito</h2>";
        } else {
        echo "<h2 style=\"color: red;\">Error Al Cargar el Archivo</h2>";
        $errores=-1;
        }
////////////////////////////////////////////////////////
if (file_exists ("bak_".$archivo)){ 
/** Clases necesarias */
require_once('../librerias/PHPExcel.php');
require_once('../librerias/PHPExcel/Reader/Excel2007.php');

// Cargando la hoja de calculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       


// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);

//conectamos con la base de datos 
$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=6;$i<=200;$i++){
	$_DATOS_EXCEL[$i]['especialidad'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['numContrato'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	//se agrega mysql_real_escape_string() para evitar error por datos con ' y que finalize la consulta.
        $_DATOS_EXCEL[$i]['descripcion'] = mysql_real_escape_string($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
	$_DATOS_EXCEL[$i]['tipoContrato']= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['compañia']= mysql_real_escape_string($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
	$_DATOS_EXCEL[$i]['residente'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supCivil'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supMecanica'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supPlan'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supElectrica'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supInstrumentos'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['plurianualidad'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
          //Convertimos los formatos de fecha para que sea legible para mysql
        $fechaInicioContractual= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue());
        $fechaTerminoContractual= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
        $fechaInicioReal= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue());
        $fechaTerminoReal= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue());
        
	$_DATOS_EXCEL[$i]['inicioContractual'] = date("Y-m-d", $fechaInicioContractual);
	$_DATOS_EXCEL[$i]['terminoContractual'] = date("Y-m-d", $fechaTerminoContractual);
        $_DATOS_EXCEL[$i]['inicioReal'] = date("Y-m-d", $fechaInicioReal);
	$_DATOS_EXCEL[$i]['terminoReal'] = date("Y-m-d", $fechaTerminoReal);
        
	$_DATOS_EXCEL[$i]['plazoEjecucion'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
	
	$_DATOS_EXCEL[$i]['montoContratado'] = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['cmPlazoProrroga'] = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['cmMonto'] = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['unidadInversion'] = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['sap'] = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['pagado20112012'] = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['saldo20112012'] = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estimado2013'] = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estimadoConvenio'] = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['saldo2013'] = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['avanceFisico'] = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['avanceFinanciero'] = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estado'] = $objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
	
        $fechareFisica= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue());
        $fechafiniquito= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue());
        
        $_DATOS_EXCEL[$i]['reFisica'] = date("Y-m-d", $fechareFisica);
	$_DATOS_EXCEL[$i]['finiquito'] = date("Y-m-d", $fechafiniquito);
        
        
        $_DATOS_EXCEL[$i]['observaciones'] = $objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['enero'] = $objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['febrero'] = $objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['marzo'] = $objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['abril'] = $objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['mayo'] = $objPHPExcel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['junio'] = $objPHPExcel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['julio'] = $objPHPExcel->getActiveSheet()->getCell('AN'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['agosto'] = $objPHPExcel->getActiveSheet()->getCell('AO'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['septiembre'] = $objPHPExcel->getActiveSheet()->getCell('AP'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['octubre'] = $objPHPExcel->getActiveSheet()->getCell('AQ'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['noviembre'] = $objPHPExcel->getActiveSheet()->getCell('AR'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['diciembre'] = $objPHPExcel->getActiveSheet()->getCell('AS'.$i)->getCalculatedValue();
}		
}
//si por algo no cargo el archivo bak_ 
else{echo "<p>El archivo no se ha podido importar o no se ha seleccionado un archivo válido</p>";}
//recorremos el arreglo multidimensional 
//para ir recuperando los datos obtenidos
//del excel e ir insertandolos en la BD
foreach($_DATOS_EXCEL as $filaNum => $filaContenido){
	$sql = "INSERT INTO contratoobra VALUES (null,'";
        $sql2 = "INSERT INTO contrato VALUES (null,'";
	foreach ($filaContenido as $campoNombre => $campoValor){
		$campoNombre == "diciembre" ? $sql.= $campoValor."') " : $sql.= $campoValor."','";
                if($campoNombre == "numContrato") {
                    $sql2.= $campoValor."','CO');";
                }
                //if($campoNombre == "inicio") {
                //    echo "Fecha:'$campoValor'";
                //}
	}
        //Para actualizar los datos reemplazando los repetidos
        $sql.= "ON DUPLICATE KEY UPDATE "
                . "especialidad = values(especialidad),"
                . "descripcion = values(descripcion),"
                . "tipoContrato = values(tipoContrato),"
                . "compañia  = values(compañia),"
                . "residente = values(residente),"
                . "supCivil = values(supCivil),"
                . "supMecanica = values(supMecanica),"
                . "supPlan = values(supPlan),"
                . "supElectrica = values(supElectrica),"
                . "supInstrumentos = values(supInstrumentos),"
                . "plurianualidad = values(plurianualidad),"
                . "inicioContractual = values(inicioContractual),"
                . "terminoContractual = values(terminoContractual),"
                . "inicioReal = values(inicioReal),"
                . "terminoReal = values(terminoReal),"
                . "plazoEjecucion = values(plazoEjecucion),"
                . "montoContratado = values(montoContratado),"
                . "cmPlazoProrroga = values(cmPlazoProrroga),"
                . "cmMonto = values(cmMonto),"
                . "unidadInversion = values(unidadInversion),"
                . "sap = values(sap),"
                . "pagado20112012 = values(pagado20112012),"
                . "saldo20112012 = values(saldo20112012),"
                . "estimado2013 = values(estimado2013),"
                . "estimadoConvenio = values(estimadoConvenio),"
                . "saldo2013 = values(saldo2013),"
                . "avanceFisico = values(avanceFisico),"
                . "avanceFinanciero = values(avanceFinanciero),"
                . "estado = values(estado),"
                . "reFisica = values(reFisica),"
                . "finiquito = values(finiquito),"
                . "observaciones = values(observaciones),"
                . "enero = values(enero),"
                . "febrero = values(febrero),"
                . "marzo = values(marzo),"
                . "abril = values(abril),"
                . "mayo = values(mayo),"
                . "junio = values(junio),"
                . "julio = values(julio),"
                . "agosto = values(agosto),"
                . "septiembre = values(septiembre),"
                . "octubre = values(octubre),"
                . "noviembre = values(noviembre),"
                . "diciembre = values(diciembre);";                      

           $result2 = mysql_query($sql2);
	$result = mysql_query($sql);
//	if (!$result){ echo "Error al insertar registro ".$filaNum;$errores+=1;
//      echo mysql_error();
//      echo $sql;
//        }
}	
/////////////////////////////////////////////////////////////////////////
if ($errores == 0){
    echo "<h2 style=\"color: #09BCE8;\">Se han importado con éxito $campo registros</h2>";
} elseif ($errores == -1) {
    
}else {
    echo "<h2 style=\"color: red;\">Atención: Se han importado $campo registros y han ocurrido $errores errores al importar.</h2>";
}

//una vez terminado el proceso borramos el 
//archivo que esta en el servidor el bak_
unlink($destino);
}

require 'importar.foot';

?>
