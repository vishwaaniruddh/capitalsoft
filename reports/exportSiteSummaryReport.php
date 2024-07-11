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
$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

$sheet->setCellValue('A1', 'Sr No');
$sheet->setCellValue('B1', 'Client');
$sheet->setCellValue('C1', 'SiteName');
$sheet->setCellValue('D1', 'Panel Id');
$sheet->setCellValue('E1', 'ATMID');
$sheet->setCellValue('F1', 'Total Scan');
$sheet->setCellValue('G1', 'Total Online');
$sheet->setCellValue('H1', 'Total Offline');
$sheet->setCellValue('I1', 'Online %');
$sheet->setCellValue('J1', 'Offline %');
$sheet->setCellValue('K1', 'DVRIP');

$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {

    $atmid = $rowarr['ATMID'];
    $Customer = $rowarr['Customer'];
    $dvrip = $rowarr['DVRIP'];
    $panelID = $rowarr['NewPanelID'];
    $siteName = $rowarr['ATMShortName'];
    $total_scans = $rowarr['total_scans'];
    $total_online = $rowarr['total_online'];
    $total_offline = $rowarr['total_offline'];
    $online_percentage = ($total_scans > 0) ? round(($total_online / $total_scans) * 100, 2) : 0;
    $offline_percentage = ($total_scans > 0) ? round(($total_offline / $total_scans) * 100, 2) : 0;
    
    $sheet->setCellValue('A' . $row, $row - 1);
    $sheet->setCellValue('B' . $row, $Customer );
    $sheet->setCellValue('C' . $row, $siteName );
    $sheet->setCellValue('D' . $row, $panelID );
    $sheet->setCellValue('E' . $row, $atmid );
    $sheet->setCellValue('F' . $row, $total_scans );
    $sheet->setCellValue('G' . $row, $total_online );
    $sheet->setCellValue('H' . $row, $total_offline );
    $sheet->setCellValue('I' . $row, $online_percentage );
    $sheet->setCellValue('J' . $row, $offline_percentage );
    $sheet->setCellValue('K' . $row, $dvrip );
    

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
header('Content-Disposition: attachment;filename="Site Summary.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer
$writer = new Xlsx($spreadsheet);

// Save the file to output
$writer->save('php://output');

// Exit script
exit();
