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

    $yasavedemail = $_COOKIE['emailyako'];
    $yasavedepassword = $_COOKIE['ingiamsee'];
    /* Start ajax login process */
    if(filter_has_var(INPUT_POST, 'btn-login')){
        try {
            $user_email = strtolower(trim($_POST['email']));
            $user_password = trim($_POST['password']);

            $password = md5($user_password);

            $response = array();

            // Check if email and password are correct 
            $getALevel = $common -> GetRows("
                SELECT * FROM tbl_users WHERE email='".$user_email."' AND pass='".$password."' and isActive=1
            ");
            if(!$getALevel){
                $response['status'] = 'error'; // Could not log in
                $response['message'] = 'Sorry, wrong email and or password'; 
            }else if($getALevel){
                $response['status'] = 'success'; // Log in successful

                foreach($getALevel as $A){
                    $_SESSION['UID'] = $A["id"];
                    $_SESSION['userFirstName'] = $A["firstName"];
                    $_SESSION['userLastName'] = $A["lastName"];
                    $_SESSION['userEmail'] = $A["email"];
                    $_SESSION['userGender'] = $A["gender"];
                    $_SESSION['userPhoneNumber'] = $A["phoneNumber"];
                    $_SESSION['userIdNumber'] = $A["idNumber"];
                    $_SESSION['userPhoto'] = $A["photo"];
                    $_SESSION['userLevel'] = $A["userLevel"];
                    $_SESSION['userOnline'] = $A["online"];
                }
                // Change online status to 'Y' i.e. Yes 
                $onlineStatus = $common -> GetRows("
                    UPDATE tbl_users SET online = 'Y' WHERE id='".$_SESSION['UID']."'
                ");
                // Set Login Cookies
                if($_POST['autologin'] == 1) {
                    $year = time() + 31536000;
                    setcookie('emailyako', $Uname_Email, $year);
                    setcookie('ingiamsee', $_POST['password'], $year);
                }else{
                    if(isset($_COOKIE['emailyako'])){
                        $past = time() - 100;
                        setcookie('emailyako', gone, $past);
                        setcookie('ingiamsee', gone, $past);
                    }
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
            <?php echo $SystemName; ?> | Login 
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
                <p class="login-box-msg">Log In</p>
                <form class="form-signin" method="post" id="login-form">
                    <div id="errorDiv">
                        <!-- error will be shown here ! -->
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <span class="help-block" id="error"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <span class="help-block" id="error"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6" id="remember-me">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="autologin" id="autologin" value="1" <?php if (isset($_COOKIE['ingiamsee'])) { echo 'checked'; } ?> > Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6" style="float:right" id="btn-login-div">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-login" id="btn-login" >
                                Log In
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            <div id="forgot-password">
                <a href="reset-password">I forgot my password</a><br>
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
            $("#login-form").validate({
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

            /* login submit */
            function submitForm(){
                $.ajax({
                    //url: 'index.ajax.php',
                    type: 'POST',
                    data: $('#login-form').serialize(),
                    dataType: 'json'
                })
                .done(function(data){
                    $('#btn-login').html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Processing...').prop('disabled', true);
                    $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', true);
                    $("#forgot-password").slideUp('fast');
                    $("#remember-me").slideUp('fast');
                    

                    setTimeout(function(){
                        if (data.status === 'success'){
                            $("#btn-login").html('<img src="ajax-loader.gif" style="margin: auto; width:30%;"> &nbsp; Redirecting...');
                            setTimeout(' window.location.href = "dashboard"; ',3000);
                        }else if (data.status === 'error'){
                            $('#errorDiv').slideDown('fast', function(){
                                $('#errorDiv').html('<div class="alert alert-danger">'+data.message+'</div>');
                                $("#login-form").trigger('reset');
                                $('input[type=email],input[type=password],input[type=checkbox]').prop('disabled', false);
                                $('#btn-login').html('Login').prop('disabled', false);
                            }).delay(3000).slideUp('fast');
                            $("#forgot-password").slideDown('fast');
                            $("#remember-me").slideDown('fast');
                        }
                    },3000);
                })
                .fail(function(){
                    $("#login-form").trigger('reset');
                    alert('An unknown error occoured, Please try again Later...');
                });
            }
            /* login submit */
        });

    </script>



    <?php  
        include 'inc/inc.final.footer.php';
    ?>