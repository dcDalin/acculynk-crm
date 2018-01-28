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
            <?php echo $SystemName; ?> | View Contacts 
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
                        Contacts 
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content" id="view-contacts">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Contacts</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="load-contacts">
                            <!-- contacts will be loaded here -->
                        </div>
                    </div>
                </section>

                <section class="content" id="edit-contact" style="display:none">
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
                            <!-- Contacts will be loaded here -->
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
                readContacts(); /* it will load products when document loads */
                
                $(document).on('click', '#delete_contact', function(e){  
                    var contact_id = $(this).data("id");
                    SwalDelete(contact_id);
                    e.preventDefault();
                });

                $(document).on('click', '#edit_contact', function(e){
                    var contact_id = $(this).data('id');
                    $("#view-contacts").hide();
                    $("#edit-contact").show('slow');
                    showEditForm();
                    e.preventDefault();
                });
                
            });

            function SwalDelete(contact_id){
                swal({
                    title: 'Are you sure?',
                    text: "It will be deleted permanently!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    
                    preConfirm: function() {
                    return new Promise(function(resolve) {
                        
                        $.ajax({
                            url: 'view-contacts-delete.php',
                            type: 'POST',
                            data: 'deleteContact='+contact_id,
                            dataType: 'json'
                        })
                        .done(function(response){
                            swal('Deleted!', response.message, response.status);
                            readContacts();
                        })
                        .fail(function(){
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        });
                    });
                    },
                    allowOutsideClick: false			  
                });	
                
            }
            
            function readContacts(){
                $('#load-contacts').load('view-contacts-load.php');	
            }

            function showEditForm(){
                $('#load-edit-form').load('view-contacts-edit-form.php');	
            }
            
        </script>
	</body>
</html>