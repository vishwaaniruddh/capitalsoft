<?php
// Include necessary files and setup
include ('../config.php');
require '../vendor/autoload.php';



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

$statement = $_REQUEST['exportsql'];
$sqry = mysqli_query($con, $statement);

// Create new Spreadsheet object
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
$sheet->getStyle('A1:BR1')->applyFromArray($headerStyle);

    $sheet->setCellValue('A1', 'Sr No');
    $sheet->setCellValue('B1', 'Customer');
    $sheet->setCellValue('C1', 'Bank');
    $sheet->setCellValue('D1', 'Tracker No');
    $sheet->setCellValue('E1', 'ATMID');
    $sheet->setCellValue('F1', 'OLD ATMID');
    $sheet->setCellValue('G1', 'ATMID_2');
    $sheet->setCellValue('H1', 'ATMID_3');
    $sheet->setCellValue('I1', 'ATMShortName');
    $sheet->setCellValue('J1', 'SiteAddress');
    $sheet->setCellValue('K1', 'City');
    $sheet->setCellValue('L1', 'State');
    $sheet->setCellValue('M1', 'Zone');
    $sheet->setCellValue('N1', 'CTS_LocalBranch');
    $sheet->setCellValue('O1', 'Panel_Make');
    $sheet->setCellValue('P1', 'OldPanelID');
    $sheet->setCellValue('Q1', 'NewPanelID');
    $sheet->setCellValue('R1', 'PanelIP');
    $sheet->setCellValue('S1', 'DVRIP');
    $sheet->setCellValue('T1', 'DVRName');
    $sheet->setCellValue('U1', 'UserName');
    $sheet->setCellValue('V1', 'Password');
    $sheet->setCellValue('W1', 'Live');
    $sheet->setCellValue('X1', 'Live Date');
    $sheet->setCellValue('Y1', 'Installation Engineer Name');
    $sheet->setCellValue('Z1', 'CTS Engineer Name');
    $sheet->setCellValue('AA1', 'CTS Engineer Number');
    $sheet->setCellValue('AB1', 'CSSBM');
    $sheet->setCellValue('AC1', 'CSSBMNumber');
    $sheet->setCellValue('AD1', 'CSS BM Email');
    $sheet->setCellValue('AE1', 'BackofficerName');
    $sheet->setCellValue('AF1', 'BackofficerNumber');
    $sheet->setCellValue('AG1', 'HeadSupervisorName');
    $sheet->setCellValue('AH1', 'HeadSupervisorNumber');
    $sheet->setCellValue('AI1', 'SupervisorName');
    $sheet->setCellValue('AJ1', 'Supervisornumber');
    $sheet->setCellValue('AK1', 'RA Name');
    $sheet->setCellValue('AL1', 'RA Number');
    $sheet->setCellValue('AM1', 'Police Number');
    $sheet->setCellValue('AN1', 'Police Station');
    $sheet->setCellValue('AO1', 'Fire Station Name');
    $sheet->setCellValue('AP1', 'Fire Station number');
    $sheet->setCellValue('AQ1', 'Atm Officer Name');
    $sheet->setCellValue('AR1', 'Atm Officer Number');
    $sheet->setCellValue('AS1', 'ATM Officer Email');
    $sheet->setCellValue('AT1', 'Zonal Co-ordinator Name');
    $sheet->setCellValue('AU1', 'Zonal Co-ordinator Number');
    $sheet->setCellValue('AV1', 'Zonal Co-ordinator Email');
    $sheet->setCellValue('AW1', 'Bank Officer Email ID');
    $sheet->setCellValue('AX1', 'CO Owner Name');
    $sheet->setCellValue('AY1', 'CO Owner Number');
    $sheet->setCellValue('AZ1', 'CO Owner Email ID');
    $sheet->setCellValue('BA1', 'Zonal Name');
    $sheet->setCellValue('BB1', 'Zonal Number');
    $sheet->setCellValue('BC1', 'Zonal Email ID');
    $sheet->setCellValue('BD1', 'Installation date');
    $sheet->setCellValue('BE1', 'Site Add By');
    $sheet->setCellValue('BF1', 'Site Edit By');
    $sheet->setCellValue('BG1', 'GSM Number');
    $sheet->setCellValue('BH1', 'DVR_Model_num');
    $sheet->setCellValue('BI1', 'Router_Model_num');
    $sheet->setCellValue('BJ1', 'Remarks');
    $sheet->setCellValue('BK1', 'Router Id');
    $sheet->setCellValue('BL1', 'SIM Number');
    $sheet->setCellValue('BM1', 'SIM Owner');
    $sheet->setCellValue('BN1', 'Router Brand');
    $sheet->setCellValue('BO1', 'Camera IP');
    $sheet->setCellValue('BP1', 'Port');
    $sheet->setCellValue('BQ1', 'Ip Camera');
    $sheet->setCellValue('BR1', 'Bank Officer Name');
    $sheet->setCellValue('BS1', 'Bank Officer Number');





    $row = 2;
    while ($rowarr = mysqli_fetch_array($sqry)) {



        $excelCount = 0;
        $id = $rowarr['SN'];
        $sql1 = "select * from esurvsites where ATM_ID='" . $rowarr["ATMID"] . "'";

        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);



        $site_details = mysqli_query($conn, "select * from sites_details where site_id ='" . $id . "' and project=1");

        if ($site_details_result = mysqli_fetch_assoc($site_details)) {

            $router_id = $site_details_result['router_id'];
            $simnumber = $site_details_result['simnumber'];
            $simowner = $site_details_result['simowner'];
            $router_brand = $site_details_result['routebrand'];
        } else {
            $router_id = '';
            $simnumber = '';
            $simowner = '';
            $router_brand = '';
        }

        $data = '';
        $camera_ip = '';
        $data = get_sites_info($rowarr["ATMID"], 'cam_ip');
        foreach ($data as $key => $value) {
            $camera_ip .= $value . ",";
        }

        $data = '';
        $port = '';
        $data = get_sites_info($rowarr["ATMID"], 'port');
        foreach ($data as $key => $value) {
            $port .= $value . ",";
        }

        $data = '';
        $cam_name = '';
        $data = get_sites_info($rowarr["ATMID"], 'cam_name');
        foreach ($data as $key => $value) {
            $cam_name .= $value . ",";
        }


        $sheet->setCellValue('A' . $row, $row - 1);
        $sheet->setCellValue('B' . $row, $rowarr['Customer']);
        $sheet->setCellValue('C' . $row, $rowarr['Bank']);
        $sheet->setCellValue('D' . $row, $rowarr['TrackerNo']);
        $sheet->setCellValue('E' . $row, $rowarr['ATMID']);
        $sheet->setCellValue('F' . $row, $rowarr['old_atmid']);
        $sheet->setCellValue('G' . $row, $rowarr['ATMID_2']);
        $sheet->setCellValue('H' . $row, $rowarr['ATMID_3']);
        $sheet->setCellValue('I' . $row, $rowarr['ATMShortName']);
        $sheet->setCellValue('J' . $row, $rowarr['SiteAddress']);
        $sheet->setCellValue('K' . $row, $rowarr['City']);
        $sheet->setCellValue('L' . $row, $rowarr['State']);
        $sheet->setCellValue('M' . $row, $rowarr['Zone']);
        $sheet->setCellValue('N' . $row, $row1['CTS_LocalBranch']);
        $sheet->setCellValue('O' . $row, $rowarr['Panel_Make']);
        $sheet->setCellValue('P' . $row, $rowarr['OldPanelID']);
        $sheet->setCellValue('Q' . $row, $rowarr['NewPanelID']);
        $sheet->setCellValue('R' . $row, $rowarr['PanelIP']);
        $sheet->setCellValue('S' . $row, $rowarr['DVRIP']);
        $sheet->setCellValue('T' . $row, $rowarr['DVRName']);
        $sheet->setCellValue('U' . $row, $rowarr['UserName']);
        $sheet->setCellValue('V' . $row, $rowarr['Password']);
        $sheet->setCellValue('W' . $row, $rowarr['live']);
        $sheet->setCellValue('X' . $row, $rowarr['live_date']);
        $sheet->setCellValue('Y' . $row, $rowarr['eng_name']);
        $sheet->setCellValue('Z' . $row, $row1['CTS_Engineer_Name']);
        $sheet->setCellValue('AA' . $row, $row1['CTS_Engineer_Number']);
        $sheet->setCellValue('AB' . $row, $row1['CSSBM']);
        $sheet->setCellValue('AC' . $row, $row1['CSSBMNumber']);
        $sheet->setCellValue('AD' . $row, $row1['CSSBM_Email']);
        $sheet->setCellValue('AE' . $row, $row1['BackofficerName']);
        $sheet->setCellValue('AF' . $row, $row1['BackofficerNumber']);
        $sheet->setCellValue('AG' . $row, $row1['HeadSupervisorName']);
        $sheet->setCellValue('AH' . $row, $row1['HeadSupervisorNumber']);
        $sheet->setCellValue('AI' . $row, $row1['SupervisorName']);
        $sheet->setCellValue('AJ' . $row, $row1['Supervisornumber']);
        $sheet->setCellValue('AK' . $row, $row1['RA_QRT_NAME']);
        $sheet->setCellValue('AL' . $row, $row1['RA_QRT_NUMBER']);
        $sheet->setCellValue('AM' . $row, $row1['Policestation']);
        $sheet->setCellValue('AN' . $row, $row1['Polstnname']);
        $sheet->setCellValue('AO' . $row, $row1['firestation_name']);
        $sheet->setCellValue('AP' . $row, $row1['firestation_number']);
        $sheet->setCellValue('AQ' . $row, $row1['atm_officer_name']);
        $sheet->setCellValue('AR' . $row, $row1['atm_officer_number']);
        $sheet->setCellValue('AS' . $row, $row1['atm_officer_email']);
        $sheet->setCellValue('AT' . $row, $row1['zonal_co_ordinator_name']);
        $sheet->setCellValue('AU' . $row, $row1['zonal_co_ordinator_number']);
        $sheet->setCellValue('AV' . $row, $row1['zonal_co_ordinator_email']);
        $sheet->setCellValue('AW' . $row, $row1['Bank_Officer_Email_ID']);
        $sheet->setCellValue('AX' . $row, $row1['CO_Owner_Name']);
        $sheet->setCellValue('AY' . $row, $row1['CO_Owner_Number']);
        $sheet->setCellValue('AZ' . $row, $row1['CO_Owner_Email_ID']);
        $sheet->setCellValue('BA' . $row, $row1['Zonal_Name']);
        $sheet->setCellValue('BB' . $row, $row1['Zonal_Number']);
        $sheet->setCellValue('BC' . $row, $row1['Zonal_Email_ID']);
        $sheet->setCellValue('BD' . $row, $rowarr['current_dt']);
        $sheet->setCellValue('BE' . $row, $rowarr['addedby']);
        $sheet->setCellValue('BF' . $row, $rowarr['editby']);
        $sheet->setCellValue('BG' . $row, $rowarr['TwoWayNumber']);
        $sheet->setCellValue('BH' . $row, $rowarr['DVR_Model_num']);
        $sheet->setCellValue('BI' . $row, $rowarr['Router_Model_num']);
        $sheet->setCellValue('BJ' . $row, $rowarr['site_remark']);
        $sheet->setCellValue('BK' . $row, $router_id);
        $sheet->setCellValue('BL' . $row, getsiminfo($rowarr['ATMID'], 'simnnumber'));
        $sheet->setCellValue('BM' . $row, getsiminfo($rowarr['ATMID'], 'simowner'));
        $sheet->setCellValue('BN' . $row, $router_brand);
        $sheet->setCellValue('BO' . $row, $camera_ip);
        $sheet->setCellValue('BP' . $row, $port);
        $sheet->setCellValue('BQ' . $row, $cam_name);
        $sheet->setCellValue('BR' . $row, $row1['bank_officer_name']);
        $sheet->setCellValue('BS' . $row, $row1['bank_officer_number']);


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
    
    // Set auto width for all columns
    foreach (range('A', $highestColumn) as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exported_data_rms.xlsx"');
    header('Cache-Control: max-age=0');
    
    // Instantiate PhpSpreadsheet Writer
    $writer = new Xlsx($spreadsheet);
    
    // Save the file to output
    $writer->save('php://output');
    
    // Exit script
    exit();
    