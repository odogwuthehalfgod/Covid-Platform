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

if(isset($_POST["export-linelist"])){
    $filename = "LINE_LIST_".date("jS")."_".date("M");

    $data = "SELECT * FROM line_list_data ORDER BY tested_date ASC, lab_no ASC";

    $query = mysqli_query($conn, $data);

        $rowcount = 2;
    if(mysqli_num_rows($query) > 0){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "S/N");
        $sheet->setCellValue("B1", "LAB NAME");
        $sheet->setCellValue("C1", "LAB NUMBER");
        $sheet->setCellValue("D1", "EPID NUMBER");
        $sheet->setCellValue("E1", "NAMES");
        $sheet->setCellValue("F1", "AGE");
        $sheet->setCellValue("G1", "GENDER");
        $sheet->setCellValue("H1", "STATE");
        $sheet->setCellValue("I1", "COLLECTION DATE");
        $sheet->setCellValue("J1", "SPECIMEN TYPE");
        $sheet->setCellValue("K1", "RECEIVED DATE");
        $sheet->setCellValue("L1", "TESTED DATE");
        $sheet->setCellValue("M1", "INITIAL/FOLLOW UP");
        $sheet->setCellValue("N1", "CT Value qRT-PCR Target (E-GENE)");
        $sheet->setCellValue("O1", "CT Value qRT-PCR EAV(IC)");
        $sheet->setCellValue("P1", "CT VALUE");
        $sheet->setCellValue("Q1", "CT VALUE 2");
        $sheet->setCellValue("R1", "CT Value qRT-PCR ORF1-GENE");
        $sheet->setCellValue("S1", "RESULT");

       
        
        $sheet->setCellValue("T1", "CLIENT TYPE");
        $sheet->setCellValue("U1", "TEST DAY");
        $sheet->setCellValue("V1", "DATE OF BIRTH");
        $sheet->setCellValue("W1", "ADDRESS");
        $sheet->setCellValue("X1", "PHONE NUMBER");
        $sheet->setCellValue("Y1", "PASSPORT ID");
        $sheet->setCellValue("Z1", "ARRIVAL DATE");
        $sheet->setCellValue("AA1", "COMMENT");


        for ($i = 'A'; $i!=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        
        foreach($query as $data){


            $sheet->setCellValue("A".$rowcount, "");
            $sheet->setCellValue("B".$rowcount, $data["lab_name"]);
            $sheet->setCellValue("C".$rowcount, $data["lab_no"]);
            $sheet->setCellValue("D".$rowcount, $data["epid_no"]);
            $sheet->setCellValue("E".$rowcount, $data["names"]);
            $sheet->setCellValue("F".$rowcount, $data["age"]);
            $sheet->setCellValue("G".$rowcount, $data["gender"]);
            $sheet->setCellValue("H".$rowcount, $data["state"]);

            // $dateconvert = strtotime($data["collection_date"]);
            // $finaldate = date("d-M-Y", $dateconvert);

            $sheet->setCellValue("I".$rowcount, dateconverter($data["collection_date"]));
            // $sheet->setCellValue("I".$rowcount, $finaldate);
            $sheet->setCellValue("J".$rowcount, $data["specimen_type"]);
            $sheet->setCellValue("K".$rowcount, dateconverter($data["received_date"]));
            $sheet->setCellValue("L".$rowcount, $data["tested_date"]);
            $sheet->setCellValue("M".$rowcount, $data["initial_followup"]);
            $sheet->setCellValue("N".$rowcount, "");
            $sheet->setCellValue("O".$rowcount, "");
            $sheet->setCellValue("P".$rowcount, $data["ct_value"]);
            $sheet->setCellValue("Q".$rowcount, $data["ct_value2"]);
            $sheet->setCellValue("R".$rowcount, "");
            $sheet->setCellValue("S".$rowcount, $data["result"]);

            if($data["result"] == "POSITIVE"){

                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'color'=> ['argb' => 'FFFF0000']
                    ]
                    ];

                $sheet->getStyle("P".$rowcount)->applyFromArray($styleArray);
            
                $sheet->getStyle("Q".$rowcount)->applyFromArray($styleArray);
                $sheet->getStyle("S".$rowcount)->applyFromArray($styleArray);
                
            }
            
            $sheet->setCellValue("T".$rowcount, $data["client_type"]);
            
            if($data["client_type"]=="NON-TRAVELLER"){
                $sheet->setCellValue("T".$rowcount, $data["client_type"]."/RDT");

            }

            if($data["client_type"] == "OUTBOUND" || $data["client_type"] == "NON-TRAVELLER"){

                $sheet->setCellValue("U".$rowcount, "N/A");
            }else{
                $sheet->setCellValue("U".$rowcount, $data["test_day"]);
            }
            $sheet->setCellValue("V".$rowcount, $data["dob"]);
            $sheet->setCellValue("W".$rowcount, $data["address"]);
            $sheet->setCellValue("X".$rowcount, $data["phone_number"]);
            $sheet->setCellValue("Y".$rowcount, $data["passport_id"]);
            $sheet->setCellValue("Z".$rowcount, $data["arrival_date"]);
            $sheet->setCellValue("AA".$rowcount, $data["comment"]);

            $rowcount++;

        }
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $final_filename = $filename.".xlsx";
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;  filename=".urlencode($final_filename)."");
    

        $writer->save("php://output");
        
    }
}
?>