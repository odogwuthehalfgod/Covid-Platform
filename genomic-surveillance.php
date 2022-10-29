<?php

include "covid.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;



if(isset($_POST["export-genomic-surveillance"])){
    $filename = "GENOMIC_SURVEILLANCE_".date("jS")."_".date("M");

    $data = "SELECT * FROM line_list_data WHERE result='POSITIVE' ORDER BY lab_no ASC";

    $query = mysqli_query($conn, $data);

        $rowcount = 2;
    if(mysqli_num_rows($query) > 0){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "S/N");
        $sheet->setCellValue("B1", "LABORATORY");
        $sheet->setCellValue("C1", "LAB ASSIGNED SPECIMEN ID");
        $sheet->setCellValue("D1", "EPID NUMBER");
        $sheet->setCellValue("E1", "NAME OF PATIENT");
        $sheet->setCellValue("F1", "AGE");
        $sheet->setCellValue("G1", "GENDER");
        $sheet->setCellValue("H1", "STATE OF SAMPLE COLLECTION");
        $sheet->setCellValue("I1", "DATE OF SPECIMEN COLLECTION");
        $sheet->setCellValue("J1", "SPECIMEN TYPE");
        $sheet->setCellValue("K1", "DATE SPECIMEN RECEIVED AT LAB");
        $sheet->setCellValue("L1", "DATE SPECIMEN TESTED");
        $sheet->setCellValue("M1", "INITIAL/REPEAT/FOLLOW UP");
        $sheet->setCellValue("N1", "CT Value qRT-PCR Target (E-GENE)");
        $sheet->setCellValue("O1", "CT Value qRT-PCR EAV(IC)");
        $sheet->setCellValue("P1", "CT Value qRT-PCR RDRP-GENE");
        $sheet->setCellValue("Q1", "CT Value qRT-N-GENE");
        $sheet->setCellValue("R1", "CT Value qRT-PCR ORF1-GENE");
        $sheet->setCellValue("S1", "RESULT");
        $sheet->setCellValue("T1", "CLIENT TYPE");
        $sheet->setCellValue("U1", "DATE OF BIRTH");
        $sheet->setCellValue("V1", "PASSPORT ID");
        $sheet->setCellValue("W1", "ADDRESS");
        $sheet->setCellValue("X1", "PHONE NUMBER");
        $sheet->setCellValue("Y1", "COUNTRY OF DESTINATION(OUTBOUND CASES)");
        $sheet->setCellValue("Z1", "COUNTRY OF DEPARTURE(INBOUND CASES)");
        $sheet->setCellValue("AA1", "TEST TYPE(DAY 2/DAY 7)");
        $sheet->setCellValue("AB1", "VACCINATION STATUS");
        $sheet->setCellValue("AC1", "CLINICAL STATUS IF KNOWN(RECOVERED, DECEASED OR RELEASED)");
        $sheet->setCellValue("AD1", "ARRIVAL DATE");
        $sheet->setCellValue("AE1", "COMMENT");

        for ($i = 'A'; $i!=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }


        $sn = 0;
        foreach($query as $data){
            $sn++;
            $sheet->setCellValue("A".$rowcount, $sn);
            $sheet->setCellValue("B".$rowcount, $data["lab_name"]);
            $sheet->setCellValue("C".$rowcount, $data["lab_no"]);
            $sheet->setCellValue("D".$rowcount, $data["epid_no"]);
            $sheet->setCellValue("E".$rowcount, $data["names"]);
            $sheet->setCellValue("F".$rowcount, $data["age"]);
            $sheet->setCellValue("G".$rowcount, $data["gender"]);
            $sheet->setCellValue("H".$rowcount, $data["state"]);
            $sheet->setCellValue("I".$rowcount, $data["collection_date"]);
            $sheet->setCellValue("J".$rowcount, $data["specimen_type"]);
            $sheet->setCellValue("K".$rowcount, $data["received_date"]);
            $sheet->setCellValue("L".$rowcount, $data["tested_date"]);
            $sheet->setCellValue("M".$rowcount, $date["initial_followup"]);
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

                $sheet->getStyle("S".$rowcount)->applyFromArray($styleArray);
            }
            $sheet->setCellValue("T".$rowcount, $data["client_type"]);
            $sheet->setCellValue("U".$rowcount, $data["dob"]);
            $sheet->setCellValue("V".$rowcount, $data["passport_id"]);
            $sheet->setCellValue("W".$rowcount, $data["address"]);
            $sheet->setCellValue("X".$rowcount, $data["phone_number"]);

            if($data["client_type"]=="OUTBOUND"){
                $sheet->setCellValue("Y".$rowcount, $data["departure_country"]);
                $sheet->setCellValue("Z".$rowcount, "N/A");
            }else{

                $sheet->setCellValue("Y".$rowcount, "N/A");
                $sheet->setCellValue("Z".$rowcount, $data["departure_country"]);
            }
            $sheet->setCellValue("AA".$rowcount, $data["test_type"]);
            $sheet->setCellValue("AB".$rowcount, "");
            $sheet->setCellValue("AC".$rowcount, "");
            $sheet->setCellValue("AD".$rowcount, $data["arrival_date"]);
            $sheet->setCellValue("AE".$rowcount, $data["comment"]);

            $rowcount++;


        }
        ob_end_clean();
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $final_filename = $filename.".xlsx";
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;  filename=".urlencode($final_filename)."");
    

        $writer->save("php://output");
        
    }
}
?>