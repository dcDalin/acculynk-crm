<?php
    session_start();
    include_once('sys/core/init.inc.php');
    $common = new common();

    if(!$_SESSION['UID'] = ''){
        $response['status'] = 'success';

        // Change online status to 'N' i.e. Offline 
        $onlineStatus = $common -> GetRows("
            UPDATE tbl_users SET online = 'N' WHERE id='".$_SESSION['UID']."'
        ");

        unset($_SESSION['userFirstName']);
        unset($_SESSION['userLastName']);
        unset($_SESSION['userEmail'];)
        unset($_SESSION['userGender'];)
        unset($_SESSION['userPhoneNumber'];)
        unset($_SESSION['userIdNumber']);
        unset($_SESSION['userPhoto']);
        unset($_SESSION['userLevel']);
        unset($_SESSION['userOnline']);
        unset($_SESSION['UID']);

        session_destroy();
    }else{
        header("Location: index"); /* Redirect browser */
        exit();
    }
    echo json_encode($response);
    exit;
?>