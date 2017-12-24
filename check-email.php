<?php

    include_once('sys/core/init.inc.php');
    $common = new common();

	if ( isset($_REQUEST['email']) && !empty($_REQUEST['email']) ) {

		$email = trim($_REQUEST['email']);

        $results = $common -> GetRows("SELECT email FROM tbl_users WHERE email='".$email."'");

		if ($results) {
			echo 'false'; // email already taken
		} else {
			echo 'true';
		}
	}
?>