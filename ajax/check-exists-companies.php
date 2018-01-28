<?php
    include_once('../sys/core/init.inc.php');
    $common = new common();

	if ( isset($_REQUEST['email']) && !empty($_REQUEST['email']) ) {

		$email = trim($_REQUEST['email']);

        $results = $common -> GetRows("SELECT companyEmail FROM tbl_companies WHERE companyEmail='".$email."'");

		if ($results) {
			echo 'false'; // email already taken
		} else {
			echo 'true';
		}
	}

	if ( isset($_REQUEST['companyPhone']) && !empty($_REQUEST['companyPhone']) ) {

		$phoneNumber = trim($_REQUEST['companyPhone']);

        $phone = $common -> GetRows("SELECT companyPhoneNumber FROM tbl_companies WHERE companyPhoneNumber='".$phoneNumber."'");

		if ($phone) {
			echo 'false'; // already taken
		} else {
			echo 'true';
		}
	}

	if ( isset($_REQUEST['companyWebsite']) && !empty($_REQUEST['companyWebsite']) ) {

		$companyWebsite = trim($_REQUEST['companyWebsite']);

        $id = $common -> GetRows("SELECT companyWebsite FROM tbl_companies WHERE companyWebsite='".$companyWebsite."'");

		if ($id) {
			echo 'false'; // already taken
		} else {
			echo 'true';
		}
	}
?>