<?php 
include ('include/dbcon.php');
$ID = $_GET['user_id'];
?>
<?php include ('header.php'); ?>

<!-- ARROW KEY FIX - Add this early in the page -->
<script>
// Fix for arrow key navigation in form inputs
document.addEventListener('DOMContentLoaded', function() {
    // Function to fix arrow keys in all form elements
    function fixArrowKeys() {
        // Get all form elements
        var formElements = document.querySelectorAll('input, select, textarea');
        
        for (var i = 0; i < formElements.length; i++) {
            // Remove any existing keydown listeners that might block arrows
            var element = formElements[i];
            
            // Add proper event listener
            element.addEventListener('keydown', function(e) {
                // Allow arrow keys (left: 37, up: 38, right: 39, down: 40)
                if (e.keyCode >= 37 && e.keyCode <= 40) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return true;
                }
            }, true); // Use capture phase to intercept early
        }
        
        // Also prevent event bubbling from Bootstrap collapse
        var form = document.querySelector('form');
        if (form) {
            form.addEventListener('keydown', function(e) {
                if (e.keyCode >= 37 && e.keyCode <= 40) {
                    e.stopPropagation();
                }
            }, true);
        }
    }
    
    // Fix arrow keys immediately
    fixArrowKeys();
    
    // Also fix when the collapse panel is toggled
    var collapseLinks = document.querySelectorAll('.collapse-link');
    for (var i = 0; i < collapseLinks.length; i++) {
        collapseLinks[i].addEventListener('click', function(e) {
            e.preventDefault();
            // After collapse animation, re-fix arrow keys
            setTimeout(fixArrowKeys, 300);
        });
    }
    
    // Update generated ID when year changes
    var yearInput = document.getElementById('reg_year');
    var currentIdField = document.getElementById('current_id');
    var generatedIdField = document.getElementById('generated_id');
    
    if (yearInput && currentIdField && generatedIdField) {
        function updateGeneratedId() {
            var year = yearInput.value;
            var currentId = currentIdField.value;
            
            if (year && year.length === 4) {
                var yearTwo = year.slice(-2);
                var prefix = "MLZ-" + yearTwo + "-";
                
                // Check if year has changed from original
                var originalParts = currentId.split('-');
                var originalPrefix = originalParts[0] + '-' + originalParts[1] + '-';
                
                if (prefix === originalPrefix) {
                    // Same year, keep original ID
                    generatedIdField.value = currentId;
                } else {
                    // Different year - we'll generate new ID on server
                    generatedIdField.value = 'Will be generated on save';
                }
            }
        }
        
        yearInput.addEventListener('input', updateGeneratedId);
        yearInput.addEventListener('change', updateGeneratedId);
        updateGeneratedId(); // Initial call
    }
});
</script>

<div class="page-title">
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i> Edit User</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link" href="javascript:void(0);"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link" href="javascript:void(0);"><i class="fa fa-close"></i></a></li>
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

                <form method="post" class="form-horizontal form-label-left" id="editUserForm">
                    <!-- Add hidden input to help with focus management -->
                    <input type="text" style="position:absolute; opacity:0; height:0; padding:0; border:0; width:0;">
                    
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="gender">Gender <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="gender" id="gender" required class="select2_single form-control" tabindex="-1"
                                    onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="type">Type <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="type" id="type" required class="select2_single form-control" tabindex="-1"
                                    onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
                                <option value="Student" <?php echo ($row['type'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                                <option value="Teacher" <?php echo ($row['type'] == 'Teacher') ? 'selected' : ''; ?>>Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Level -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="level">Level <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="level" id="level" required class="select2_single form-control" tabindex="-1"
                                    onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
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
                                   class="form-control col-md-7 col-xs-12"
                                   onfocus="this.select()">
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
                    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
                    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
                    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
                    $contact = mysqli_real_escape_string($con, $_POST['contact']);
                    $gender = mysqli_real_escape_string($con, $_POST['gender']);
                    $address = mysqli_real_escape_string($con, $_POST['address']);
                    $type = mysqli_real_escape_string($con, $_POST['type']);
                    $level = mysqli_real_escape_string($con, $_POST['level']);
                    $section = mysqli_real_escape_string($con, $_POST['section']);

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

<!-- ADDITIONAL FIX FOR ARROW KEYS -->
<script>
// Additional fix to ensure arrow keys work after page load
$(document).ready(function() {
    // Remove any global event listeners that might block arrow keys
    $(document).off('keydown.arrowBlock');
    
    // Re-enable arrow keys specifically for form elements
    $('input, select, textarea').each(function() {
        var $this = $(this);
        
        // Remove any existing keydown handlers
        $this.off('keydown');
        
        // Add new handler that allows arrow keys
        $this.on('keydown', function(e) {
            // Arrow key codes: left=37, up=38, right=39, down=40
            if (e.keyCode >= 37 && e.keyCode <= 40) {
                e.stopPropagation();
                e.stopImmediatePropagation();
                return true;
            }
        });
    });
    
    // Fix for select2 dropdowns (if using select2)
    if ($.fn.select2) {
        $('.select2_single').each(function() {
            var $select = $(this);
            
            // Store the select2 instance
            $select.data('select2-instance', $select.select2());
            
            // Fix arrow key navigation in select2
            $select.on('select2:open', function(e) {
                // Allow arrow keys in the select2 dropdown
                var $dropdown = $('.select2-container--open');
                if ($dropdown.length) {
                    $dropdown.off('keydown').on('keydown', function(e) {
                        if (e.keyCode >= 37 && e.keyCode <= 40) {
                            e.stopPropagation();
                            return true;
                        }
                    });
                }
            });
        });
    }
    
    // Fix for select dropdowns specifically
    $('select').on('focus', function() {
        $(this).data('previous-index', this.selectedIndex);
    }).on('keydown', function(e) {
        // Allow up/down arrows in select elements
        if (e.keyCode === 38 || e.keyCode === 40) {
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            // Get current index
            var currentIndex = this.selectedIndex;
            var optionCount = this.options.length;
            
            // Calculate new index
            var newIndex = currentIndex;
            if (e.keyCode === 38 && currentIndex > 0) {
                newIndex = currentIndex - 1; // Up arrow
            } else if (e.keyCode === 40 && currentIndex < optionCount - 1) {
                newIndex = currentIndex + 1; // Down arrow
            }
            
            // Set new selection
            this.selectedIndex = newIndex;
            
            // Trigger change event
            $(this).trigger('change');
            
            return false; // Prevent default browser behavior
        }
        return true;
    });
    
    // Fix collapse panel links to prevent interference
    $('.collapse-link').on('click', function(e) {
        e.preventDefault();
        var $panel = $(this).closest('.x_panel');
        var $content = $panel.find('.x_content');
        var $icon = $(this).find('i');
        
        $content.slideToggle(200, function() {
            $panel.toggleClass('collapsed');
        });
        
        $icon.toggleClass('fa-chevron-up fa-chevron-down');
        
        // Re-fix arrow keys after collapse animation
        setTimeout(function() {
            $('input, select, textarea').off('keydown').on('keydown', function(e) {
                if (e.keyCode >= 37 && e.keyCode <= 40) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    return true;
                }
            });
        }, 250);
    });
    
    // Initialize year change listener for ID generation preview
    $('#reg_year').on('input change', function() {
        var year = $(this).val();
        var currentId = $('#current_id').val();
        
        if (year && year.length === 4) {
            var yearTwo = year.slice(-2);
            var prefix = "MLZ-" + yearTwo + "-";
            
            // Check if year has changed from original
            var originalParts = currentId.split('-');
            var originalPrefix = originalParts[0] + '-' + originalParts[1] + '-';
            
            if (prefix === originalPrefix) {
                // Same year, keep original ID
                $('#generated_id').val(currentId);
            } else {
                // Different year - show message
                $('#generated_id').val('Will be generated on save');
            }
        }
    });
});
</script>

<?php include ('footer.php'); ?>