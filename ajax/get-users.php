<?php
    include_once('../sys/core/init.inc.php');
    $common = new common();
    $results = $common -> GetRows("SELECT * FROM tbl_users WHERE userLevel <> '0'");
    $total_rows = $common -> CCGetDBValue("SELECT COUNT(*) FROM tbl_users WHERE userLevel <> '0'");
    foreach ($results as $row){
        $id = $row['id'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $email = $row['email'];
        $gender = $row['gender'];
        $phoneNumber = $row['phoneNumber'];
        $idNumber = $row['idNumber'];

        $users_arr[] = array(
            "id" => $id, 
            "fname" => $firstName, 
            "lname" => $lastName, 
            "email" => $email,
            "gender" => $gender,
            "phoneNumber" => $phoneNumber,
            "idNumber" => $idNumber
        );
    }
    $show_arr = array(
        'data' => $users_arr,
    );
    // encoding array to json format    
    echo json_encode($show_arr); 
?> 