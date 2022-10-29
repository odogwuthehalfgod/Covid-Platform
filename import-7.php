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
    <div class="form-container">
        <form action="import7.php" method="post" enctype="multipart/form-data">
            <div class="box-text">Day 7 Data</div>
            <!-- <label for="upload-file">Choose File</label> -->
            <input type="file" name="file" id="upload-file" hidden>
            <div class="select-box">
                <!-- <span id="file-chosen">No file chosen</span> -->
                <label for="upload-file" id="file-chosen">Browse File</label>
            </div>
            <button type="submit" name="submit_file" >Upload</button>
        </form>
    </div>


<div>
    <?php
    
    $sql= "SELECT * FROM travel_info";

    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result)){
 ?>

 <div class="table_data"><?php echo $row["full_name"]; ?></div>
<?php } ?>
    
    
   
<style>

    .form-container{
        display: grid;
        grid-template-columns: 1fr;
        width: 500px;
        margin: 0 auto;
        gap: 100px;
        /* background: #EEF2F7; */
        background: #eef2f782;
        border-radius: 5px;
        padding: 100px;
    }
    form{
        display: inline-block;
        border-radius: 5px;
        padding: 30px;
        box-shadow:
        0 2.8px 2.2px rgba(0, 0, 0, 0.034),
        0 6.7px 5.3px rgba(0, 0, 0, 0.048),
        0 12.5px 10px rgba(0, 0, 0, 0.06),
        0 22.3px 17.9px rgba(0, 0, 0, 0.072),
        0 41.8px 33.4px rgba(0, 0, 0, 0.086),
        0 100px 80px rgba(0, 0, 0, 0.12);
        background:white;
        
    }
    input[type=file]::file-selector-button{
        background: white;
        padding: 10px;
        border: none;
        color: white;
        background-color: blue;
        margin-bottom: 30px;
    }

    form button{
        background: white;
        padding: 10px;
        border: none;
        color: white;
        background-color: blue;
        display: block;
        width: 100%;
        border-radius: 5px;
    }

    .select-box{
        padding: 20px;
        border: 2px dashed #80808026;  
        text-align: center;    
        margin-bottom: 20px; 
        border-radius: 5px;
    }

    #file-chosen{
        color: blue;
        cursor: pointer;
    }

    .box-text{
        margin-bottom: 20px;
        font-size: 15px;
        color: gray;
        text-align: center;
    }
</style>

</div>
</body>

<script>
    const actualBtn = document.getElementById('upload-file');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
    fileChosen.textContent = this.files[0].name
    })
</script>
</html>