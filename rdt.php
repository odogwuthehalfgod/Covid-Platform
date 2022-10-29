<?php

include "covid.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;


function dateconverter($datedata){
    $dateconvert = strtotime($datedata);
    $finaldate = date("d-M-y", $dateconvert);

    return $finaldate;
}

if(isset($_POST["export-rdt"])){
    $filename = "Outpatients".date("jS")."_".date("M");

    $data = "SELECT * FROM line_list_data WHERE client_type='NON-TRAVELLER' ORDER BY tested_date ASC, lab_no ASC";

    $query = mysqli_query($conn, $data);

        $rowcount = 2;
    if(mysqli_num_rows($query) > 0){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "SURNAME");
        $sheet->setCellValue("B1", "FIRST NAME");
        $sheet->setCellValue("C1", "AGE");
        $sheet->setCellValue("D1", "SEX");
        $sheet->setCellValue("E1", "LAB NO");
        $sheet->setCellValue("F1", "ADDRESS");
        $sheet->setCellValue("G1", "EPID NO");
        $sheet->setCellValue("H1", "TEST STATUS");
        $sheet->setCellValue("I1", "FINAL RESULT");
        $sheet->setCellValue("J1", "DATE");
       



        for ($i = 'A'; $i!=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        
        foreach($query as $data){

            $new_lab_no = str_replace("LLML", "ZMC", $data["lab_no"]);
            $dividedNames = explode(" ", $data["names"]);

            $sheet->setCellValue("A".$rowcount, $dividedNames[0]);
            $sheet->setCellValue("B".$rowcount, $dividedNames[1]);
            $sheet->setCellValue("C".$rowcount, $data["age"]);
            $sheet->setCellValue("D".$rowcount, $data["gender"]);
            // $sheet->setCellValue("E".$rowcount, $data["lab_no"]);
            $sheet->setCellValue("E".$rowcount, $new_lab_no);
            $sheet->setCellValue("F".$rowcount, $data["address"]);
            $sheet->setCellValue("G".$rowcount, $data["epid_no"]);
            $sheet->setCellValue("H".$rowcount, $data["initial_followup"]);

            // $dateconvert = strtotime($data["collection_date"]);
            // $finaldate = date("d-M-Y", $dateconvert);

            $sheet->setCellValue("I".$rowcount, $data["result"]);
            $sheet->setCellValue("J".$rowcount, $data["collection_date"]);
            // $sheet->setCellValue("I".$rowcount, $finaldate);
            $rowcount++;
        }
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $final_filename = $filename.".xlsx";
        
        
       
        // header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        // header("Content-Disposition: attachment;  filename=".urlencode($final_filename)."");
    

        // $writer->save("php://output");
        
    }
}


?>