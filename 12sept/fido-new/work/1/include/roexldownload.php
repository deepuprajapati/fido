<?php
include_once('include/actionHeader.php');
include 'phpexl/Classes/PHPExcel/IOFactory.php';
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Asia/Calcutta');


$mdata = new mediadata();
$sql ="SELECT * FROM media WHERE r_o_date >='2016-04-01'";
$search = $mdata->customQuery($sql);


// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number
$rowCount = 1; 
// Iterate through each result from the SQL query in turn
// We fetch each database result row into $row in turn
foreach ($search as $key => $row) {
    // Set cell An to the "name" column from the database (assuming you have a column called name)
    //    where n is the Excel row number (ie cell A1 in the first row)
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['R_O']); 
    // Set cell Bn to the "age" column from the database (assuming you have a column called age)
    //    where n is the Excel row number (ie cell A1 in the first row)
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['r_o_date']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['campaignId']); 
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['publisher']); 
    // Increment the Excel row counter
    $rowCount++; 
} 

// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory
//$objWriter->save('some_excel_file.xlsx'); 

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
?>