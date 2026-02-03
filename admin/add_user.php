<?php 
include ('header.php');
include ('include/dbcon.php');
?>

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
            var newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
            
            // Add proper event listener
            newElement.addEventListener('keydown', function(e) {
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
});
</script>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-plus"></i> Add User</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link" href="javascript:void(0);"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link" href="javascript:void(0);"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <!-- ================= FORM ================= -->
                <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id="addUserForm">
                    
                    <!-- Add hidden input to help with focus management -->
                    <input type="text" style="position:absolute; opacity:0; height:0; padding:0; border:0; width:0;">
                    
                    <!-- PROFILE IMAGE UPLOAD -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Profile Picture</label>
                        <div class="col-md-4">
                            <input type="file" name="user_image" class="form-control" accept="image/*" onfocus="this.select()">
                            <small class="text-muted">Optional. Accepts JPG, PNG, GIF (Max 2MB)</small>
                        </div>
                    </div>

                    <!-- Year of Registration -->
                    <div class="form-group">
                        <label class="control-label col-md-4">
                            Year of Registration <span style="color:red">*</span>
                        </label>
                        <div class="col-md-3">
                            <input type="number"
                                   name="reg_year"
                                   min="2000"
                                   max="2099"
                                   placeholder="e.g. 2022"
                                   required
                                   class="form-control"
                                   onfocus="this.select()">
                        </div>
                    </div>

                    <!-- First Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4">First Name <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" name="firstname" required class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Middle Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Middle Name</label>
                        <div class="col-md-3">
                            <input type="text" name="middlename" class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Last Name <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" name="lastname" required class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Contact</label>
                        <div class="col-md-3">
                            <input type="tel" name="contact" maxlength="11" class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Gender <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="gender" required class="form-control" onfocus="this.select()">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Address</label>
                        <div class="col-md-4">
                            <input type="text" name="address" class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Type <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="type" required class="form-control" onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Level -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Level <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select name="level" required class="form-control" onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
                                <option value="Form 1-North">Form 1-North</option>
                                <option value="Form 1-East">Form 1-East</option>
                                <option value="Form 1-West">Form 1-West</option>
                                <option value="Form 2-North">Form 2-North</option>
                                <option value="Form 2-East">Form 2-East</option>
                                <option value="Form 2-West">Form 2-West</option>
                                <option value="Form 3-North">Form 3-North</option>
                                <option value="Form 3-East">Form 3-East</option>
                                <option value="Form 3-West">Form 3-West</option>
                                <option value="Form 4-North">Form 4-North</option>
                                <option value="Form 4-East">Form 4-East</option>
                                <option value="Form 4-West">Form 4-West</option>
                                <option value="Faculty">Teacher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section -->
                    <div class="form-group">
                        <label class="control-label col-md-4">Section <span style="color:red">*</span></label>
                        <div class="col-md-3">
                            <input type="text" name="section" required class="form-control" onfocus="this.select()">
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <a href="user.php" class="btn btn-primary">Cancel</a>
                            <button type="submit" name="submit" class="btn btn-success">
                                Add User
                            </button>
                        </div>
                    </div>

                </form>

<?php
/* ================= PROCESS FORM ================= */
if (isset($_POST['submit'])) {
    
    // Handle profile image upload
    $user_image = 'default_avatar.png'; // Default image
    
    if (isset($_FILES['user_image']['tmp_name']) && !empty($_FILES['user_image']['tmp_name'])) {
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['user_image']['name'];
        $file_tmp = $_FILES['user_image']['tmp_name'];
        $file_size = $_FILES['user_image']['size'];
        $file_error = $_FILES['user_image']['error'];
        
        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validate file
        if (in_array($file_ext, $allowed_extensions)) {
            if ($file_error === 0) {
                if ($file_size <= 2097152) { // 2MB limit
                    // Generate unique filename
                    $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
                    $upload_path = 'uploads/profiles/' . $new_filename;
                    
                    // Create directory if it doesn't exist
                    if (!is_dir('uploads/profiles/')) {
                        mkdir('uploads/profiles/', 0777, true);
                    }
                    
                    if (move_uploaded_file($file_tmp, $upload_path)) {
                        $user_image = $new_filename;
                    } else {
                        echo "<script>alert('Error uploading profile picture. Using default.');</script>";
                    }
                } else {
                    echo "<script>alert('File is too large (max 2MB). Using default image.');</script>";
                }
            } else {
                echo "<script>alert('Error with file upload. Using default image.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, PNG, GIF allowed. Using default image.');</script>";
        }
    }
    
    $reg_year = $_POST['reg_year'];              
    $year_two = substr($reg_year, -2);            
    $prefix = "MLZ-$year_two-";

    // get last ID for that year
    $query = mysqli_query(
        $con,
        "SELECT school_number 
         FROM user 
         WHERE school_number LIKE '$prefix%' 
         ORDER BY school_number DESC 
         LIMIT 1"
    ) or die(mysqli_error($con));

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        // extract numeric part
        $last_no = intval(substr($row['school_number'], strlen($prefix)));
        // increment
        $new_no_int = $last_no + 1;
    } else {
        $new_no_int = 1; 
    }

    $new_no = str_pad($new_no_int, 3, '0', STR_PAD_LEFT);
    $school_number = $prefix . $new_no;

    // Sanitize all inputs
    $firstname  = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = !empty($_POST['middlename']) ? mysqli_real_escape_string($con, $_POST['middlename']) : '';
    $lastname   = mysqli_real_escape_string($con, $_POST['lastname']);
    $contact    = !empty($_POST['contact']) ? mysqli_real_escape_string($con, $_POST['contact']) : '';
    $gender     = mysqli_real_escape_string($con, $_POST['gender']);
    $address    = !empty($_POST['address']) ? mysqli_real_escape_string($con, $_POST['address']) : '';
    $type       = mysqli_real_escape_string($con, $_POST['type']);
    $level      = mysqli_real_escape_string($con, $_POST['level']);
    $section    = mysqli_real_escape_string($con, $_POST['section']);
    $user_image = mysqli_real_escape_string($con, $user_image);
    
    // Insert query - INCLUDING user_image
    $insert_query = "INSERT INTO user 
        (school_number, firstname, middlename, lastname, contact, gender, address, 
         type, level, section, status, user_added, user_image)
        VALUES
        ('$school_number', '$firstname', '$middlename', '$lastname', '$contact', '$gender', 
         '$address', '$type', '$level', '$section', 'Active', NOW(), '$user_image')";
    
    $result = mysqli_query($con, $insert_query);
    
    if ($result) {
        echo "<script>
                alert('User added successfully! ID: $school_number');
                window.location='user.php';
              </script>";
    } else {
        // Show detailed error
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error:</strong> " . mysqli_error($con) . "<br>";
        echo "<strong>Query:</strong> " . $insert_query . "<br>";
        echo "</div>";
    }
}
?>

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
    });
});
</script>

<?php include ('footer.php'); ?>