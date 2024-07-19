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
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
// Check if month and year are provided, otherwise use current month and year

// var_dump($_REQUEST);
if (!isset($_REQUEST['month']) || !isset($_REQUEST['year'])) {
    $currentMonth = date('m');
    $currentYear = date('Y');
} else {
    $currentMonth = $_REQUEST['month'];
    $currentYear = $_REQUEST['year'];
}


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


$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);

$sheet->getStyle('A:AN')->getAlignment()->setHorizontal('center');

foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
 }

 
// Set headers and format
$sheet->setCellValue('A1', 'Sr No')->getStyle('A1')->applyFromArray($headerStyle);
$sheet->setCellValue('B1', 'Client')->getStyle('B1')->applyFromArray($headerStyle);
$sheet->setCellValue('C1', 'Bank')->getStyle('C1')->applyFromArray($headerStyle);
$sheet->setCellValue('D1', 'ATM ID')->getStyle('D1')->applyFromArray($headerStyle);
$sheet->setCellValue('E1', 'STATE')->getStyle('E1')->applyFromArray($headerStyle);
$sheet->setCellValue('F1', 'CITY')->getStyle('F1')->applyFromArray($headerStyle);
$sheet->setCellValue('G1', 'SITE ADDRESS')->getStyle('G1')->applyFromArray($headerStyle);
$currentColumn = 'H'; // Starting column for days
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Set day headers and format
for ($day = 1; $day <= $daysInMonth; $day++) {
    $formattedDate = sprintf('%02d-%s-%02d', $day, date('M', mktime(0, 0, 0, $currentMonth, $day, $currentYear)), substr($currentYear, -2));
    $sheet->setCellValue($currentColumn . '1', $formattedDate)->getStyle($currentColumn . '1')->applyFromArray($headerStyle);
    $currentColumn++;
}

// return ; 


$sheet->setCellValue($currentColumn . '1', 'Ageing')->getStyle($currentColumn . '1')->applyFromArray($headerStyle);
$currentColumn++;
$sheet->setCellValue($currentColumn . '1', 'Remarks')->getStyle($currentColumn . '1')->applyFromArray($headerStyle);

$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {
    $customer = $rowarr['Customer'];
    $bank = $rowarr['Bank'];
    $atmid = $rowarr['ATMID'];
    $state = $rowarr['State'];
    $city = $rowarr['City'];
    $SiteAddress = $rowarr['SiteAddress'];
    $ip = $rowarr['ip'];

    $sheet->setCellValue('A' . $row, $row - 1);
    $sheet->setCellValue('B' . $row, $customer);
    $sheet->setCellValue('C' . $row, $bank);
    $sheet->setCellValue('D' . $row, $atmid);
    $sheet->setCellValue('E' . $row, $state);
    $sheet->setCellValue('F' . $row, $city);
    $sheet->setCellValue('G' . $row, $SiteAddress);

    $currentColumn = 'H'; // Reset column for days
    for ($day = 1; $day <= $daysInMonth; $day++) {
        // Construct date in YYYY-MM-DD format
        $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
        // Query to fetch status
        $statusQuery = "SELECT status FROM panel_history WHERE ip = '$ip' AND DATE(udate) = '$date'";
        $statusResult = mysqli_query($con, $statusQuery);
        $status = '1'; // Default status
        if (mysqli_num_rows($statusResult) > 0) {
            $statusRow = mysqli_fetch_assoc($statusResult);
            $status = $statusRow['status'];
        }
        $sheet->setCellValue($currentColumn . $row, ($status == '0' ? 'UP' : 'DOWN'));
        $currentColumn++;
    }

    // Ageing and Remarks columns (assuming these are placeholders)
    $sheet->setCellValue($currentColumn . $row, '');
    $currentColumn++;
    $sheet->setCellValue($currentColumn . $row, '');

    $row++;
}

// Set auto size for columns
foreach ($sheet->getColumnIterator() as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
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

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Health Check Up Report.xlsx"');
header('Cache-Control: max-age=0');

// Instantiate PhpSpreadsheet Writer
$writer = new Xlsx($spreadsheet);

// Save the file to output
$writer->save('php://output');

// Exit script
exit();
?>