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

    /* Start ajax New User process */
    if(filter_has_var(INPUT_POST, 'btn-create-user')){
        try {
            $firstName = ucfirst(strtolower(trim($_POST['firstName'])));
            $lastName = ucfirst(strtolower(trim($_POST['lastName'])));
            $email = strtolower(trim($_POST['email']));
            $gender = trim($_POST['gender']);
            $phoneNumber = trim($_POST['phoneNumber']);
            $idNumber = trim($_POST['idNumber']);
            $userLevel = trim($_POST['userLevel']);

            $user_password = 'password';
            $password = md5($user_password);

            $response = array();

            // Check if email and password are correct 
            $query = $common -> Insert("
                INSERT INTO tbl_users (firstName, lastName, email, gender, phoneNumber, idNumber, pass, userLevel)
                VALUES ('".$firstName."', '".$lastName."','".$email."','".$gender."','".$phoneNumber."','".$idNumber."','".$password."','".$userLevel."')
            ");
            if(!$query){
                $response['status'] = 'error'; // could not create user
                $response['message'] = 'Sorry, Could not create new user'; 
            }else if($query){
                $response['status'] = 'success'; 
                $response['message'] = 'New user successfuly created'; 
            } 
            echo json_encode($response);
            exit;
        }catch(Exception $e){
            echo $e;
        }
    }
    /* End ajax New User process */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
            <?php echo $SystemName; ?> | Users 
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
                        Users
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create New Users</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" id="new-user-form">
                            <div id="errorDiv">
                                <!-- error will be shown here ! -->
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name" name="firstName" id="firstName">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" name="lastName" id="lastName">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control select2" name="gender" id="gender" style="width: 100%;">
                                            <option selected="selected" value="">--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" class="form-control" placeholder="Phone Number" name="phoneNumber" id="phoneNumber">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>ID Number</label>
                                        <input type="text" class="form-control" placeholder="ID Number" name="idNumber" id="idNumber">
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>User Role</label>
                                        <select class="form-control select2" style="width: 100%;" name="userLevel" id="userLevel">
                                            <option selected="selected" value="">-- None --</option>
                                            <?php 
                                                $results = $common -> GetRows("SELECT * FROM tbl_user_level");
                                                foreach ($results as $row){
                                                    ?>
                                                        <option value="<?php echo $row['userLevelId']; ?>" ><?php echo $row['userLevelName']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="help-block" id="error"></span>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-12">
                                    <div class="form-group" id="userRoleDescription">

                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-create-user" id="btn-create-user" >
                                        Create User
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </form>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
                        the plugin.
                    </div>
                    </div>
                    <!-- /.box -->
                </section>

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
        
        <!-- validate and submit the users form -->
        <script type="text/javascript">
        // valid email pattern
        var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        $.validator.addMethod("validemail", function( value, element ) {
            return this.optional( element ) || eregex.test( value );
        });

        // name validation
		var nameregex = /^[a-zA-Z_']+$/;

        $.validator.addMethod("validname", function( value, element ) {
            return this.optional( element ) || nameregex.test( value );
        });
        
        $('document').ready(function(){
             /* validation */
            $("#new-user-form").validate({
                rules:{
                    firstName:{
                        required: true,
                        validname: true,
                        minlength: 2
                    },
                    lastName:{
                        required: true,
                        validname: true,
                        minlength: 2
                    },
                    email:{
                        required: true,
                        validemail: true,
                        remote: {
                            url: "ajax/check-exists.php",
                            type: "post",
                            data: {
                                email: function() {
                                    return $( "#email" ).val();
                                }
                            }
                        }
                    },
                    gender:{
                        required: true
                    },
                    phoneNumber:{
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "ajax/check-exists.php",
                            type: "post",
                            data: {
                                phoneNumber: function() {
                                    return $( "#phoneNumber" ).val();
                                }
                            }
                        }
                    },
                    idNumber:{
                        required: true,
                        number: true,
                        minlength: 5,
                        maxlength: 15,
                        remote: {
                            url: "ajax/check-exists.php",
                            type: "post",
                            data: {
                                idNumber: function() {
                                    return $( "#idNumber" ).val();
                                }
                            }
                        }
                    },
                    userLevel:{
                        required: true
                    },
                },
                messages:{
                    firstName:{
                        required: "Please enter your First Name.",
                        validname: "Your First Name is invalid",
                        minlength: "First Name should be at least 2 letters",
                    },
                    lastName:{
                        required: "Please enter your Last Name.",
                        validname: "Your Last Name is invalid",
                        minlength: "Last Name should be at least 2 letters",
                    },
                    email:{
                        required: "Please enter your email address.",
                        validemail: "Please enter a valid email address.",
                        remote: "Email exists, try another one"
                    }, 
                    gender:{
                        required: "Please select a gender"
                    },
                    phoneNumber:{
                        required: "Phone Number is required",
                        number: "Phone number is invalid",
                        minlength: "Number seems short",
                        maxlength: "Number seems long",
                        remote: "Phone number already exists, try another one"
                    },
                    idNumber:{
                        required: "ID Number is required",
                        number: "ID Number is invalid",
                        minlength: "ID Number is short",
                        maxlength: "ID Number is too long",
                        remote: "ID Number exists, try another one"
                    },
                    userLevel:{
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

            /* Fetch user role, display user role description */
            $("#userLevel").change(function(){
                var deptid = $(this).val();
                if(deptid === ""){
                    $('#userRoleDescription').html('');
                }else{
                    $.ajax({
                        url: 'ajax/get-level-description.php',
                        type: 'post',
                        data: {depart:deptid},
                        dataType: 'json',
                        success:function(response){
                            var len = response.length;

                            $("#userRoleDescription").empty();
                            for( var i = 0; i<len; i++){
                                var id = response[i]['id'];
                                var name = response[i]['name'];
                                $('#userRoleDescription').html('<label>User Role Description</label><textarea class="form-control" readonly="readonly">'+name+'</textarea>');
                            }
                        }
                    });
                }
                
            });
            /* Fetch user role, display user role description */


            /* Create new user submit */
            function submitForm(){
                $.ajax({
                    //url: 'index.ajax.php',
                    type: 'POST',
                    data: $('#new-user-form').serialize(),
                    dataType: 'json'
                })
                .done(function(data){
                    $('#btn-create-user').html('<img src="ajax-loader.gif" style="margin: auto; width:30px;"> &nbsp; Processing...').prop('disabled', true);
                    $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', true);                  

                    setTimeout(function(){
                        if (data.status === 'success'){
                            $('#errorDiv').slideDown('fast', function(){
                                $("#btn-create-user").html('<img src="ajax-loader.gif" style="margin: auto; width:30px;"> &nbsp; Refreshing...');
                                $('#errorDiv').html('<div class="alert alert-success">'+data.message+'</div>');
                                $("#new-user-form").trigger('reset');
                                $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', false);
                                $('#btn-create-user').html('Create New User').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                        }else if (data.status === 'error'){
                            $('#errorDiv').slideDown('fast', function(){
                                $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
                                $("#new-user-form").trigger('reset');
                                $('input[type=email],input[type=text],input[type=tel],input[type=number],input[type=password],input[type=checkbox],#gender,#userLevel').prop('disabled', false);
                                $('#btn-create-user').html('Create New User').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                        }
                    },3000);
                })
                .fail(function(){
                    $("#login-form").trigger('reset');
                    alert('An unknown error occoured, Please try again Later...');
                });
            }
            /* Create new user */
        });

    </script>
	</body>
</html>