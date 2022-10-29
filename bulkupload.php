<?php

include "covid.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;





if(isset($_POST["export-bulkupload"])){
    $filename = "bulkupload";

    $data = "SELECT * FROM line_list_data WHERE client_type='INBOUND' OR client_type='OUTBOUND'";


    $query = mysqli_query($conn, $data);


    // echo $conn;
   
        $rowcount = 2;
    if(mysqli_num_rows($query) > 0){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
       
        $sheet->setCellValue("A1", "CertNo");
        $sheet->setCellValue("B1", "FullName");
        $sheet->setCellValue("C1", "DateOfBirth");
        $sheet->setCellValue("D1", "Gender");
        $sheet->setCellValue("E1", "SamplingDate");
        $sheet->setCellValue("F1", "SamplingTime");
        $sheet->setCellValue("G1", "TestName");
        $sheet->setCellValue("H1", "Methodology");
        $sheet->setCellValue("I1", "SamplingType");
        $sheet->setCellValue("J1", "Status");
        $sheet->setCellValue("K1", "TestPurpose");
        $sheet->setCellValue("L1", "EmailAddress");
        $sheet->setCellValue("M1", "PhoneNo");
        $sheet->setCellValue("N1", "PassportNo");
       
        $certNo = $_POST["cert_no"];
        $split = "";
        for ($i = 'A'; $i!=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        foreach($query as $data){


            $certNo++;
            $sheet->setCellValue("A".$rowcount, $certNo);
            $sheet->setCellValue("B".$rowcount, $data["names"]);
            $sheet->setCellValue("C".$rowcount, $data["dob"]);
            $sheet->setCellValue("D".$rowcount, $data["gender"]);

            // echo $data["collection_date"];
            $split = explode("-", $data["collection_date"]);

            // if(2022 == $split[2]){
            //     echo "they are the same";
            // }else{
            //     echo "this is the one that starts with 22";
            // }

            $year = 2000 + $split[2];

            $month = $split[0]." ".$split[1];

            $month = date("m", strtotime($month));

            $day = $split[0];

            $collection_date = $year."".$month."".$day;

            // $sheet->setCellValue("E".$rowcount, $data["collection_date"]);
            $sheet->setCellValue("E".$rowcount, $collection_date);
            $sheet->setCellValue("F".$rowcount, $data["collection_time"]);
            $sheet->setCellValue("G".$rowcount, "COVID-19");
            $sheet->setCellValue("H".$rowcount, "Real-Time PCR");
            $sheet->setCellValue("I".$rowcount, "NS/OS");
            $sheet->setCellValue("J".$rowcount, $data["result"]);
            $sheet->setCellValue("K".$rowcount, "TRAVEL");
            $sheet->setCellValue("L".$rowcount, $data["email"]);
            $sheet->setCellValue("M".$rowcount, $data["phone_number"]);
            $sheet->setCellValue("N".$rowcount, $data["passport_id"]);
           

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