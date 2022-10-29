<?php
// include "sessionfile.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="search.css">
  

    <title>Search For Data</title>
</head>
<body>

<style>
    *{
        font-family: "product sans medium";
    }
    .error{
        background-color: red;
        color: white;
        width: 300px;
        padding: 20px;
        margin: 0 auto;
        position: absolute;
        top: 200px;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>
    

<div class="search-box">
    <form action="search.php" method="post" class="search-box_form">
        <input type="text" name="search" id="search_box">
        <button type="submit" name="submit_b">Get Info</button>
    </form>
</div>

<div class="box" id="show-list">
    <!-- <a href="" class="link">List 1</a> -->
</div>



<div class="parent-form">

<?php 
include "sessionfile.php";



?>
    <div class="parent-form-box">
        <form action="lab.php" method="post" class="lab-forms">
        <div class="align-box"> 
            <?php
            // session_start();
            include "function.php";
            include "covid.php";

            // echo $_SESSION["epid_no"];
        
            if(isset($_POST["submit_b"])){
                $data = $_POST["search"];
                $sql = "SELECT * FROM travel_info WHERE full_name='$data' AND display='yes'";
                $sql2 = "SELECT epid_no FROM line_list_data WHERE names='$data'";
                $result = mysqli_query($conn,$sql);
                $result2 = mysqli_query($conn,$sql2);
                $ep = "";

                
                    while($row2 = mysqli_fetch_array($result2)){

                        $ep = $row2["epid_no"];

                       echo "hello";

                    }

                if(mysqli_num_rows($result) > 0){
                    
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){


                        $fullName = $row["full_name"];
                        $fone= $row["phone_number"];
                        $alt_no = $row["alternative_number"];
                        $nok_no = $row["nok_number"];
                        $ppid = $row["passport_id"];
                        $arrive = $row["arrival_date"];
                        $dob = $row["dob"];
                        $email = $row["email"];
                        $gender = $row["gender"];
                        $addy = $row["address"];
                        $d_country = $row["departure_country"];
                        $v_status = $row["vaccination_status"];
                    
                        $pattern = '/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/';
                        $dob = preg_replace($pattern, "-", $dob);

                        // echo $email;



                        $split = explode("-", $dob);
                        
                        // $gg = date("m", strtotime($split[1]));
                        $nom = "";

                        if($split[2] < 20){
                            $nom = 20;
                        }else{

                            $nom = 19;
                        }

                        if(strlen($split[2])==4){
                            $nom = "";

                            echo $nom;
                        }

                        $birthyear = $nom."".$split[2]; 

                        $birthyear;
                        
                        $currentyear = date("Y");

                        $check = time();

                        $check2 = $split[0]."-".$split[1]."-".date("y");

                        $lcyear = date("y");
                        $ucmonth = date("M");
                        $lcday = date("d");

                        $samplingdate = $lcday."-".$ucmonth."-".$lcyear;

                     
                        $samplingtime = date("H:i A");

                        if($check >= strtotime($check2)){
                            $age = $currentyear - $birthyear;

                            // echo $birthyear;
                        }else{
                            $currentyear = $currentyear - 1;
                            $age = $currentyear - $birthyear;
                        }

                        if($birthyear==1930 || $birthyear==1931){

                            $_SESSION["error_message"] = "Invalid date of birth. Ask customer for year of birth and age";
                            echo error_message(); 
                            // Redirect_to("search.php");
                            

                            $age = "";
                            $dob = "";
                        }
                        
                    }
                }else{

                    $_SESSION["error_message"] = "You have not selected any record";
                    echo error_message();
                }
            }
            ?>
            <!-- 
                1. display only the data needed and then insert the others into the database
                2. create a submitted column that only accepts yes or no. submitted names disappears from column
                3. INCLUDE EXPORT FOR GENOMIC SURVEILLANCE -->
            
            <input type="text" name="epid_no" id="search_box" placeholder="Epid Number">
            
            <input type="text" name="fullname" id="search_box" value="<?php echo (isset($fullName)) ? $fullName : ''; ?>" placeholder="Full Name">
            <input type="text" name="fone" id="search_box" value="<?php echo (isset($fone)) ? $fone : ''; ?>" placeholder="Phone Number">
            <input type="text" name="age" id="search_box" value="<?php echo (isset($age)) ? $age : ''; ?>" placeholder="Age">
            <input type="text" name="samplingdate" id="search_box" value="<?php echo (isset($samplingdate)) ? $samplingdate : ''; ?>" placeholder="Sampling Date e.g 05-Apr-22">
            <input type="text" name="samplingtime" id="search_box" value="<?php echo (isset($samplingtime)) ? $samplingtime : ''; ?>" placeholder="Sampling Time">
            

            <input type="text" name="dob" id="search_box" value="<?php echo (isset($dob)) ? $dob : ''; ?>" placeholder="Date of Birth e.g 22-Nov-1993">
            <input type="text" name="email" id="search_box" value="<?php echo (isset($email)) ? $email : ''; ?>" placeholder="Email">
            <input type="text" name="gender" id="search_box" value="<?php echo (isset($gender)) ? strtoupper($gender) : ''; ?>" placeholder="Gender">
            <input type="text" name="addy" id="search_box" value="<?php echo (isset($addy)) ? strtoupper($addy) : ''; ?>" placeholder="Address">
        </div>
            <label class="label-select">Select Traveller Type
            <select name="travel_type" id="travel-type">
                <option value="">Select an option</option>
                <option value="INBOUND">INBOUND</option>
                <option value="OUTBOUND">OUTBOUND</option>
                <option value="NON-TRAVELLER">NON-TRAVELLER</option>
            </select>
            </label>

            <div class="inbound hide-travel-type" id="hide-travel-type">
                
                    <select name="test-day" id="test-day-select">
                        <option value="">Select a test day</option>
                        <option value="Day 2">Day 2</option>
                        <option value="Day 7">Day 7</option>
                    </select>
                
                <input type="text" name="arrive" id="search_box" value="<?php echo (isset($arrive)) ? $arrive : ''; ?>" placeholder="Arrival Date">
                <input type="text" name="passport" id="search_box" value="<?php echo (isset($ppid)) ? strtoupper($ppid) : ''; ?>" placeholder="Passport ID">
                <input type="text" name="departure_country" id="search_box" value="<?php echo (isset($d_country)) ? strtoupper($d_country) : ''; ?>" placeholder="Departure Country">
                <input type="text" name="vaccine" id="search_box" value="<?php echo (isset($v_status)) ? $v_status : ''; ?>" placeholder="Vaccination Status">
                <input type="text" name="portal-pay" value="NITP">
            </div>
            <div class="non-traveller hide-travel-type">
                <label for="" class="label-dropdown">
                    <select name="payment-type" id="payment" >
                        <option value="">Select Payment Type</option>
                        <option value="hmo">HMO</option>
                        <option value="private-paying">Private Paying</option>
                    </select>
                </label>
            </div>

            <div class="hmo payment-type">
                <input type="text" name="hmo-receipt-number" placeholder="Name of Institution">
            </div>
            <div class="private-paying payment-type">
                <input type="text" name="private-receipt-number" placeholder="Receipt Number">
            </div>
            <div class="outbound hide-travel-type">
            <input type="text" name="passport" id="search_box" placeholder="Passport Number" value="<?php echo (isset($ppid)) ? strtoupper($ppid) : ''; ?>">
            <input type="text" name="destination" id="search_box" placeholder="Travel Destination">
            <input type="text" name="travel-date" id="search_box" placeholder="Travel Date">
            <input type="text" name="travel-time" id="search_box" placeholder="Travel Time">
            <input type="text" name="receipt-number" placeholder="Receipt Number">
            </div>


            
            <button type="submit" name="submitty" class="clicky">Collect Sample</button>
        

        </form>
    </div>

    
</div>

<script type="text/javascript">
   
   $(document).ready(function () {
    $("#search_box").keyup(function () {
        var search = $(this).val();

        if (search != "") {
        $.ajax({
            url: "search-data.php",
            method: "post",
            data: { query: search },
            success: function (response) {
            $("#show-list").html(response);
            },
        });
        } else {
        $("#show-list").html("");
        }
    });
    $(document).on("click", "a", function () {
        $("#search_box").val($(this).text());
        $("#show-list").html("");
        document.querySelector("#show-list").style.display = "none";
    });
});
    let search = document.querySelector("#search_box");
let showbox = document.querySelector("#show-list");


search.addEventListener("keyup", function (e) {

    if(search !== ""){
        showbox.style.display = "block";
    }
    
    console.log(search.value.length);
    if(search.value.length==0){
        showbox.style.display = "none";
    }
});

</script>

</body>

<script src="functionality.js"></script>


</html>