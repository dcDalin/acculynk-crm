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
                            <table data-toggle="table" id="table"
                                data-height="300"
                                data-url="ajax/get-companies.php"
                                data-query-params="queryParams"
                                data-pagination="true"
                                data-on="true"
                                data-search="true"
                                data-show-refresh="true"
                                data-height="300">
                                <thead>
                                <tr>
                                    <th data-field="companyName">Company Name</th>
                                    <th data-field="companyEmail">Email</th>
                                    <th data-field="companyPhoneNumber">Phone Number</th>
                                    <th data-field="companyWebsite">Website</th>
                                    <th data-field="category">Category</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </section>

                <section class="content" id="edit-company" >
                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Company</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                    <div class="box-body">
                    <div class="box-body">
                    <form method="post" id="new-company-form">
                        <div id="errorDiv">
                            <!-- error will be shown here ! -->
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Company Name" name="companyName" id="companyName" value="<?php echo $companyName; ?>">
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
            function queryParams() {
                return {
                    type: 'owner',
                    sort: 'updated',
                    direction: 'desc',
                    per_page: 100,
                    page: 1
                };
            }

            function actionFormatter(value, row, index) {
                return [
                    '<a class="like" id="like" href="javascript:void(0)" title="Like">',
                    '<i class="glyphicon glyphicon-heart"></i>',
                    '</a>',
                    '<a class="edit ml10" href="javascript:void(0)" title="Edit">',
                    '<i class="glyphicon glyphicon-edit"></i>',
                    '</a>',
                    '<a class="remove ml10" id="remove" href="javascript:void(0)" title="Remove">',
                    '<i class="glyphicon glyphicon-remove"></i>',
                    '</a>'
                ].join('');
            }
            window.actionEvents = {
                'click .like': function (e, value, row, index) {
                    alert('You click edit icon, row: ' + JSON.stringify(row));
                    console.log(value, row, index);
                },
                'click .edit': function (e, value, row, index) {
                    var companyId = row.id;
                    SwalEdit(companyId);
                },
                'click .remove': function (e, value, row, index) {
                    var companyId = row.id;
                    SwalDelete(companyId);
                }
            };

            function hitRefresh(){
                var $table = $('#table');
                $table.bootstrapTable('load', {
                    url: 'ajax/get-companies.php'
                });
            }

            function SwalEdit(companyId){
                
            }

            function SwalDelete(companyId){
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
                            url: 'view-companies-delete.php',
                            type: 'POST',
                            data: 'deleteCompany='+companyId,
                            dataType: 'json'
                        })
                        .done(function(response){
                            // var $table = $('#table');
                            // $table.bootstrapTable('refresh', {
                            //     url: 'ajax/get-companies.php'
                            // });
                            // reload page
                            location.reload();
                            swal('Deleted!', response.message, response.status);
                        })
                        .fail(function(){
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        });
                    });
                    },
                    allowOutsideClick: false			  
                });	
                
            }

            $('#table').on('refresh.bs.table', function (params) {
    console.log("Table refreshed!");
    console.log(params);
});
        </script>
	</body>
</html>