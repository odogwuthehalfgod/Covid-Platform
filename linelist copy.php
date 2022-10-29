<?php

include "covid.php";
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;


$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$read_excel = $reader->load("hhh.xlsx");

$d = $read_excel->getSheet(0)->toArray();

for($i=0;$i<=count($d);$i++){
    echo $d[$i];
}

// echo $read_excel;


?>