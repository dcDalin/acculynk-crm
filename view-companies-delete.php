<?php
	
	header('Content-type: application/json; charset=UTF-8');
	
	$response = array();
	
	if ($_POST['deleteCompany']) {
		
        include_once('sys/core/init.inc.php');
        
        $common = new common();
		
        $cId = $_POST['deleteCompany'];
        
		$query = $common->Delete("DELETE FROM tbl_companies WHERE id='".$cId."'");
		
		if ($query) {
			$response['status']  = 'success';
			$response['message'] = 'Company Deleted Successfully ...';
		} else {
			$response['status']  = 'error';
			$response['message'] = 'Could not delete Company';
		}
		echo json_encode($response);
    } 

?>