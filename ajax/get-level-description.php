<?php

    include_once('../sys/core/init.inc.php');
    $common = new common();

    $departid = $_POST['depart'];   // department id

    $results = $common -> GetRows("SELECT * FROM tbl_user_level WHERE userLevelId='".$departid."'");

    foreach ($results as $row){
        $userid = $row['userLevelId'];
        $name = $row['userLevelDescription'];

        $users_arr[] = array("id" => $userid, "name" => $name);
    }

    // encoding array to json format    
    echo json_encode($users_arr); 
?> 