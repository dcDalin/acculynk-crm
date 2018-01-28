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

    /* Start ajax New Company process */
    if(filter_has_var(INPUT_POST, 'btn-create-company')){
        try {
            $imgFile = $_FILES['user_image']['name'];
            $tmp_dir = $_FILES['user_image']['tmp_name'];
            $imgSize = $_FILES['user_image']['size'];

            $upload_dir = 'user_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
            $userpic = rand(1000,1000000).".".$imgExt;

            $companyName = trim($_POST['companyName']);
            $companyEmail = trim($_POST['email']);
            $companyPhoneNumber = trim($_POST['companyPhone']);
            $companyWebsite = trim($_POST['companyWebsite']);
            $category = trim($_POST['category']);

            $response = array();
            
            // allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
                    move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                    
                    // Check if email and password are correct 
                    $query = $common -> Insert ("
                        INSERT INTO `tbl_companies` (`userPic`, `companyName`, `companyEmail`, `companyPhoneNumber`, `companyWebsite`, `category`) 
                        VALUES ('".$userpic."', ".$companyName."', '".$companyEmail."', '".$companyPhoneNumber."', '".$companyWebsite."', '".$category."')
                    ");
                    if(!$query){
                        $response['status'] = 'error'; // could not create user
                        $response['message'] = 'Sorry, Could not create new company'; 
                    }else if($query){
                        $response['status'] = 'success'; 
                        $response['message'] = 'New company successfuly created'; 
                    } 
				}
				else{
					$response['status'] = 'large'; // could not create user
                    $response['message'] = 'Sorry, Pic too large'; 
				}
			}
			else{
				$response['status'] = 'wrong'; // could not create user
                $response['message'] = 'Sorry, Wrong pic format'; 		
			}
            echo json_encode($response);
            exit;
        }catch(Exception $e){
            echo $e;
        }
    }
    /* End ajax New Company process */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
            <?php echo $SystemName; ?> | New Company 
        </title>
		<?php 
		include 'inc/inc.meta.php';
		?>
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.16/css/dataTables.bootstrap.min.css" />
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
                <section class="content" id="create-new-company">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create New Company</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" id="new-company-form" enctype="multipart/form-data">
                            <div id="errorDiv">
                                <!-- error will be shown here ! -->
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Company Logo</label>
                                        <input type="file" class="form-control" placeholder="Company Logo" name="user_image" accept="image/*" id="user_image">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Company Name" name="companyName" id="companyName">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" placeholder="Company Email" name="email" id="email">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" class="form-control" placeholder="Company Phone" name="companyPhone" id="companyPhone">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" placeholder="Website URL" name="companyWebsite" id="companyWebsite">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control select2" name="category" id="category" style="width: 100%;">
                                            <option selected="selected" value="">--</option>
                                            <option value="Service">Service</option>
                                            <option value="Merchandising">Merchandising</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                        </select>
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                
                                <!-- /.col -->
                                <div class="col-md-12">
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-create-company" id="btn-create-company" >
                                        Create New Company
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </form>
                    </div>
                </section>
			</div>
			<?php 
			include 'inc/inc.main-footer.php';
			?>
		<!-- Wrapper end div -->
		</div>

		<?php include 'inc/inc.loggedin.footer.meta.php'; ?>

        <!-- validate and submit the users form -->
        <script type="text/javascript">
            // valid email pattern
            var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            $.validator.addMethod("validemail", function( value, element ) {
                return this.optional( element ) || eregex.test( value );
            });

            // name validation
            var nameregex = /^[a-zA-Z0-9_\.\-\+ ]+$/;

            $.validator.addMethod("validname", function( value, element ) {
                return this.optional( element ) || nameregex.test( value );
            });
            
            $('document').ready(function(){
                /* validation */
                $("#new-company-form").validate({
                    rules:{
                        companyName:{
                            required: true,
                            validname: true,
                            minlength: 5
                        },
                        email:{
                            required: true,
                            validemail: true,
                        },
                        companyPhone:{
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        companyWebsite:{
                            required: true
                        },
                        category:{
                            required: true
                        },
                    },
                    messages:{
                        companyName:{
                            required: "Please enter your First Name.",
                            validname: "Your First Name is invalid",
                            minlength: "First Name should be at least 2 letters",
                        },
                        email:{
                            required: "Please enter your email address.",
                            validemail: "Please enter a valid email address.",
                            remote: "Email exists, try another one"
                        }, 
                        companyPhone:{
                            required: "Phone Number is required",
                            number: "Phone number is invalid",
                            minlength: "Number seems short",
                            maxlength: "Number seems long"
                        },
                        companyWebsite:{
                            required: "ID Number is required"
                        },
                        category:{
                            required: "Select a User Role"
                        }
                    },
                    errorPlacement : function(error, element) {
                        $(element).closest('.form-group').find('.help-block').html(error.html());
                    },
                    highlight : function(element) {
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').removeClass('has-error');
                        $(element).closest('.form-group').find('.help-block').html('');
                    },
                    submitHandler: submitForm
                });
                /* validation */

           
                /* Create new company submit */
                function submitForm(){
                    e.preventDefault();    
                    var formData = new FormData(this);
                    $.ajax({
                        //url: 'index.ajax.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false
                        beforeSend: function() {
                            $('#btn-create-company').html('<img src="ajax-loader.gif" style="margin: auto; width:30px;"> &nbsp; Processing...').prop('disabled', true);
                            $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', true); 
                        }
                    })
                    .done(function(data){
                        $('#btn-create-company').html('<img src="ajax-loader.gif" style="margin: auto; width:30px;"> &nbsp; Processing...').prop('disabled', true);
                        $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', true);                  

                        setTimeout(function(){
                            if (data.status === 'success'){
                                $('#errorDiv').slideDown('fast', function(){
                                    $("#btn-create-company").html('<img src="ajax-loader.gif" style="margin: auto; width:30px;"> &nbsp; Refreshing...');
                                    $('#errorDiv').html('<div class="alert alert-success">'+data.message+'</div>');
                                    $("#new-company-form").trigger('reset');
                                    $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', false);
                                    $('#btn-create-company').html('Create New Company').prop('disabled', false);
                                }).delay(3000).slideUp('fast');
                            }else if (data.status === 'error'){
                                $('#errorDiv').slideDown('fast', function(){
                                    $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
                                    $("#new-company-form").trigger('reset');
                                    $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', false);
                                    $('#btn-create-company').html('Create New User').prop('disabled', false);
                                }).delay(3000).slideUp('fast');
                            }
                        },3000);
                    })
                    .fail(function(){
                        $("#new-company-form").trigger('reset');
                        alert('An unknown error occoured, Please try again Later...');
                    });
               }
               /* Create new Company */
            });

        </script>

	</body>
</html>