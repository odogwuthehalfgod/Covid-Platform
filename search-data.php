<?php

session_start();


include "covid.php";

$emeka="";
if(isset($_POST["query"])){
    
    $inputText = $_POST["query"];
    $query = "SELECT full_name FROM travel_info WHERE full_name LIKE '%$inputText%' AND display='yes'";

    $result = mysqli_query($conn,$query);

    

    if(mysqli_num_rows($result) > 0){
        
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
         echo "<a href='#' class='link'>".$row["full_name"]."</a>";

         $test = $row["full_name"];

         $query2 = "SELECT epid_no FROM line_list_data WHERE names LIKE '%$test%'";
         $result2 = mysqli_query($conn,$query2);

         if(mysqli_num_rows($result2) > 0){
            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                // echo $row2["epid_no"];

                $emeka = $row2["epid_no"];
            }
         }

        }
    }else{
        echo "no record found";
    }



    // $_SESSION["epid_no"] = $emeka;
}



?>
