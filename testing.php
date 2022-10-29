<?php

include "covid.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js" ></script>
</head>
<body class="sexybody">


<?php

// $test = "hi there";

$id = $_GET["id"];

$sql= "SELECT * FROM line_list_data WHERE id='$id'";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)){
    $epno = $row["epid_no"];
    $name = $row["names"];

}


?>

<div class="result-head" id="whatToPrint">
      <div class="logo-header">
        <span class="logo">
          <img src="" alt="" />
        </span>
        <h1>MOLECULAR LABORATORY</h1>
        <h3>
          PLOT NO. 1021, B5 SHEHU YAR'ADUA WAY, OPPOSITE FEDERAL MINISTRY OF
          WORKS, UTAKO DISTRICT, ABUJA
        </h3>
        <h3>REPORT FORM</h3>
      </div>

      <div class="result-main">
        <div class="result-body surname">
          <h3>SURNAME</h3>
          <h2><?php echo $name; ?></h2>
        </div>
        <div class="result-body first-name">
          <h3>FIRST NAME</h3>
          <h2></h2>
        </div>
        <div class="result-body age">
          <h3>AGE</h3>
          <h2></h2>
        </div>
        <div class="result-body sex">
          <h3>SEX</h3>
          <h2></h2>
        </div>
        <div class="result-body lab-no">
          <h3>LAB NO:</h3>
          <h2></h2>
        </div>
        <div class="result-body address">
          <h3>ADDRESS</h3>
          <h2></h2>
        </div>
        <div class="result-body lga">
          <h3>LGA:</h3>
          <h2></h2>
        </div>
        <div class="result-body state">
          <h3>STATE</h3>
          <h2></h2>
        </div>
        <div class="result-body epid-no">
          <h3>EPID NO:</h3>
          <h2><?php echo $epno; ?></h2>
        </div>
        <div class="result-body specimen-type">
          <h3>SPECIMEN TYPE</h3>
          <h2></h2>
        </div>
        <div class="result-body date-received">
          <h3>DATE RECEIVED</h3>
          <h2></h2>
        </div>
        <div class="result-body date-tested">
          <h3>DATE ISSUED</h3>
          <h2></h2>
        </div>
        <div class="result-body test-requested">
          <h3>TEST REQUESTED</h3>
          <h2></h2>
        </div>
      </div>
    </div>

    <style>
        .result-head{
            width: 1200px;
            margin:0 auto;
        }
      .result-main {
        display: grid;
        /* grid-template-columns: repeat(5, 1fr); */
        grid-template-columns: repeat(13, 1fr);
      }

      .result-body {
        border: 1px solid black;
      }

      .surname,
      .address,
      .specimen-type {
        grid-column: 1/4;
      }

      .first-name {
        grid-column: 4/7;
      }

      .lab-no {
        grid-column: 9/-1;
      }

      .lga,
      .date-received {
        grid-column: 4/6;
      }

      .state,
      .date-tested {
        grid-column: 6/9;
      }

      .epid-no,
      .test-requested {
        grid-column: 9/-1;
      }

      .result-body h2{
          text-align: center;
      }

      .result-body h3 {
        font-family: "product sans black";
        margin-top: 0;
        font-size: 15px;
        text-align: center;
      }
    </style>


<a href="javascript:generatePDF()" id="downloadButton">Click to download</a>
<script>
    
        
    
        async function generatePDF() {
            // location.reload();
            document.getElementById("downloadButton").innerHTML = "Currently downloading, please wait";

            //Downloading
            var downloading = document.getElementById("whatToPrint");
            var doc = new jsPDF('l', 'pt');

            await html2canvas(downloading, {
                //allowTaint: true,
                //useCORS: true,
                width: 2000
            }).then((canvas) => {
                //Canvas (convert to PNG)
                doc.addImage(canvas.toDataURL("image/png"), 'PNG', 5, 5, 1200, 260);
            })

            doc.save("Document.pdf");

            //End of downloading

            document.getElementById("downloadButton").innerHTML = "Click to download";
        }


    </script>
    
</body>


</html>