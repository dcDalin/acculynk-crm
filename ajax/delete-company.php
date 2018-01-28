<?php
	
	header('Content-type: application/json; charset=UTF-8');
    
    include_once('../sys/core/init.inc.php');
    $common = new common();

	$response = array();
	
	if ($_POST['delete']) {
		
        $pid = intval($_POST['delete']);
        $stmt = $common -> GetRows("DELETE FROM tbl_companies WHERE id = '".$pid."'");
		
		if ($stmt) {
			$response['status']  = 'success';
			$response['message'] = 'Product Deleted Successfully ...';
		} else if(!$stmt) {
			$response['status']  = 'error';
			$response['message'] = 'Unable to delete product ...';
		}
		echo json_encode($response);
	}