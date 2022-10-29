<?php

session_start();

function error_message(){
    if(isset($_SESSION["error_message"])){
        $output = "<div class='error'>";
        $output .= $_SESSION["error_message"];
        $output .= "</div>";

        $_SESSION["error_message"] = null;

        return $output;
    }
}
?>