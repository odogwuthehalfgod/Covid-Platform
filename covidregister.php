<?php

session_start();

$_SESSION["lab_person"] = "Onyinye";

include "covid.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;



if(isset($_POST["export-register"])){
    $filename = "COVID_REGISTER_".date("jS")."_".date("M");

    $data = "SELECT * FROM line_list_data WHERE result='POSITIVE' OR result='NEGATIVE' ORDER BY lab_no ASC";

    $query = mysqli_query($conn, $data);


    

    $rowcount = 2;

   
    if(mysqli_num_rows($query) > 0){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "S/N");
        $sheet->setCellValue("B1", "NAMES");
        $sheet->setCellValue("C1", "PASSPORT ID");
        $sheet->setCellValue("D1", "ARRIVAL DATE");
        $sheet->setCellValue("E1", "EPID NO");
        $sheet->setCellValue("F1", "LAB NO");
        $sheet->setCellValue("G1", "DATE OF SPECIMEN COLLECTED");
        $sheet->setCellValue("H1", "SAMPLING TIME");
        $sheet->setCellValue("I1", "DATE OF SPECIMEN TESTED");
        $sheet->setCellValue("J1", "CT VALUE IF POSITIVE");
        $sheet->setCellValue("K1", "FINAL RESULT");
        $sheet->setCellValue("L1", "LAB SCIENTIST");
       
        for ($i = 'A'; $i!=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $sn = 0;
        foreach($query as $data){

            $sn++;
            $sheet->setCellValue("A".$rowcount, $sn);
            $sheet->setCellValue("B".$rowcount, $data["names"]);
            $sheet->setCellValue("C".$rowcount, "");
            $sheet->setCellValue("D".$rowcount, "");
            $sheet->setCellValue("E".$rowcount, $data["epid_no"]);
            $sheet->setCellValue("F".$rowcount, $data["lab_no"]);
            $sheet->setCellValue("G".$rowcount, $data["collection_date"]);
            $sheet->setCellValue("H".$rowcount, $data["collection_time"]);
            $sheet->setCellValue("I".$rowcount, $data["tested_date"]);
            $sheet->setCellValue("J".$rowcount, $data["ct_value"]);
            $sheet->setCellValue("K".$rowcount, $data["result"]);
            $sheet->setCellValue("L".$rowcount, $_SESSION["lab_person"]);
            
            

            if($data["result"] == "POSITIVE"){

                $styleArray = [
                    'font' => [
                        // 'bold' => true,
                        'color'=> ['argb' => 'FFFF0000']
                    ]
                    ];

                $sheet->getStyle("B".$rowcount)->applyFromArray($styleArray);
            
                $sheet->getStyle("J".$rowcount)->applyFromArray($styleArray);
                $sheet->getStyle("K".$rowcount)->applyFromArray($styleArray);
                
            }
           
            $rowcount++;

        }

        ob_end_clean(); //stops corruption error by excel.
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $final_filename = $filename.".xlsx";
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;  filename=".urlencode($final_filename)."");
    

        $writer->save("php://output");
        
    }
}

?>