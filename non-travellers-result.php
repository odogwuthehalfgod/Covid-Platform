<?php

include "covid.php";
// require_once __DIR__ . "/vendor/autoload.php";
require_once "vendor/autoload.php";

$id = $_GET["id"];

$sql= "SELECT * FROM line_list_data WHERE id='$id'";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)){
    $epno = $row["epid_no"];
    $name = $row["names"];
    $age = $row["age"];
    $gender = $row["gender"];
    $state = $row["state"];
    $collection_date = $row["collection_date"];
    $tested_date = $row["tested_date"];
    $address = $row["address"];
    $labno = $row["lab_no"];
    $state = $row["state"];
    $specimen = $row["specimen_type"];
    $initial = $row["initial_followup"];
    $resultc = $row["result"];
    $ct = $row["ct_value"];
    // $gender = $row["gender"]

    echo $name;
}


$pdf = new \Mpdf\Mpdf([
  'default_font' => "ProductSans-Medium"
]);

$pdf->showImageErrors = true;

$img = "<img src='IMG_6906.PNG'/>";

$html = '
<html lang="en">
  <head>
    <title>Document</title>
  </head>
  <body>

  <style>
      .result-main {
        display: grid;
        /* grid-template-columns: repeat(5, 1fr); */
        grid-template-columns: repeat(6, 10px);
      }
    </style>
    <div class="logo-header">
        <span class="logo">
         
        </span>
        <h1 class="mole">MOLECULAR LABORATORY</h1>
        <h3 class="mole-subtext">
          PLOT NO. 1021, B5 SHEHU YARADUA WAY, OPPOSITE FEDERAL MINISTRY OF
          WORKS, UTAKO DISTRICT, ABUJA
        </h3>
        <h3 class="mole-subheader">REPORT FORM</h3>
      </div>

    <table style="width: 100%; font-family: product sans medium">
      <tr>
        <th>Name:</th>
        <td>'.$name.'</td>
      </tr>
      <tr>
        <th>Age</th>
        <td>'.$age.'</td>
      </tr>
      <tr>
        <th>Sex</th>
        <td>'.$gender.'</td>
      </tr>
      <tr>
        <th>Lab Number</th>
        <td>'.$labno.'</td>
      </tr>
      <tr>
        <th>Address</th>
        <td>'.$address.'</td>
      </tr>
      <tr>
        <th>LGA</th>
        <td>AMAC</td>
      </tr>
      <tr>
        <th>State</th>
        <td>'.$state.'</td>
      </tr>
      <tr>
        <th>Epid Number
         <td>'.$epno.'</td>
        </th>
      </tr>
      <tr>
        <th>Specimen Type</th>
        <td>'.$specimen.'</td>
      </tr>
      <tr>
        <th>Date Received</th>
        <td>'.$collection_date.'</td>
      </tr>
      <tr>
        <th>Date Issued</th>
        <td>'.$tested_date.'</td>
      </tr>
      <tr>
        <th>Test Status</th>
        <td>'.$initial.'</td>
      </tr>
      <tr>
        <th>Final Result</th>
        <td class='.$resultc.'>'.$resultc.'</td>
      </tr>
      <tr>
        <th>CT Value</th>
        <td class='.$resultc.'>'.$ct.'</td>
      </tr>
    </table>
      
    <div class="sign">
      <div class="labmanager">

      </div>
      <p></p>
    </div>
    <style>
      .t{
        display: float;
      }
      .POSITIVE{
        font-weight: bold;
        color:red;
      }
      .m{
        float: right;
        width: 200px;
        height: 100px;
        background-color: blue;
      }

      .mole{
        text-align: center;
      }
      .logo{
        
        
        transform: translate(-50%, -50%);
      }
      .img{
        display: block;
        position: relative;
        left: 90%;
      }

      .logo-header{
        margin-right: 40000px;
      }

      .mole-subtext, .mole-subheader{
        text-align: center;
      }

      
      
      table, th, td {
        // border: 1px solid black;
        border-collapse: collapse;
      }
      th, td {
        padding: 5px;
        text-align: left;
      }
      tr:nth-child(even) {background: #CCC}
      tr:nth-child(odd) {background: #FFF}
      </style>
  </body>
</html>
';



$pdf->SetTitle($name);
$pdf->WriteHTML($html);
$pdf->Output($name."'s RESULT".".pdf", "I");
?>