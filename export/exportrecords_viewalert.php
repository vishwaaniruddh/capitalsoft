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
// $statement .= " LIMIT 20";
$sqry = mysqli_query($con, $statement);

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);


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
// $sheet->getStyle('A1:S1')->applyFromArray($headerStyle);

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);

$sheet->getStyle('A:S')->getAlignment()->setHorizontal('center');

foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
 }

$sheet->setCellValue('A1', 'Sr No');
$sheet->setCellValue('B1', 'Client');
$sheet->setCellValue('C1', 'ATM ID');
$sheet->setCellValue('D1', 'Panel ID');
$sheet->setCellValue('E1', 'Location');
$sheet->setCellValue('F1', 'Address');

$sheet->setCellValue('G1', 'State');
$sheet->setCellValue('H1', 'City');

$sheet->setCellValue('I1', 'Branch Code');
$sheet->setCellValue('J1', 'Alert Type');
$sheet->setCellValue('K1', 'Ticket DateTime');
$sheet->setCellValue('L1', 'Ticket Receive DateTime');
$sheet->setCellValue('M1', 'Closed Datetime');
$sheet->setCellValue('N1', 'Duration(HH:MM)');

$sheet->setCellValue('O1', 'DVR IP');
$sheet->setCellValue('P1', 'Alarm Status');

$sheet->setCellValue('Q1', 'Remark');
$sheet->setCellValue('R1', 'Ticket ID');
$sheet->setCellValue('S1', 'Closed By User');
// $sheet->setCellValue('T1', 'Closed Date');
// $sheet->setCellValue('U1', 'Remark');





$sheet->getStyle('Q')->getAlignment()->setWrapText(true);
// $sqry = mysqli_query($conn, $qry);
// $num = mysqli_num_rows($sqry);

$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {

    $ct = $rowarr["City"] . "," . $rowarr["State"];
    $panelmake = $rowarr["Panel_make"];
    $dtconvt = $rowarr["receivedtime"];
    $timestamp = strtotime($dtconvt);
    $newDate = date('d-F-Y', $timestamp);


    $alram_sql = mysqli_query($con, "select * from $panelmake where (Zone='" . $rowarr["zone"] . "' and 
    SCODE='" . $rowarr['alarm'] . "')");
    $result1 = mysqli_fetch_assoc($alram_sql);

    if (endsWith($rowarr["alarm"], "R")) {
        $ds = $result1["SensorName"] . ' Restoral';
    } else {
        $ds = $result1["SensorName"];
    }


    $receivedTime = strtotime($rowarr["receivedtime"]);
    $closedTime = strtotime($rowarr["closedtime"]);
    
    $durationFormatted = '-';
    if ($receivedTime !== false && $closedTime !== false) {
        $durationSeconds = $closedTime - $receivedTime;
        $hours = floor($durationSeconds / 3600); 
        $minutes = floor(($durationSeconds % 3600) / 60); 
        $durationFormatted = sprintf('%02d:%02d', $hours, $minutes);    
    } 



    $sheet->setCellValue('A' . $row, $row - 1);
    $sheet->setCellValue('B' . $row, $rowarr["Customer"]);
    $sheet->setCellValue('C' . $row, $rowarr["ATMID"]);
    $sheet->setCellValue('D' . $row, $rowarr["panelid"]);

    $sheet->setCellValue('E' . $row, $rowarr["ATMShortName"]);
    $sheet->setCellValue('F' . $row, $rowarr["SiteAddress"]);
    $sheet->setCellValue('G' . $row, $rowarr["State"]);
    $sheet->setCellValue('H' . $row, $rowarr["City"]);

    $sheet->setCellValue('I' . $row, $rowarr["ATMShortName"]);    // branch code 
    $sheet->setCellValue('J' . $row, $ds);
    $sheet->setCellValue('K' . $row, $rowarr["createtime"]);
    $sheet->setCellValue('L' . $row, $rowarr["receivedtime"]);

    $sheet->setCellValue('M' . $row, $rowarr["closedtime"]);
    $sheet->setCellValue('N' . $row, $durationFormatted);
    $sheet->setCellValue('O' . $row, $rowarr["DVRIP"]);

    if (endsWith($rowarr["alarm"], "R")) {
        $re = 'Non-Reactive';
    } else {
        $re = 'Reactive';
    }

    $sheet->setCellValue('P' . $row, $re);
    

    $cm = $rowarr["closedtime"] . '*' . $rowarr["comment"] ;
    $sheet->setCellValue('Q' . $row, $cm);

    $sheet->setCellValue('R' . $row, $rowarr['id']);
    $sheet->setCellValue('S' . $row, $rowarr["closedBy"]);

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


// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exported_data.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer
$writer = new Xlsx($spreadsheet);

// Save the file to output
$writer->save('php://output');

// Exit script
exit();
