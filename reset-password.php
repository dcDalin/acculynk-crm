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
    // If session is not empty -> user is logged in, redirect to profile page
    if(!$_SESSION['UID'] == ''){
        header("Location: profile"); /* Redirect browser */
        exit();
    }

    if(filter_has_var(INPUT_POST, 'btn-reset-pass')){
        try {
            $email = trim($_POST['email']);

            $response = array();

            // Check if email exists
            $getALevel = $common -> GetRows("
                SELECT * FROM tbl_users WHERE email='".$email."' AND isActive=1 LIMIT 1
            ");
            if(!$getALevel){
                $response['status'] = 'error'; // Email not found
                $response['message'] = 'Sorry, email address doesn\'t exist'; 
            }else if($getALevel){
                foreach($getALevel as $A){
                    $_SESSION['resetID'] = $A["id"];
                    $_SESSION['resetFirstName'] = $A["firstName"];
                }
                
                $userFirstName = $_SESSION['resetFirstName'];
                $id = base64_encode($_SESSION['resetID']);
                $code = md5(uniqid(rand()));

                $updateTokenCode = $common -> GetRows("
                    UPDATE tbl_users SET tokenCode = '".$code."' WHERE email='".$email."'
                ");
                if(!$updateTokenCode){

                    $response['status'] = 'success'; // Log in successful
                    $response['message'] = 'Check your email for reset link'; 

                    $message= "
                        Hello $userFirstName
                        <br /><br />
                        Want to reset your password? You do so by clicking the link below
                        <br /><br />
                        Click Following Link To Reset Your Password 
                        <br /><br />
                        <a href='http://localhost/acculynk-crm/resetpass?id=$id&code=$code'>click here to reset your password</a>
                        <br /><br />
                        thank you :)
                    ";
                    $subject = "Password Reset";
            
                    $common->send_mail($email,$message,$subject);
                }else{
                    $response['status'] = 'unknown'; // Log in successful
                    $response['message'] = 'Unknown error occured'; 
                }                
            } 
            echo json_encode($response);
            exit;
        }catch(Exception $e){
            echo $e;
        }
    }
    /* End ajax login process */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php echo $SystemName; ?> | Reset Password 
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <?php 
            include 'inc/inc.meta.php';
        ?>
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" >
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b><?php echo $SystemName; ?></b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Reset Password</p>
                <form class="form-signin" method="post" id="reset-password-form">
                    <div id="errorDiv">
                        <!-- error will be shown here ! -->
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <span class="help-block" id="error"></span>
                    </div>
                    
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-6" style="float:right" id="btn-reset-pass-div">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-reset-pass" id="btn-reset-pass" >
                                Reset Password
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            <div id="back-to-login">
                <a href="index">Login instead</a><br>
            </div>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->


    <?php  
        include 'inc/inc.footer.php';
    ?>

    <script type="text/javascript">
        // valid email pattern
        var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        $.validator.addMethod("validemail", function( value, element ) {
            return this.optional( element ) || eregex.test( value );
        });
        
        $('document').ready(function(){
             /* validation */
            $("#reset-password-form").validate({
                rules:{
                    password:{
                        required: true,
                        minlength: 6,
                        maxlength: 15
                    },
                    email:{
                        required: true,
                        validemail: true
                    },
                },
                messages:{
                    password:{
                        required: "Please enter your password.",
                        minlength: "Password should be at least 6 characters",
                        maxlength: "Password should be less than 15"
                    },
                    email:{
                        required: "Please enter your email address.",
                        validemail: "Please enter a valid email address."
                    }, 
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

            /* reset password submit */
            function submitForm(){
                $.ajax({
                    //url: 'index.ajax.php',
                    type: 'POST',
                    data: $('#reset-password-form').serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-reset-pass').html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Connecting...').prop('disabled', true);
                        $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', true);
                        $("#back-to-login").slideUp('fast');
                        $("#remember-me").slideUp('fast');
                    },
                })
                .done(function(data){
                    $('#btn-reset-pass').html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Sending...').prop('disabled', true);                  

                    setTimeout(function(){
                        if (data.status === 'success'){
                            $("#btn-reset-pass").html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Redirecting...');
                            $('#errorDiv').slideDown('fast', function(){
                                $('#errorDiv').html('<div class="alert alert-success">'+data.message+'</div>');
                                $("#reset-password-form").trigger('reset');
                                $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', false);
                                $('#btn-reset-pass').html('Reset Password').prop('disabled', false);
                            }).delay(4000).slideUp('fast');

                            setTimeout(' window.location.href = "index"; ',4000);
                        }else if (data.status === 'error'){
                            $('#errorDiv').slideDown('fast', function(){
                                $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
                                $("#reset-password-form").trigger('reset');
                                $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', false);
                                $('#btn-reset-pass').html('Reset Password').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                            $("#back-to-login").slideDown('fast');
                            $("#remember-me").slideDown('fast');
                        }else if (data.status === 'unknown'){
                            $('#errorDiv').slideDown('fast', function(){
                                $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
                                $("#reset-password-form").trigger('reset');
                                $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', false);
                                $('#btn-reset-pass').html('Reset Password').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                            $("#back-to-login").slideDown('fast');
                            $("#remember-me").slideDown('fast');
                        }
                    },3000);
                })
                .fail(function(){
                    $("#reset-password-form").trigger('reset');
                    alert('An unknown error occoured, Please try again Later...');
                });
            }
            /* reset password submit */
        });

    </script>



    <?php  
        include 'inc/inc.final.footer.php';
    ?>