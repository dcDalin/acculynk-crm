<!DOCTYPE html>
<html>
    <head>
        <?php 
        include 'inc/inc.meta.php';
        ?>
    </head>
    <body>
        <div class="table-responsive">
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
                    '<a class="edit ml10" id="edit" href="javascript:void(0)" title="Edit">',
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

            function SwalEdit(companyId){
                $.ajax({ 
                    url: 'view-companies-edit-form.php',
                    data: {'editCompany' : companyId},
                    type: 'post',
                    dataType:'json',
                    success: function() {
                        $("#view-companies").hide();
                        $("#edit-company").show('slow');
                        showEditForm();
                    },
                    error: function(request, status, error){
                        alert(companyId);
                    }
                });
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
                            var $table = $('#table');
                            $table.bootstrapTable('refresh', {
                                url: 'ajax/get-companies.php'
                            });
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
            function showEditForm(){
                $('#load-edit-form').load('view-companies-edit-form.php');	
            }

        </script>
    </body>
</html>