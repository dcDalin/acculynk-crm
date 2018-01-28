<?php
    include_once('sys/core/init.inc.php');
    $common = new common();

    $query = $common->GetRows("SELECT * FROM tbl_companies");      
?>

<div class="table-responsive">
    <table class="table table-bordered table-condensed table-hover table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Company Email</th>
                <th>Phone Number</th>
                <th>Website</th>
                <th>Category</th>
            </tr>
        </thead>                          
        <tbody>
            <?php
                foreach($query AS $row) {
                    $companyId = $row['id'];
                    $companyName = $row['companyName'];
                    $companyEmail = $row['companyEmail'];
                    $companyPhoneNumber = $row['companyPhoneNumber'];
                    $companyWebsite = $row['companyWebsite'];
                    $category = $row['category'];
            ?>
                    <tr>
                        <td><?php echo $companyName; ?></td>
                        <td><?php echo $companyEmail; ?></td>
                        <td><?php echo $companyPhoneNumber; ?></td>
                        <td><?php echo $companyWebsite; ?></td>
                        <td><?php echo $category; ?></td>
                        <td>
                            <a class="btn btn-sm btn-danger" id="delete_company" data-id="<?php echo $companyId; ?>" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>
                            <a class="btn btn-sm btn-info" id="edit_company" data-id="<?php echo $companyId; ?>" href="javascript:void(0)"><i class="glyphicon glyphicon-pencil"></i></a>
                        </td>
                    </tr> 
            <?php
                }
            ?>
        </tbody>
    </table>
</div>