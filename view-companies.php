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
    if($_SESSION['userLevel'] == '1'){
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
            <?php echo $SystemName; ?> | View Companies 
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Companies 
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content" id="view-companies">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Companies</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="load-companies">
                            <!-- Companies will be loaded here -->
                        </div>
                    </div>
                </section>

                <section class="content" id="edit-company" style="display:none">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Company</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                    <div class="box-body">
                        <div id="load-edit-form">
                            <!-- Edit company form will be loaded here -->
                        </div>
                    </div>
                </section>
			</div>
			<?php 
			include 'inc/inc.main-footer.php';
			?>
		<!-- Wrapper end div -->
		</div>

        <?php include 'inc/inc.loggedin.footer.meta.php'; ?>

        <script>
            $(document).ready(function(){
                readCompanies(); /* it will load products when document loads */
            });

            function readCompanies(){
                $('#load-companies').load('view-companies-load.php');	
            }
        </script>
	</body>
</html>