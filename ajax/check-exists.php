<?php
    include_once('../sys/core/init.inc.php');
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

	if ( isset($_REQUEST['phoneNumber']) && !empty($_REQUEST['phoneNumber']) ) {

		$phoneNumber = trim($_REQUEST['phoneNumber']);

        $phone = $common -> GetRows("SELECT phoneNumber FROM tbl_users WHERE phoneNumber='".$phoneNumber."'");

		if ($phone) {
			echo 'false'; // already taken
		} else {
			echo 'true';
		}
	}

	if ( isset($_REQUEST['idNumber']) && !empty($_REQUEST['idNumber']) ) {

		$idNumber = trim($_REQUEST['idNumber']);

        $id = $common -> GetRows("SELECT idNumber FROM tbl_users WHERE idNumber='".$idNumber."'");

		if ($id) {
			echo 'false'; // already taken
		} else {
			echo 'true';
		}
	}
?>