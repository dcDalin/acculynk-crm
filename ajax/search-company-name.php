<?php

    include_once('../sys/core/init.inc.php');
    $common = new common();

    $keyword = trim($_REQUEST['term']); // this is user input

    $sugg_json = array();    // this is for displaying json data as a autosearch suggestion
    $json_row = array();     // this is for stroring mysql results in json string


    $keyword = preg_replace('/\s+/', ' ', $keyword); // it will replace multiple spaces from the input.

    $query = $common -> GetRows("
        SELECT id, companyName FROM tbl_companies WHERE companyName LIKE '%".$keyword."%'
    ");

    if($query){
        foreach($query AS $row) {
            $json_row["id"] = $row['id'];
            $json_row["value"] = $row['id'];
            $json_row["label"] = $row['companyName']; 
            array_push($sugg_json, $json_row); 
        }      
    }else if(!$query){
        $json_row["id"] = "#";
        $json_row["value"] = "";
        $json_row["label"] = "Nothing Found!";
        array_push($sugg_json, $json_row);
    }

    $jsonOutput = json_encode($sugg_json, JSON_UNESCAPED_SLASHES); 
    print $jsonOutput;

?>