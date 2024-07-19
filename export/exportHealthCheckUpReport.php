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

$sheet->getStyle('A:AK')->getAlignment()->setHorizontal('center');

foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
 }

// Example usage of setCellValue
$sheet->setCellValue('A1', 'Sr No');
$sheet->setCellValue('B1', 'ATM ID');
$sheet->setCellValue('C1', 'ATM ID 2');
$sheet->setCellValue('D1', 'State');
$sheet->setCellValue('E1', 'City');
$sheet->setCellValue('F1', 'Loc. Name');
$sheet->setCellValue('G1', 'Main Panel functional (Y/N)');
$sheet->setCellValue('H1', 'DVR (W / NW)');
$sheet->setCellValue('I1', 'Hard Disk status(W/NW)');
$sheet->setCellValue('J1', 'Footage Start DateTime');
$sheet->setCellValue('K1', 'Footage Stop DateTime');
$sheet->setCellValue('L1', 'Footage available in days');
$sheet->setCellValue('M1', 'ATM Lobby Camera (W/ NW)');
$sheet->setCellValue('N1', 'Back Room Camera (W/ NW)');
$sheet->setCellValue('O1', 'Out Side Camera (W/ NW)');
$sheet->setCellValue('P1', 'All Sensors (W/ NW)');
$sheet->setCellValue('Q1', 'Panic Alarm Switch (W/NW)');
$sheet->setCellValue('R1', 'Hooter (W/NW)');
$sheet->setCellValue('S1', 'Two-way Communicaton (W/NW)');
$sheet->setCellValue('T1', 'Smoke detector (w/NW)');
$sheet->setCellValue('U1', 'Glass Break Sensor (W/NW)');
$sheet->setCellValue('V1', 'Backroom Door Key pad (W/NW)');
$sheet->setCellValue('W1', 'ATM Removal Sensor (W/NW)');
$sheet->setCellValue('X1', 'Vibration Sensor(W/NW)');
$sheet->setCellValue('Y1', 'Hood Sensor');
$sheet->setCellValue('Z1', 'Chest door open sensor(W/NW)');
$sheet->setCellValue('AA1', 'ATM Thermal Sensor(W/NW)');
$sheet->setCellValue('AB1', 'PIR Sensor(Pet Immune)(W/NW)');
$sheet->setCellValue('AC1', 'Speaker Mic Removal Sensor(W/NW)');
$sheet->setCellValue('AD1', 'AC removal (W/NW)');
$sheet->setCellValue('AE1', 'Lobby temperature sensor');
$sheet->setCellValue('AF1', 'EM Lock(W/NW)');
$sheet->setCellValue('AG1', 'Ageing');
$sheet->setCellValue('AH1', 'Site Live Date');
$sheet->setCellValue('AI1', '120 Days footage not available Remarks');
$sheet->setCellValue('AJ1', 'Vendor');
$sheet->setCellValue('AK1', 'Bank');

$row = 2;
while ($rowarr = mysqli_fetch_array($sqry)) {
   

    
    $atmid = $rowarr['ATMID'];
    $state = $rowarr['State'];
    $city = $rowarr['City'];
    $recordingFrom = $rowarr['Recording From'];
    $recordingTo = $rowarr['Recording To'];
    $bank = $rowarr['Bank'];
    $live_date = $rowarr['live_date'];

    $datetime1 = new DateTime($recordingFrom);
    $datetime2 = new DateTime($recordingTo);

    // Calculate the difference between two DateTime objects
    $difference = $datetime1->diff($datetime2);
    $days = $difference->days;
    $hours = $difference->h;
    $minutes = $difference->i;

    // Build the formatted string
    if ($days > 0) {
        $formattedDifference = "$days days ";
    }
    if ($hours > 0) {
        $formattedDifference .= "$hours hours ";
    }
    if ($minutes > 0) {
        $formattedDifference .= "$minutes minutes";
    }

    $SiteAddress = $rowarr['SiteAddress'];
    $ip = $rowarr['IP Address'];
    $ping_status = $rowarr['ping_status'];
    $hdd_status = $rowarr['HDD Status'];
    $recording_from = $rowarr['Recording From'];
    $recording_to = $rowarr['Recording To'];

    // Calculate day difference 
    $from_timestamp = strtotime($recording_from);
    $to_timestamp = strtotime($recording_to);
    $difference_in_seconds = $to_timestamp - $from_timestamp;
    $difference_in_days = $difference_in_seconds / 86400;
    $difference_in_days = round($difference_in_days);
    // End

    $cam1 = $rowarr['cam1'];
    $cam2 = $rowarr['cam2'];
    $cam3 = $rowarr['cam3'];


    // Get Panel Data
    $panelsql = mysqli_query($con, "select * from panel_health where ip='" . $ip . "'");
    $panelsql_result = mysqli_fetch_assoc($panelsql);

    // var_dump($panelsql_result);
    $panel_status = $panelsql_result['status'];
    $panelMake = $panelsql_result['panelName'];

    $sheet->setCellValue('A' . $row, $row - 1); // Assuming $row is your current row index
    $sheet->setCellValue('B' . $row, $atmid);
    $sheet->setCellValue('C' . $row, ''); // Placeholder for ATM ID 2
    $sheet->setCellValue('D' . $row, $state);
    $sheet->setCellValue('E' . $row, $city);
    $sheet->setCellValue('F' . $row, ''); // Placeholder for Loc. Name (SiteAddress)
    $sheet->setCellValue('G' . $row, ($panel_status == 0 ? 'Yes' : 'No')); // Main Panel functional (Y/N)
    $sheet->setCellValue('H' . $row, ($ping_status == 'Online' ? 'Working' : 'Not Working')); // DVR (W / NW)
    $sheet->setCellValue('I' . $row, $hdd_status); // Hard Disk status(W/NW)
    $sheet->setCellValue('J' . $row, $recording_from); // Footage Start DateTime
    $sheet->setCellValue('K' . $row, $recording_to); // Footage Stop DateTime
    $sheet->setCellValue('L' . $row, $difference_in_days); // Footage available in days
    $sheet->setCellValue('M' . $row, ucwords($cam1)); // ATM Lobby Camera (W/ NW)
    $sheet->setCellValue('N' . $row, ucwords($cam2)); // Back Room Camera (W/ NW)
    $sheet->setCellValue('O' . $row, ucwords($cam3)); // Out Side Camera (W/ NW)

    // Additional columns with logic
    $sheet->setCellValue('P' . $row, 'Working'); // All Sensors (W/ NW)
    $sheet->setCellValue('Q' . $row, 'Working'); // Panic Alarm Switch (W/NW)

    $sheet->setCellValue('R' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Hooter')) == 0 ? 'Working' : 'Not Working'); // Hooter (W/NW)
    $sheet->setCellValue('S' . $row, 'Working'); // Two-way Communication (W/NW)

    $sheet->setCellValue('T' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Smoke S')) == 0 ? 'Working' : 'Not Working'); // Smoke detector (W/NW)
    $sheet->setCellValue('U' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'glass break')) == 0 ? 'Working' : 'Not Working'); // Glass Break Sensor (W/NW)
    $sheet->setCellValue('V' . $row, 'Working'); // Backroom Door Key pad (W/NW) - Placeholder
    $sheet->setCellValue('W' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM removal')) == 0 ? 'Working' : 'Not Working'); // ATM Removal Sensor (W/NW)
    $sheet->setCellValue('X' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'vibration')) == 0 ? 'Working' : 'Not Working'); // Vibration Sensor(W/NW)
    $sheet->setCellValue('Y' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Hood')) == 0 ? 'Working' : 'Not Working'); // Hood Sensor
    $sheet->setCellValue('Z' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Chest Door')) == 0 ? 'Working' : 'Not Working'); // Chest door open sensor(W/NW)
    $sheet->setCellValue('AA' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Thermal')) == 0 ? 'Working' : 'Not Working'); // ATM Thermal Sensor(W/NW)
    $sheet->setCellValue('AB' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'motion')) == 0 ? 'Working' : 'Not Working'); // PIR Sensor(Pet Immune)(W/NW)
    $sheet->setCellValue('AC' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM SPK & MIC Removal')) == 0 ? 'Working' : 'Not Working'); // Speaker Mic Removal Sensor(W/NW)
    $sheet->setCellValue('AD' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM AC')) == 0 ? 'Working' : 'Not Working'); // AC removal (W/NW)
    $sheet->setCellValue('AE' . $row, getPanelZoneStatus($ip, getPanelZone($panelMake, 'Temperature Sensor')) == 0 ? 'Working' : 'Not Working'); // Lobby temperature sensor
    $sheet->setCellValue('AF' . $row, ''); // EM Lock(W/NW)
    $sheet->setCellValue('AG' . $row, ''); // Ageing - Placeholder
    $sheet->setCellValue('AH' . $row, convertDateFormat($live_date)); // Site Live Date
    $sheet->setCellValue('AI' . $row, '_'); // 120 Days footage not available Remarks
    $sheet->setCellValue('AJ' . $row, 'CAPITALSOFTS'); // Vendor
    $sheet->setCellValue('AK' . $row, $bank); // Bank
    

   


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

// // Set auto width for all columns
// foreach (range('A', $highestColumn) as $column) {
//     $sheet->getColumnDimension($column)->setAutoSize(true);
// }


// return ; 
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
