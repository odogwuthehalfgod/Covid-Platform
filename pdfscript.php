<?php

class Template{
var $assignedValue = array();
var $tpl;

// function template(){
//     echo "this is the template thingy";
// }
function __construct($_path = ""){
    // echo "this is the template thingy";
    if(!empty($_path)){
        if(file_exists($_path)){
            $this->tpl = file_get_contents($_path);
        }else{
            echo "Error: File inclusion error";
        }
    }
    // echo $this->tpl;
}


function assign($_searchString, $_replaceString){
    if(!empty($_searchString)){
        $this->assignedValue[strtoupper($_searchString)] = $_replaceString;
    }

    // var_dump($this->assignedValue);
}



function show(){
    if(count($this->assignedValue) > 0){
        foreach ($this->assignedValue as $key => $value){
            $this->tpl = str_replace("{"."$key"."}", $value, $this->tpl);
        }
    }

    echo $this->tpl;
    // echo "<script>window.print()</script>";
    echo "<script>window.print()</script>";

//     $pdf = new \Mpdf\Mpdf(["mode"=>"UTF-8", "format"=>"A4"]);
// $pdf->SetTitle("test-test");
// $pdf->WriteHTML($this->tpl);
// $pdf->Output("test"."'s RESULT".".pdf", "I");
}



}


?>