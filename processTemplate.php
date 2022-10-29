<?php

require_once("pdfscript.php");
require_once("covid.php");
require_once "vendor/autoload.php";
// include "covid.php";

define("TEMPLATES_PATH", "templates");


$template = new Template(TEMPLATES_PATH."/pdftesting.html");

$id = $_GET["id"];

$sql= "SELECT * FROM line_list_data WHERE id='$id'";
// $sql= "SELECT * FROM line_list_data WHERE client_type='NON-TRAVELLER' ORDER BY tested_date ASC, lab_no ASC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)){

    $dividedNames = explode(" ", $row["names"]);

$template->assign("fullname", $dividedNames[0]." ".$dividedNames[1]);
$template->assign("surname", $dividedNames[0]);
$template->assign("other_names", $dividedNames[1]);
$template->assign("age", $row["age"]);
$template->assign("gender", $row["gender"]);
$template->assign("lab_no", $row["lab_no"]);
$template->assign("address", $row["address"]);
$template->assign("epid_no", $row["epid_no"]);
$template->assign("date_received", $row["received_date"]);
$template->assign("date_issued", $row["tested_date"]);
$template->assign("initial", $row["initial_followup"]);
$template->assign("result", $row["result"]);

$template->show();

// $pdf = new \Mpdf\Mpdf([
//     'default_font' => "ProductSans-Medium"
//   ]);
  


//   $pdf->SetTitle("test-test");
// $pdf->WriteHTML(TEMPLATES_PATH."/pdftesting.html");
// $pdf->Output("test"."'s RESULT".".pdf", "I");

}



?>