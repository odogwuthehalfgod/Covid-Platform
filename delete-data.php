<?php

include "covid.php";
include "header.php";

$id = $_GET["id"];
$name = $_GET["names"];

echo $id;

echo $name;

$sql2 = "UPDATE travel_info SET display='yes' WHERE full_name='$name'";

mysqli_query($conn,$sql2);



$sql = "DELETE FROM line_list_data WHERE id='$id'";




if ($conn->query($sql) === TRUE && $conn->query($sql2)) {

    echo "Record deleted successfully";
   
    
    header("Location: lab.php");
  } else { 
    echo "Error deleting record";
  }

?>