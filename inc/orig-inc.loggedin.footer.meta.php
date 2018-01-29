
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="assets/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
<!-- iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
	Both of these plugins are recommended to enhance the
	user experience.
-->
<!-- Bootstrap Table js -->
<script src="bootstrap-tables/bootstrap-table.min.js"></script>

<!-- Sweet alert js -->
<script type="text/javascript" src="assets/swal2/sweetalert2.min.js"></script>

<!-- jQuery validator -->
<script src="assets/jquery/dist/jquery.validate.js"></script>

<!-- Log out script -->
<script> 
    $(document).ready(function(){
        $("#btn-logout").click(function(){

            
            // $("p").hide();
            $.ajax({
                url: 'logout.php',
                type: 'POST',
                dataType: 'json'
            })
            .done(function(data){
                $("#wrapper").slideUp('slow');
                $("#wrapper-logout").slideDown('slow');
                $("#wrapper-logout").html('<h5>Saving... <img src="ajax-loader.gif" style="margin: auto; width:30px;"></h5>');
                setTimeout(function(){
                    if (data.status === 'success'){
                        $("#wrapper-logout").html('<h5>Logging out... <img src="ajax-loader.gif" style="margin: auto; width:30px;"></h5>');
                        setTimeout(' window.location.href = "index"; ',3000);
                    }else{
                        $("#wrapper-logout").html('<h5>Failed... <img src="ajax-loader.gif" style="margin: auto; width:30px;"></h5>');
                        setTimeout(' window.location.href = "profile"; ',3000);
                    }
                },3000);
            })
            .fail(function(){
                alert('Could not log you out, please try again...');
            });
        });
    });
</script>
<!-- First initialization of the below scripts found in the inc.main-header.php file, they can be
    reinitialized anywhere in the page, often above a form  
-->
<script src="<?php echo $requiredJS; ?>"></script>
<script src="<?php echo $requiredJS2; ?>"></script>
<script src="<?php echo $requiredJS3; ?>"></script>