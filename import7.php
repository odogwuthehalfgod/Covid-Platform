<?php
include "covid.php";


if(isset($_POST["submit_file"])){
    $file = $_FILES["file"]["tmp_name"];

    $file_open = fopen($file,"r");

    $skip = 0;

    while(($csv = fgetcsv($file_open,1000,","))!==false){
        $skip++;

        if($skip > 1){

        $fullname = strtoupper($csv[2]);

        $phone_number =$csv[3];

        $alternative_number = $csv[4];

        $email = $csv[5];
        $nok_number = $csv[6];

        $passport_id = $csv[7];

        $appointment_date = $csv[8];
        $arrival_date = $csv[10];

        $dob = $csv[11];

        $gender = $csv[12];

        $address = $csv[13];

        $departure_country = $csv[14];

        $vaccine_status = $csv[16];


    

      

        // echo $fullname;

        $sql = "INSERT INTO travel_info (`full_name`, `phone_number`, `alternative_number`,`nok_number`, `passport_id`,`arrival_date`,`dob`,`appointment_date`,`email`,`gender`,`address`,`departure_country`,`vaccination_status`, `display`) 
        values ('$fullname','$phone_number','$alternative_number','$nok_number','$passport_id','$arrival_date','$dob','$appointment_date','$email','$gender','$address','$departure_country','$vaccine_status','yes')";

        $result = mysqli_query($conn,$sql);

        // if(!$result){
        //     echo "Upload failed";
        // }else{
        //     echo "Upload Successful";
        // }
        
    }

}

    // $split = explode("-", $arrival_date);

    // $nom = 20;

    // $monthly = date("m", strtotime($split[1]));
    

    // $newstring = $nom."".$split[2]."".$monthly."".$split[0];
    // print_r($monthly);
    // echo $newstring;
    // echo $split[1];



    if(!$result){
        echo "upload failed";
    }else{
        echo "uploaded successfully";
    }

   
}

?>