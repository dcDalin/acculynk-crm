<?php 
	error_reporting(0);
    //session_start();
    header('Cache-control: private'); // IE 6 FIX
    // always modified 
    header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    // HTTP/1.1 
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    // HTTP/1.0 
    header('Pragma: no-cache');

    /* Start Original Scripts */
    include_once('sys/core/init.inc.php');

	$common = new common();
	
	// check if user is logged in
    // If session is empty -> user is not logged in, redirect to login page
    if($_SESSION['UID'] == ''){
        header("Location: index"); /* Redirect browser */
        exit();
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
            <?php echo $SystemName; ?> | Profile 
        </title>
		<?php 
		include 'inc/inc.meta.php';
		?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div id="wrapper-logout" style="display:none; padding:30px;">
		</div>
		
		<div class="wrapper" id="wrapper">
			<?php 
			include 'inc/inc.main-header.php';
			?>
			<?php 
			include 'inc/inc.main-sidebar.php';
			?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">


			</div>
			<?php 
			include 'inc/inc.main-footer.php';
			?>
			<?php 
			include 'inc/inc.control-sidebar.php';
			?>
		<!-- Wrapper end div -->
		</div>

		<?php include 'inc/inc.loggedin.footer.meta.php'; ?>
	</body>
</html>