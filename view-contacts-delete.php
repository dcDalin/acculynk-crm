<?php
	
	header('Content-type: application/json; charset=UTF-8');
	
	$response = array();
	
	if ($_POST['deleteContact']) {
		
        include_once('sys/core/init.inc.php');
        
        $common = new common();
		
        $cId = $_POST['deleteContact'];
        
		$query = $common->Delete("DELETE FROM tbl_contact WHERE contact_id='".$cId."'");
		
		if ($query) {
			$response['status']  = 'success';
			$response['message'] = 'Contact Deleted Successfully ...';
		} else {
			$response['status']  = 'error';
			$response['message'] = 'Could not delete Contact';
		}
		echo json_encode($response);
    } 

?>