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

    // Instanciate class common
    $common = new common();

    // check if user is logged in
    // If session is not empty -> user is logged in, redirect to dashboard
    if(!$_SESSION['UID'] == ''){
        header("Location: dashboard"); /* Redirect browser */
        exit();
    }
    if(empty($_GET['id']) && empty($_GET['code'])){
        header("Location: index"); /* Redirect browser */
        exit();
    }

    $checkCode = $common -> GetRows("SELECT * FROM tbl_users WHERE tokenCode='".$_GET['code']."'");
    if(!$checkCode){
        header("Location: index"); /* Redirect browser */
        exit();
    }

    /* Start reset password process */
    if(isset($_GET['id']) && isset($_GET['code'])){
        if(filter_has_var(INPUT_POST, 'btn-reset-pass')){
            $id = base64_decode($_GET['id']);
            $code = $_GET['code'];

            $password = trim($_POST['password']);
            $pass = md5($password);
            
            $stmt = $common -> GetRows("SELECT * FROM tbl_users WHERE id='".$id."' AND tokenCode='".$code."'");

            $response = array();

            if($stmt){
                $updatePass = $common -> GetRows("UPDATE tbl_users SET pass='".$pass."', tokenCode='' WHERE id='".$id."'");
                $response['status'] = 'success'; 
                $response['message'] = 'Success, password changed'; 
            }else if(!$stmt){
                $response['status'] = 'error'; 
                $response['message'] = 'Sorry, password not changed'; 
            }
            echo json_encode($response);
            exit;
        }
    }
    /* End reset password process */
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
        <div class="login-box" id="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b><?php echo $SystemName; ?></b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Reset Password</p>
                <form class="form-signin" method="post" id="reset-pass-form">
                    <div id="errorDiv">
                        <!-- error will be shown here ! -->
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <span class="help-block" id="error"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" id="cpassword">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
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
            $("#reset-pass-form").validate({
                rules:{
                    password:{
                        required: true,
                        minlength: 6,
                        maxlength: 15
                    },
                    cpassword:{
                        required: true,
                        equalTo: "#password"
                    },
                },
                messages:{
                    password:{
                        required: "Please enter your new password.",
                        minlength: "Password should be at least 6 characters",
                        maxlength: "Password should be less than 15"
                    },
                    cpassword:{
                        required: "Please retype your password.",
                        equalTo: "Passwords don't match"
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

            /* login submit */
            function submitForm(){
                $.ajax({
                    //url: 'index.ajax.php',
                    type: 'POST',
                    data: $('#reset-pass-form').serialize(),
                    dataType: 'json'
                })
                .done(function(data){
                    $('#btn-reset-pass').html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Processing...').prop('disabled', true);
                    $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', true);
                    
                    setTimeout(function(){
                        if (data.status === 'success'){
                            $("#btn-reset-pass").html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Redirecting...');
                            swal("Success!", data.message, "success");
                            setTimeout(' window.location.href = "dashboard"; ',3000);
                        }else if (data.status === 'error'){
                            $('#errorDiv').slideDown('fast', function(){
                                swal("Error!", data.message, "error");
                                $("#reset-pass-form").trigger('reset');
                                $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', false);
                                $('#btn-reset-pass').html('Login').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                        }
                    },3000); 
                })
                .fail(function(){
                    $("#reset-pass-form").trigger('reset');
                    alert('An unknown error occoured, Please try again Later...');
                });
            }
            /* login submit */
        });

    </script>



    <?php  
        include 'inc/inc.final.footer.php';
    ?>