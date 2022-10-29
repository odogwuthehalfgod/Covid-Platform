<?php
$conn = mysqli_connect("localhost","root","");



if(!$conn){
    die("could not connect to the database");
}
mysqli_select_db($conn, "covid");
// echo "connected";


?>
