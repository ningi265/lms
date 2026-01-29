<?php include ('include/dbcon.php');
$ID = $_GET['user_id'];
?>
<?php include ('header.php'); ?>

<div class="page-title">
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i> Edit User</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->
                <?php
                $query = mysqli_query($con, "SELECT * FROM user WHERE user_id='$ID'") or die(mysqli_error());
                $row = mysqli_fetch_array($query);
                
                // Extract year from existing school number (format: MLZ-YY-XXX)
                $existing_year = '';
                if (!empty($row['school_number'])) {
                    $parts = explode('-', $row['school_number']);
                    if (count($parts) >= 2) {
                        $existing_year = '20' . $parts[1]; // Convert YY to 20YY
                    }
                }
                ?>

                <form method="post" class="form-horizontal form-label-left">
                    <!-- Year of Registration -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="reg_year">
                            Year of Registration <span style="color:red">*</span>
                        </label>
                        <div class="col-md-3">
                            <input type="number" 
                                   name="reg_year" 
                                   id="reg_year" 
                                   value="<?php echo !empty($existing_year) ? $existing_year : date('Y'); ?>" 
                                   min="2000" 
                                   max="2099" 
                                   placeholder="e.g. 2024" 
                                   required 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Current School Number (Read-only for reference) -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="current_id">
                            Current ID Number
                        </label>
                        <div class="col-md-3">
                            <input type="text" 
                                   id="current_id" 
                                   value="<?php echo $row['school_number']; ?>" 
                                   class="form-control col-md-7 col-xs-12" 
                                   readonly
                                   style="background-color: #f9f9f9;">
                            <small class="text-muted">This will be updated based on the Year of Registration</small>
                        </div>
                    </div>

                    <!-- New School Number (Hidden, will be generated) -->
                    <input type="hidden" name="school_number" id="generated_id" value="">

                    <!-- First Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">First Name <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" 
                                   value="<?php echo $row['firstname']; ?>" 
                                   name="firstname" 
                                   id="first-name" 
                                   required 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="middlename">Middle Name</label>
                        <div class="col-md-3">
                            <input type="text" 
                                   name="middlename" 
                                   value="<?php echo $row['middlename']; ?>" 
                                   placeholder="MI / Middle Name" 
                                   id="middlename" 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="lastname">Last Name <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" 
                                   value="<?php echo $row['lastname']; ?>" 
                                   name="lastname" 
                                   id="lastname" 
                                   required 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="contact">Contact</label>
                        <div class="col-md-3">
                            <input type='tel' 
                                   value="<?php echo $row['contact']; ?>" 
                                   autocomplete="off"  
                                   maxlength="11" 
                                   name="contact" 
                                   id="contact" 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="gender">Gender <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="gender" id="gender" required class="select2_single form-control" tabindex="-1">
                                <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="address">Address</label>
                        <div class="col-md-4">
                            <input type="text" 
                                   value="<?php echo $row['address']; ?>" 
                                   name="address" 
                                   id="address" 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="type">Type <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="type" id="type" required class="select2_single form-control" tabindex="-1">
                                <option value="Student" <?php echo ($row['type'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                                <option value="Teacher" <?php echo ($row['type'] == 'Teacher') ? 'selected' : ''; ?>>Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Level -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="level">Level <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="level" id="level" required class="select2_single form-control" tabindex="-1">
                                <option value="Form 1-North" <?php echo ($row['level'] == 'Form 1-North') ? 'selected' : ''; ?>>Form 1-North</option>
                                <option value="Form 1-East" <?php echo ($row['level'] == 'Form 1-East') ? 'selected' : ''; ?>>Form 1-East</option>
                                <option value="Form 1-West" <?php echo ($row['level'] == 'Form 1-West') ? 'selected' : ''; ?>>Form 1-West</option>
                                <option value="Form 2-North" <?php echo ($row['level'] == 'Form 2-North') ? 'selected' : ''; ?>>Form 2-North</option>
                                <option value="Form 2-East" <?php echo ($row['level'] == 'Form 2-East') ? 'selected' : ''; ?>>Form 2-East</option>
                                <option value="Form 2-West" <?php echo ($row['level'] == 'Form 2-West') ? 'selected' : ''; ?>>Form 2-West</option>
                                <option value="Form 3-North" <?php echo ($row['level'] == 'Form 3-North') ? 'selected' : ''; ?>>Form 3-North</option>
                                <option value="Form 3-East" <?php echo ($row['level'] == 'Form 3-East') ? 'selected' : ''; ?>>Form 3-East</option>
                                <option value="Form 3-West" <?php echo ($row['level'] == 'Form 3-West') ? 'selected' : ''; ?>>Form 3-West</option>
                                <option value="Form 4-North" <?php echo ($row['level'] == 'Form 4-North') ? 'selected' : ''; ?>>Form 4-North</option>
                                <option value="Form 4-East" <?php echo ($row['level'] == 'Form 4-East') ? 'selected' : ''; ?>>Form 4-East</option>
                                <option value="Form 4-West" <?php echo ($row['level'] == 'Form 4-West') ? 'selected' : ''; ?>>Form 4-West</option>
                                <option value="Faculty" <?php echo ($row['level'] == 'Faculty') ? 'selected' : ''; ?>>Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="section">Section <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" 
                                   name="section" 
                                   value="<?php echo $row['section']; ?>" 
                                   placeholder="Section" 
                                   id="section" 
                                   required 
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href="user.php"><button type="button" class="btn btn-primary"><i class="fa fa-times-circle-o"></i> Cancel</button></a>
                            <button type="submit" name="update" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Update</button>
                        </div>
                    </div>
                </form>

                <?php
                if (isset($_POST['update'])) {
                    $id = $_GET['user_id'];
                    $reg_year = $_POST['reg_year'];
                    $year_two = substr($reg_year, -2);
                    $prefix = "MLZ-$year_two-";
                    
                    // Check if the user is keeping the same year
                    $existing_parts = explode('-', $row['school_number']);
                    $existing_prefix = $existing_parts[0] . '-' . $existing_parts[1] . '-';
                    
                    if ($existing_prefix == $prefix) {
                        // Same year, keep existing number
                        $school_number = $row['school_number'];
                    } else {
                        // Different year, get new number for that year
                        $query = mysqli_query(
                            $con,
                            "SELECT school_number 
                             FROM user 
                             WHERE school_number LIKE '$prefix%' 
                             AND user_id != '$id'
                             ORDER BY school_number DESC 
                             LIMIT 1"
                        );

                        if (mysqli_num_rows($query) > 0) {
                            $last_row = mysqli_fetch_assoc($query);
                            $last_no = intval(substr($last_row['school_number'], strlen($prefix)));
                            $new_no_int = $last_no + 1;
                        } else {
                            $new_no_int = 1;
                        }

                        $new_no = str_pad($new_no_int, 3, '0', STR_PAD_LEFT);
                        $school_number = $prefix . $new_no;
                    }

                    // Collect other form data
                    $firstname = $_POST['firstname'];
                    $middlename = $_POST['middlename'];
                    $lastname = $_POST['lastname'];
                    $contact = $_POST['contact'];
                    $gender = $_POST['gender'];
                    $address = $_POST['address'];
                    $type = $_POST['type'];
                    $level = $_POST['level'];
                    $section = $_POST['section'];

                    // Update query
                    mysqli_query($con,"UPDATE user SET 
                        school_number='$school_number', 
                        firstname='$firstname', 
                        middlename='$middlename', 
                        lastname='$lastname', 
                        contact='$contact', 
                        gender='$gender', 
                        address='$address', 
                        type='$type', 
                        level='$level', 
                        section='$section' 
                        WHERE user_id = '$id'") or die(mysqli_error($con));
                    
                    echo "<script>
                            alert('Successfully Updated User Info! New ID: $school_number');
                            window.location='user.php';
                          </script>";
                }
                ?>
                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>