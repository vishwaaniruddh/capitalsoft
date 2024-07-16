<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

include ('../config.php');
require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;


$statement = $_REQUEST['exportsql'];
$sqry = mysqli_query($con, $statement);
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$headerStyle = [
    'fill' => [
        'fillType' => Style\Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF4287f5'],
    ],
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

$sheet->setCellValue('A1', 'Sr No');
$sheet->setCellValue('B1', 'Client');
$sheet->setCellValue('C1', 'Region');
$sheet->setCellValue('D1', 'ATMID');
$sheet->setCellValue('E1', 'Site Name');
$sheet->setCellValue('F1', 'Address');
$sheet->setCellValue('G1', 'Open Date');
$sheet->setCellValue('H1', 'Open Time');
$sheet->setCellValue('I1', 'Close Date');
$sheet->setCellValue('J1', 'Close Time');

$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {
    $Customer = $rowarr['Customer'];
    $atmid = $rowarr['ATMID'];
    $zone = $rowarr['Zone'];
    $ATMShortName = $rowarr['ATMShortName'];
    $SiteAddress = $rowarr['SiteAddress'];   
    
    $receivedDatetime = $rowarr['receivedtime'];
    $receivedDate = date('Y-m-d', strtotime($receivedDatetime)); // Format 'Y-m-d'
    $receivedTime = date('H:i:s', strtotime($receivedDatetime)); // Format 'H:i:s'

    $closedDateTime = $rowarr['closedtime'];
    $closedDate = date('Y-m-d', strtotime($closedDateTime)); // Format 'Y-m-d'
    $closedTime = date('H:i:s', strtotime($closedDateTime)); // Format 'H:i:s'

    $sheet->setCellValue('A' . $row, $row - 1);
    $sheet->setCellValue('B' . $row, $Customer );
    $sheet->setCellValue('C' . $row, $zone );
    $sheet->setCellValue('D' . $row, $atmid );
    $sheet->setCellValue('E' . $row, $ATMShortName );
    $sheet->setCellValue('F' . $row, $SiteAddress );
    $sheet->setCellValue('G' . $row, $receivedDate );
    $sheet->setCellValue('H' . $row, $receivedTime );
    $sheet->setCellValue('I' . $row, $closedDate );
    $sheet->setCellValue('J' . $row, $closedTime );



    $row++; 

}






// Apply borders to all cells
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

// // Set auto width for all columns
// foreach (range('A', $highestColumn) as $column) {
//     $sheet->getColumnDimension($column)->setAutoSize(true);
// }


// return ; 
// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Tempreture Report.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer
$writer = new Xlsx($spreadsheet);

// Save the file to output
$writer->save('php://output');

// Exit script
exit();
