<?php

include "covid.php";
include "header.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="import2.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="submit_file">Submit</button>
    </form>



<div>
    <?php
    
    $sql= "SELECT * FROM travel_info";

    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result)){
 ?>

 <div class="table_data"><?php echo $row["full_name"]; ?></div>
<?php } ?>
    
    
   

</div>
</body>
</html>