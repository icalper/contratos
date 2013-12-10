<?php

$campos = array('especialidad', 'numContrato', 'descripcion', 'tipoContrato', 'compañia', 'supervisor', 'inicio', 'plazoEjecucion', 'estado');
$nombres_campos = array('Especialidad', 'Numero de Contrato RMIN', 'Descripcion', 'Tipo de contrato', 'Compania', 'Supervisor', 
    'Fecha De Inicio', 'Plazo De Ejecucion', 'Estado Que Guarda');


$registros_consulta = array();
$campos_consulta = array();



for ($i = 0; $i < 100; $i++) {
    array_push($registros_consulta, $_GET["row_$i"]);
    array_push($campos_consulta, $_GET[$i]);
}

$registros_filtrados = array_filter($registros_consulta);
$campos_filtrados = array_filter($campos_consulta);


/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.4, 2010-08-26
 */
//error_reporting(-1);
date_default_timezone_set('America/Santiago');
require_once "../../librerias/PHPExcel.php";

//VARIABLES DE PHP
$objPHPExcel = new PHPExcel();
$Archivo = "Reporte De Compras Con Instalacion" . date("Y-m-d h:m:s");


//DATOS DE LA CONECCION MYSQL
$link = mysql_connect("localhost", "root", "123");
$bd = mysql_select_db("contratos");


// Propiedades de archivo Excel
$objPHPExcel->getProperties()->setCreator("aizensouxx")
        ->setLastModifiedBy("aizensouxx")
        ->setTitle("Reporte De Compras Con Instalacion")
        ->setSubject("Reporte")
        ->setDescription("")
        ->setKeywords("")
        ->setCategory("");


//PROPIEDADES DEL  LA CELDA
$objPHPExcel->getDefaultStyle()->getFont()->setName('Century Gothic');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);


$objPHPExcel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);


for ($i = 4; $i < 40; $i++) {
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
}

$objPHPExcel->getActiveSheet()->getStyle('A1:AN200')
        ->getAlignment()->setWrapText(true);

//CABECERA DE LA CONSULTA
//CABECERA DE LA CONSULTA
$y = 5;
$columna = "B";
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $y, "Numero de Contrato");

foreach ($campos as $key => $valor) {
    if (in_array($valor, $campos_filtrados)){
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("$columna" . $y, $nombres_campos[$key]);
    $columna++;
    }
}

$objPHPExcel->getActiveSheet()
        ->getStyle('A5:AI5')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('B48F6A');

$borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        )
    ),
);

$objPHPExcel->getActiveSheet()
        ->getStyle('A5:AI5')
        ->applyFromArray($borders);


//DETALLE DE LA CONSULTA
if (sizeof($registros_filtrados) == 1) {
    $sql = "SELECT * FROM contratoCompraInstalacion WHERE numContrato = '$registros_filtrados[0]'";
} else {
    $reg_count=1;
    $sql = "SELECT * FROM contratoCompraInstalacion WHERE ";
    foreach ($registros_filtrados as $key => $value) {
        $sql.="numContrato = '$value' ";
        if (sizeof($registros_filtrados) > $reg_count) {
            $sql.="OR ";
        }
        //echo "<br>".sizeof($registros_filtrados)." -> ".$reg_count;
        $reg_count++;
    }
}

$rec = mysql_query($sql);
while ($row = mysql_fetch_array($rec)) {
    $y++;
    //BORDE DE LA CELDA
    $objPHPExcel->setActiveSheetIndex(0)
            ->getStyle('A' . $y . ":AI" . $y)
            ->applyFromArray($borders);

    //MOSTRAMOS LOS VALORES
    
    $columna = "B";
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $y, $row["numContrato"]);
    foreach($campos_filtrados as $key => $valor){
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna . $y, $row[$valor]);
        $columna++;
        }

}

//DATOS DE LA SALIDA DEL EXCEL
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $Archivo . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>