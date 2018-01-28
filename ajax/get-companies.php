<?php
    include_once('../sys/core/init.inc.php');
    $common = new common();
    $results = $common -> GetRows("SELECT * FROM tbl_companies ORDER BY id DESC");
    $total_rows = $common -> CCGetDBValue("SELECT COUNT(*) FROM tbl_companies");
    foreach ($results as $row){
        $id = $row['id'];
        $companyName = $row['companyName'];
        $companyEmail = $row['companyEmail'];
        $companyPhoneNumber = $row['companyPhoneNumber'];
        $companyWebsite = $row['companyWebsite'];
        $category = $row['category'];

        $users_arr[] = array(
            "id" => $id, 
            "companyName" => $companyName, 
            "companyEmail" => $companyEmail, 
            "companyPhoneNumber" => $companyPhoneNumber,
            "companyWebsite" => $companyWebsite,
            "category" => $category
        );
    }
    $show_arr = array(
        'total' => $total_rows,
        'data' => $users_arr,
    );
    // encoding array to json format    
    echo json_encode($show_arr); 
?> 