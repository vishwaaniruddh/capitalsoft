<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

include ('../config.php');
require '../vendor/autoload.php';

function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 ||
        (substr($haystack, -$length) === $needle);
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;


$statement = $_REQUEST['exportsql'];
$sqry = mysqli_query($con, $statement);

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);





// var_dump($_REQUEST) ; 


// return ; 

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
// $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);

$sheet->getStyle('A:T')->getAlignment()->setHorizontal('center');

foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
 }
 


$sheet->setCellValue('A1', 'ATMID');
$sheet->setCellValue('B1', 'Bank');
$sheet->setCellValue('C1', 'Customer');
$sheet->setCellValue('D1', 'City');
$sheet->setCellValue('E1', 'State');
$sheet->setCellValue('F1', 'Zone');
$sheet->setCellValue('G1', 'SiteAddress');
$sheet->setCellValue('H1', 'Project');
$sheet->setCellValue('I1', 'IP Address');
$sheet->setCellValue('J1', 'DVR Name');
$sheet->setCellValue('K1', 'Network Status');
$sheet->setCellValue('L1', 'Latency');
$sheet->setCellValue('M1', 'DVR Status');
$sheet->setCellValue('N1', 'Current Date');
$sheet->setCellValue('O1', 'DVR Time');
$sheet->setCellValue('P1', 'Time Difference');
$sheet->setCellValue('Q1', 'cam1');
$sheet->setCellValue('R1', 'cam2');
$sheet->setCellValue('S1', 'cam3');
$sheet->setCellValue('T1', 'cam4');
// $sheet->setCellValue('U1', 'HDD Status');
// $sheet->setCellValue('V1', 'Recording From');
// $sheet->setCellValue('W1', 'Recording To');
// $sheet->setCellValue('X1', 'Recording To Status');


$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {

    $sheet->setCellValue('A' . $row, $rowarr['ATMID']);
    $sheet->setCellValue('B' . $row, $rowarr['Bank']);
    $sheet->setCellValue('C' . $row, $rowarr['Customer']);
    $sheet->setCellValue('D' . $row, $rowarr['City']);
    $sheet->setCellValue('E' . $row, $rowarr['State']);
    $sheet->setCellValue('F' . $row, $rowarr['Zone']);
    $sheet->setCellValue('G' . $row, $rowarr['SiteAddress']);
    $sheet->setCellValue('H' . $row, $rowarr['Project']);
    $sheet->setCellValue('I' . $row, $rowarr['IP Address']);
    $sheet->setCellValue('J' . $row, $rowarr['DVR Name']);
    $sheet->setCellValue('K' . $row, $rowarr['Network Status']);
    $sheet->setCellValue('L' . $row, $rowarr['Latency']);
    $sheet->setCellValue('M' . $row, $rowarr['DVR Status']);
    $sheet->setCellValue('N' . $row, $rowarr['Current Date']);
    $sheet->setCellValue('O' . $row, $rowarr['DVR Time']);
    $sheet->setCellValue('P' . $row, $rowarr['Time Difference']);
    $sheet->setCellValue('Q' . $row, $rowarr['cam1']);
    $sheet->setCellValue('R' . $row, $rowarr['cam2']);
    $sheet->setCellValue('S' . $row, $rowarr['cam3']);
    $sheet->setCellValue('T' . $row, $rowarr['cam4']);
    // $sheet->setCellValue('U' . $row, $rowarr['HDD Status']);
    // $sheet->setCellValue('V' . $row, $rowarr['Recording From']);
    // $sheet->setCellValue('W' . $row, $rowarr['Recording To']);
    // $sheet->setCellValue('X' . $row, $rowarr['Recording To Status']);

    $row++; 

}


foreach ($sheet->getColumnIterator() as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
 }

 
// foreach (range('A', $sheet->getHighestColumn()) as $col) {
//    $sheet->getColumnDimension($col)->setAutoSize(true);
// }



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


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exported_data.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer
$writer = new Xlsx($spreadsheet);

// Save the file to output
$writer->save('php://output');

// Exit script
exit();
