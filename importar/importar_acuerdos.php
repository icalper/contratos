<?php
require '../librerias/sesion.php';
$nivelAcceso = manejadorSesion::USUARIO_ADMIN;
$sesion = new manejadorSesion;

if ($sesion->getPrivilegios() < $nivelAcceso) {    // Codigo para la seguridad por privilegios
    header("Location: ../index.php");
}
?>

<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<h1><?php echo $titulo; ?></h1>
<p>Para importar, seleccione el archivo y a continuación presione el botón "Importar"</p>
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

// Cargando la hoja de cÃ¡lculo
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("bak_".$archivo);
$objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);


//conectamos con la base de datos 
$cn = mysql_connect ("localhost","root","123") or die ("ERROR EN LA CONEXION");
$db = mysql_select_db ("contratos",$cn) or die ("ERROR AL CONECTAR A LA BD");

        // Llenamos el arreglo con los datos  del archivo xlsx
for ($i=4;$i<=100;$i++){
	$_DATOS_EXCEL[$i]['especialidad'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['numContrato'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	
         //se agrega mysql_real_escape_string() para evitar error por datos con ' y que finalize la consulta.
	$_DATOS_EXCEL[$i]['descripcion'] = mysql_escape_string($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
	$_DATOS_EXCEL[$i]['tipoContrato']= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['residente']= $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supPlantas'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supElectrico'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supMecanica'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['supCivil'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
        $_DATOS_EXCEL[$i]['supInstrumento'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['faseUssipa'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['proyecto'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	
       //Convertimos los formatos de fecha para que sea legible para mysql
        $fechaInicio= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue());
        $fechaTermino= $objFecha->ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue());
        
	$_DATOS_EXCEL[$i]['inicio'] = date("Y-m-d", $fechaInicio);
	$_DATOS_EXCEL[$i]['termino'] = date("Y-m-d", $fechaTermino);
	}		
}
//si por algo no cargo el archivo bak_ 
else{echo "Necesitas primero importar el archivo";}
$errores=0;
//recorremos el arreglo multidimensional 
//para ir recuperando los datos obtenidos
//del excel e ir insertandolos en la BD
foreach($_DATOS_EXCEL as $filaNum => $filaContenido){
	$sql = "INSERT INTO acuerdoAdministrativo VALUES (null,'";
        $sql2 = "INSERT INTO contrato VALUES (null,'";
	foreach ($filaContenido as $campoNombre => $campoValor){
                $campoNombre == "termino" ? $sql.= $campoValor."') " : $sql.= $campoValor."','";
		if($campoNombre == "numContrato") {
                    $sql2.= $campoValor."','AA');"; //Se asigna el tipo de contrato 
                }
	}
        
        //Para actualizar los datos reemplaza los repetidos sobreescribe
        $sql.= "ON DUPLICATE KEY UPDATE "
                . "especialidad = values (especialidad),"
                . "descripcion = values (descripcion),"
                . "tipoContrato = values (tipoContrato),"
                . "residente = values (residente),"
                . "supPlantas = values (supPlantas),"
                . "supElectrico = values (supElectrico),"
                . "supMecanica = values (supMecanica),"
                . "supCivil = values (supCivil),"
                . "supInstrumento = values (supInstrumento),"
                . "faseUssipa = values (faseUssipa),"
                . "proyecto = values (proyecto),"
                . "inicio = values (inicio),"
                . "termino = values (termino);";

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
