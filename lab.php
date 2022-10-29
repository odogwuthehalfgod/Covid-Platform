<?php

include "covid.php";
include "header.php";





if(isset($_POST["submitty"])){

    $fullname =$_POST["fullname"];
    $labname = "Zankli Medical Center(Lovett Lawson Molecular Laboratory)";
    $epid_no = "";
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $state = "FCT";
    $email = $_POST["email"];
    $samplingdate = $_POST["samplingdate"];
    $samplingtime = $_POST["samplingtime"];
    $specimen_type = "NS/OS";
    $received_date = $samplingdate;

    $lcyear = date("y");
    $ucmonth = date("M");
    $lcday = date("d");

    $tested_date = $lcday."-".$ucmonth."-".$lcyear;
    $initial_followup = "";
    $ct_value = "";
    $ct_value2 = $ct_value;
    $result = "";
    $client_type = $_POST["travel_type"];
    $passport = $_POST["passport"];
    $lcyear = date("y");


    $test_day = $_POST["test-day"];

    $dateofbirth = $_POST["dob"];

    $pattern = '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/';
    $dateofbirth = preg_replace($pattern, "-", $dateofbirth);

    $split = explode("-", $dateofbirth);

    $month = date("m", strtotime($split[1]));

    $nom = "";

    if($split[2] < 20){
        $nom = 20;
    }else{

        $nom = 19;
    }


    if(strlen($split[2])==4){
        $nom="";
    }

   $newdateofbirth = $nom."".$split[2]."".$month."".$split[0];
//    $split[0]."".$month."".;

   echo $newdateofbirth;

    $addy = $_POST["addy"];
    $fone = $_POST["fone"];
    $arrival_date = $_POST["arrive"];
    $departure_country = $_POST["departure_country"];
    $comment = "";
    $payment = "";

    
    if($_POST["payment-type"]=="private-paying"){
        $payment = $_POST["private-receipt-number"];
        echo $payment;
    }
    
    if($_POST["payment-type"]=="hmo"){
        $payment = $_POST["hmo-receipt-number"];
        echo $payment;
    }

    if($client_type == "OUTBOUND"){
        $payment = $_POST["receipt-number"];
    }
    if($client_type == "INBOUND"){
        $payment = $_POST["portal-pay"];
    }

    $epidcode = "NIE/FCT/ABC/"."".$lcyear.""."-";
    $epidno = $_POST["epid_no"];
    $newepidno = $epidcode."".$epidno;
    $newlabno = "";




    // $sql= "SELECT * FROM line_list_data WHERE name='$fullname'";

    // $result = mysqli_query($conn,$sql);

    
    // while($numrows = mysqli_fetch_array($result)){
    //     echo "working now";
    // }
    
    // if($numrows > 0){
    //     echo "this data already exist";
    // }else{
        $sql = "INSERT INTO line_list_data (`lab_name`, `lab_no`,`epid_no`, `names`,`age`,`gender`, `state`, `collection_date`, `collection_time`, `specimen_type`, 
        `received_date`, `tested_date`,
         `initial_followup`,`ct_value`, `ct_value2`,`result`, `client_type`,`test_day`, `dob`,`address`, `phone_number`, `email`, `passport_id`, `arrival_date`, 
         `departure_country`, `comment`, `payment`) 
        values ('$labname','$newlabno', '$newepidno', '$fullname','$age', '$gender', '$state','$samplingdate','$samplingtime','$specimen_type','$received_date','$tested_date', 
        '$initial_followup','$ct_value','$ct_value2','$result','$client_type','$test_day','$newdateofbirth','$addy','$fone','$email','$passport','$arrival_date','$departure_country','$comment','$payment')";

        $sql2 = "UPDATE travel_info SET display='no' WHERE full_name='$fullname'";
        
        $result = mysqli_query($conn,$sql);


        $result2 = mysqli_query($conn,$sql2);

}



if(isset($_POST["recapture"])){
    
    if(isset($_POST["update"])){
        
        foreach($_POST["update"] as $updateid){
            // $labcode = "LLML/NCOV/"."".date("y")."/";
            $labcode = "LLML/NCOV/"."".date("y")."/";
            // $sql= "SELECT lab_no FROM line_list_data WHERE id=$updateid";
            $sql= "SELECT lab_no, client_type FROM line_list_data WHERE id=$updateid";

            $result = mysqli_query($conn,$sql);

             while($row = mysqli_fetch_array($result)){

                 if(strpos($row["lab_no"], $labcode)!==false){
                     $labcode ="";
                 }else{
                    if($row["client_type"]!=="NON-TRAVELLER"){
                        $labcode = "LLML/NCOV/"."".date("y")."/";
                    }else{
                        $labcode = "ZMC/NCOV/"."".date("y")."/";
                        echo $labcode;
                    }
                 }
             }

            $labno = $labcode."".$_POST["labno_".$updateid];
            
            $initial_followup = $_POST["initial_followup_".$updateid];
            $result = strtoupper($_POST["result_".$updateid]);
            $ctvalue = $_POST["ctvalue_".$updateid];


            $sql = "UPDATE line_list_data SET lab_no='$labno', initial_followup='$initial_followup', result='$result', ct_value='$ctvalue', ct_value2='$ctvalue' WHERE id='$updateid'";

            mysqli_query($conn,$sql);

             
            
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="util.css">
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>


<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
                        <form action="lab.php" method="post">
                            <table>
                                <thead>
                                    <tr class="table100-head">
                                        <th class="column1"><input type="checkbox" id="checkall"></th>
                                        <th class="column2">Lab Number</th>
                                        <th class="column4">Epid No</th>
                                        <th class="column3">Name</th>
                                        <th class="column3">Initial/Follow Up</th>
                                        <th class="column5">Result</th>
                                        <th class="column6">CT Value</th>
                                        <!-- <th class="column6">Status</th> -->
                                        <th class="column6"></th>
                                        <th class="column7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        include "covid.php";

                                        $sql= "SELECT * FROM line_list_data";

                                        $result = mysqli_query($conn,$sql);

                                        while($row = mysqli_fetch_array($result)){
                                    ?>

                                    
                                        <tr>
                                            <td class="column1"><input type="checkbox" name="update[]" value=<?php echo $row["id"]; ?> id=""></td>
                                            <td class="column4"><input type="text" name="labno_<?php echo $row["id"]; ?>" value="<?php echo $row["lab_no"]; ?>"></td>
                                            <td class="column2"><?php echo $row["epid_no"]; ?></td>
                                            <td class="column3"><p class="<?php echo ($row["result"]=="POSITIVE") ? 'red':'black'; ?>"><?php echo $row["names"]; ?></p></td>
                                            <td class="column3">
                                                <select name="initial_followup_<?php echo $row["id"]; ?>" id="">
                                                    <option value="<?php echo $row["initial_followup"]?>"><?php echo ($row["initial_followup"]=="") ? 'Select a value': $row["initial_followup"]; ?></option>
                                                    <option value="INITIAL">Initial</option>
                                                    <option value="FOLLOW UP">Follow up</option>
                                                </select>
                                            </td>
                                            <td class="column5"><input type="text" name="result_<?php echo $row["id"]; ?>" value="<?php echo $row["result"]; ?>" class="<?php echo ($row["result"]=="POSITIVE") ? 'red':'black'; ?>"></td>
                                            <td class="column5"><input type="text" name="ctvalue_<?php echo $row["id"]; ?>" value="<?php echo $row["ct_value"]; ?>" class="<?php echo ($row["result"]=="POSITIVE") ? 'red':'black'; ?>"></td>
                                            <!-- <td class="column6"><p>Approved</p></td> -->
                                            <td class="column6"><button type="save" class="save"><a href="processTemplate.php?id=<?php echo $row["id"]; ?>">PDF</a></button></td>
                                            <td class="column6"><button type="save" class="save"><a href="edit-data.php?id=<?php echo $row["id"]; ?>">Edit</a></button></td>
                                            <td class="column6"><button type="save" class="save"><a href="delete-data.php?id=<?php echo $row["id"]; ?>&names=<?php echo $row["names"]; ?>">Delete</a></button></td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                            <button type="submit" name="recapture">Save</button>
                        </form>
                        
                        <form action="linelist.php" method="post">
                            <button type="submit" name="export-linelist">Generate Linelist</button>
                        </form>
                        
                        <form action="bulkupload.php" method="post">
                            <input type="text" name="cert_no" placeholder="Certificate Number">
                            <button type="submit" name="export-bulkupload">Generate Bulk Upload</button>
                        </form>
                        <form action="covidregister.php" method="post">
                            <button type="submit" name="export-register">Generate Covid Register</button>
                        </form>
                        <form action="genomic-surveillance.php" method="post">
                            <button type="submit" name="export-genomic-surveillance">Generate Genomic Surveillance</button>
                        </form>
                        <form action="rdt.php" method="post">
                            <button type="submit" name="export-rdt">Generate Outpatient's Result</button>
                        </form>
				</div>
			</div>
		</div>
	</div>

    
    <style>

    body{
        font-family: "system-ui";
    }
    .save{        
    background-color: blueviolet !important;
    padding: 10px !important;
}

.red{
    color: red;
}

button{
    color:white;
}



.wrap-table100 {
  width: 1500px;
}

a{
    color: blue;
    text-decoration: none;
}



    </style>

<script type="text/javascript">
    $(document).ready(function(){
       $("#checkall").change(function(){
           if($(this).is(":checked")){
               $("input[name='update[]']").prop("checked", true);
           }else{
               $("input[name='update[]']").each(function(){
                   $(this).prop("checked", false);
               })
           }
       })
    });

    $("input[name='update[]']").click(function(){
        var totalCheckboxes = $("input[name='update[]']").length;
        var totalCheckboxesChecked = $("input[name='update[]']:checked").length;

        if(totalCheckboxesChecked == totalCheckboxes){
            $("#checkall").prop("checked", true);
        }else{
            $("#checkall").prop("checked", false);
        }
    })

    

</script>
</body>
</html>






