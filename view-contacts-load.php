<?php
    include_once('sys/core/init.inc.php');
    $common = new common();

    $query = $common->GetRows("SELECT * FROM tbl_contact");      
?>

<div class="table-responsive">
    <table class="table table-bordered table-condensed table-hover table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>ID Number</th>
                <th>Company ID</th>
            </tr>
        </thead>                          
        <tbody>
            <?php
                foreach($query AS $row) {
                    $contact_id = $row['contact_id'];
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $email = $row['email'];
                    $gender = $row['gender'];
                    $phoneNumber = $row['phoneNumber'];
                    $idNumber = $row['idNumber'];
                    $company = $row['company'];
            ?>
                    <tr>
                        <td><?php echo $firstName; ?></td>
                        <td><?php echo $lastName; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo $phoneNumber; ?></td>
                        <td><?php echo $idNumber; ?></td>
                        <td><?php echo $company; ?></td>
                        <td>
                            <a class="btn btn-sm btn-danger" id="delete_contact" data-id="<?php echo $contact_id; ?>" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>
                            <a class="btn btn-sm btn-info" id="edit_company" data-id="<?php echo $companyId; ?>" href="javascript:void(0)"><i class="glyphicon glyphicon-pencil"></i></a>
                        </td>
                    </tr> 
            <?php
                }
            ?>
        </tbody>
    </table>
</div>