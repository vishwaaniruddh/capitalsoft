<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

// Include necessary files and set error reporting
include('../config.php'); // Assuming this file contains database connection details
require '../vendor/autoload.php'; // Make sure this path is correct based on your project structure

// Set error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

// Get the SQL statement from the request
$statement = $_REQUEST['exportsql']; // Make sure this variable is sanitized and contains a valid SQL query
$sqry = mysqli_query($con, $statement); // Execute the query using mysqli (assuming $con is your database connection)

// Create a new PhpSpreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

// Define styles for header row
$headerStyle = [
    'font' => [
        'size' => 10,
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'alignment' => [
        'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => Style\Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF4287f5'],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Style\Border::BORDER_THIN,
        ],
    ],
];

// Set auto size for columns A and B
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);

// Center align all columns A to J
$sheet->getStyle('A:L')->getAlignment()->setHorizontal('center');

foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
 }


// Set headers for each column
$sheet->setCellValue('A1', 'Sr No');
$sheet->setCellValue('B1', 'ATM ID');
$sheet->setCellValue('C1', 'Customer');
$sheet->setCellValue('D1', 'State');
$sheet->setCellValue('E1', 'City');
$sheet->setCellValue('F1', 'Bank');
$sheet->setCellValue('G1', 'Panel IP');
$sheet->setCellValue('H1', 'Panel Name');
$sheet->setCellValue('I1', 'Panel Status');
$sheet->setCellValue('J1', 'Address');
$sheet->setCellValue('K1', 'Last Scan');
$sheet->setCellValue('L1', 'Ageing');

// Populate data from database query
$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {
    // Determine panel status based on 'status' field

    $ip = $rowarr['ip'];

    $lastHistoryDate = '-';
    $difference = '-' ;
  
   

  $historysql = mysqli_query($con, "
    SELECT *
    FROM panel_history 
    WHERE ip = '" . $ip . "'
    and status=0
    ORDER BY udate DESC LIMIT 1 ");

    if($historysqlResult = mysqli_fetch_assoc($historysql)){

      $lastHistoryDate = $historysqlResult['udate']; 

      $currentTimestamp = strtotime($datetime);
      $lastHistoryTimestamp = strtotime($lastHistoryDate);
      $differenceInSeconds = $currentTimestamp - $lastHistoryTimestamp;

      $days = floor($differenceInSeconds / (60 * 60 * 24)); // Calculate days
      $hours = floor(($differenceInSeconds % (60 * 60 * 24)) / (60 * 60)); // Calculate hours
      $minutes = floor(($differenceInSeconds % (60 * 60)) / 60); // Calculate minutes
    
      $difference = $days . " days, " . $hours . " hours, " . $minutes . " minutes";


    }




    $panelStatus = ($rowarr['status'] == 0) ? 'Active' : 'Inactive';

    // Populate each cell with corresponding data
    $sheet->setCellValue('A' . $row, $row - 1); // Assuming $row is your current row index
    $sheet->setCellValue('B' . $row, $rowarr[68]); // Adjust this index as per your database structure
    $sheet->setCellValue('C' . $row, $rowarr['Customer']);
    $sheet->setCellValue('D' . $row, $rowarr['State']);
    $sheet->setCellValue('E' . $row, $rowarr['City']);
    $sheet->setCellValue('F' . $row, $rowarr['Bank']);
    $sheet->setCellValue('G' . $row, $rowarr['PanelIP']);
    $sheet->setCellValue('H' . $row, $rowarr['panelName']);
    $sheet->setCellValue('I' . $row, $panelStatus);
    $sheet->setCellValue('J' . $row, $rowarr['SiteAddress']);
    $sheet->setCellValue('K' . $row, convertDateTimeFormat($lastHistoryDate,$outputFormat = "d-m-Y H:i:s"));
    $sheet->setCellValue('L' . $row, $difference);
    $row++;
}

// Apply styles to all cells with content
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Style\Border::BORDER_THIN,
        ],
    ],
];
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
$sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray($styleArray);

// Set headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Panel HeartBeat Report.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer and save the file to output
$writer = new Xlsx($spreadsheet);
try {
    $writer->save('php://output');
} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    echo 'Error saving file: ',  $e->getMessage(), "\n";
    exit();
}

// Exit script
exit();
?>
