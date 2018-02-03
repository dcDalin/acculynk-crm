<?php

	if (isset($_POST['editCompany'])) {
		
        include_once('sys/core/init.inc.php');
        
        $common = new common();
		
        $cId = $_POST['editCompany'];

        $query = $common->GetRows("SELECT * FROM tbl_companies WHERE id='".$cId."'");   
        
        foreach($query AS $row) {
            $companyId = $row['id'];
            $companyName = $row['companyName'];
            $companyEmail = $row['companyEmail'];
            $companyPhoneNumber = $row['companyPhoneNumber'];
            $companyWebsite = $row['companyWebsite'];
            $category = $row['category'];
        }

    } 

?>

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