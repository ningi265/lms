<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include ('include/dbcon.php');

// Get the next barcode number
$query = mysqli_query($con, "SELECT * FROM `barcode` ORDER BY mid_barcode DESC ") or die(mysqli_error($con));
$fetch = mysqli_fetch_array($query);
$mid_barcode = isset($fetch['mid_barcode']) ? $fetch['mid_barcode'] : 0;

$new_barcode = $mid_barcode + 1;
$pre_barcode = "VNHS";
$suf_barcode = "LMS";
$generate_barcode = $pre_barcode . $new_barcode . $suf_barcode;
?>

<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home / Books /</small> Add Book
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-plus"></i> Add Book</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->
                <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <input type="hidden" name="new_barcode" value="<?php echo $new_barcode; ?>">
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Title <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="book_title" id="first-name2" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 1 <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="author" id="first-name2" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 2</label>
                        <div class="col-md-4">
                            <input type="text" name="author_2" id="first-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 3</label>
                        <div class="col-md-4">
                            <input type="text" name="author_3" id="first-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 4</label>
                        <div class="col-md-4">
                            <input type="text" name="author_4" id="first-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 5</label>
                        <div class="col-md-4">
                            <input type="text" name="author_5" id="first-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publication</label>
                        <div class="col-md-4">
                            <input type="text" name="book_pub" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publisher</label>
                        <div class="col-md-4">
                            <input type="text" name="publisher_name" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">ISBN <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="isbn" id="last-name2" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Copyright Year</label>
                        <div class="col-md-4">
                            <input type="number" name="copyright_year" id="copyright_year" min="1000" max="2099" class="form-control col-md-7 col-xs-12" placeholder="YYYY">
                        </div>
                    </div>
                    
                    <!-- TOTAL COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Total Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-1">
                            <input type="number" name="book_copies" step="1" min="1" max="1000" required="required" class="form-control col-md-7 col-xs-12" id="total_copies">
                            <small class="text-muted">Total inventory copies</small>
                        </div>
                    </div>
                    
                    <!-- AVAILABLE COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Available Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-1">
                            <input type="number" name="available_copies" step="1" min="0" max="1000" required="required" class="form-control col-md-7 col-xs-12" id="available_copies">
                            <small class="text-muted">Copies currently available for borrowing</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Status <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <select name="status" class="select2_single form-control" tabindex="-1" required="required" id="status_select">
                                <option value="New">New</option>
                                <option value="Old">Old</option>
                                <option value="Lost">Lost</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Replacement">Replacement</option>
                                <option value="Hardbound">Hardbound</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Category <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <select name="category_id" class="select2_single form-control" tabindex="-1" required="required">
                                <?php
                                $result = mysqli_query($con, "SELECT * FROM category") or die(mysqli_error($con));
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['category_id']; ?>"><?php echo $row['classname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Book Image</label>
                        <div class="col-md-4">
                            <input type="file" style="height:44px;" name="image" id="last-name2" class="form-control col-md-7 col-xs-12" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href="book.php"><button type="button" class="btn btn-primary"><i class="fa fa-times-circle-o"></i> Cancel</button></a>
                            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-plus-square"></i> Submit</button>
                        </div>
                    </div>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    // Handle file upload
                    $book_image = NULL;
                    if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '') {
                        $file = $_FILES['image']['tmp_name'];
                        $image_name = $_FILES['image']['name'];
                        $size = $_FILES["image"]["size"];
                        $error = $_FILES["image"]["error"];
                        
                        if ($size > 10000000) { // 10MB limit
                            echo "<script>alert('File size is too big! Maximum size is 10MB.');</script>";
                        } else {
                            $target_dir = "upload/";
                            $target_file = $target_dir . basename($_FILES["image"]["name"]);
                            
                            // Check if upload directory exists
                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }
                            
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                $book_image = mysqli_real_escape_string($con, $_FILES["image"]["name"]);
                            } else {
                                echo "<script>alert('Error uploading file.');</script>";
                            }
                        }
                    }
                    
                    // Get and sanitize all form data
                    $book_title = mysqli_real_escape_string($con, $_POST['book_title']);
                    $category_id = (int)$_POST['category_id'];
                    $author = mysqli_real_escape_string($con, $_POST['author']);
                    
                    // Handle optional author fields
                    $author_2 = !empty($_POST['author_2']) ? mysqli_real_escape_string($con, $_POST['author_2']) : NULL;
                    $author_3 = !empty($_POST['author_3']) ? mysqli_real_escape_string($con, $_POST['author_3']) : NULL;
                    $author_4 = !empty($_POST['author_4']) ? mysqli_real_escape_string($con, $_POST['author_4']) : NULL;
                    $author_5 = !empty($_POST['author_5']) ? mysqli_real_escape_string($con, $_POST['author_5']) : NULL;
                    
                    // Handle integer fields
                    $book_copies = (int)$_POST['book_copies'];
                    $available_copies = (int)$_POST['available_copies'];
                    
                    // Handle optional text fields
                    $book_pub = !empty($_POST['book_pub']) ? mysqli_real_escape_string($con, $_POST['book_pub']) : NULL;
                    $publisher_name = !empty($_POST['publisher_name']) ? mysqli_real_escape_string($con, $_POST['publisher_name']) : NULL;
                    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
                    
                    // FIXED: Handle copyright_year properly (integer or NULL)
                    $copyright_year = NULL;
                    if (!empty($_POST['copyright_year']) && is_numeric($_POST['copyright_year'])) {
                        $year = (int)$_POST['copyright_year'];
                        if ($year >= 1000 && $year <= 2099) {
                            $copyright_year = $year;
                        }
                    }
                    
                    $status = mysqli_real_escape_string($con, $_POST['status']);
                    
                    // Generate barcode
                    $pre = "VNHS";
                    $mid = (int)$_POST['new_barcode'];
                    $suf = "LMS";
                    $gen = $pre . $mid . $suf;
                    
                    // Validate that available copies doesn't exceed total copies
                    if ($available_copies > $book_copies) {
                        echo "<script>alert('Available copies cannot exceed total copies!');</script>";
                        echo "<script>window.location='add_book.php';</script>";
                        exit();
                    }
                    
                    // Set remarks based on status and available copies
                    if ($status == 'Lost' || $status == 'Damaged') {
                        $remark = 'Not Available';
                        $available_copies = 0; // Force available copies to 0
                    } elseif ($available_copies == 0) {
                        $remark = 'Not Available';
                    } else {
                        $remark = 'Available';
                    }
                    
                    // Build the SQL query with proper NULL handling
                    $sql = "INSERT INTO book (
                        book_title, category_id, author, author_2, author_3, author_4, author_5, 
                        book_copies, available_copies, book_pub, publisher_name, isbn, 
                        copyright_year, status, book_barcode, book_image, date_added, remarks
                    ) VALUES (
                        '$book_title', $category_id, '$author', 
                        " . ($author_2 !== NULL ? "'$author_2'" : "NULL") . ", 
                        " . ($author_3 !== NULL ? "'$author_3'" : "NULL") . ", 
                        " . ($author_4 !== NULL ? "'$author_4'" : "NULL") . ", 
                        " . ($author_5 !== NULL ? "'$author_5'" : "NULL") . ", 
                        $book_copies, $available_copies, 
                        " . ($book_pub !== NULL ? "'$book_pub'" : "NULL") . ", 
                        " . ($publisher_name !== NULL ? "'$publisher_name'" : "NULL") . ", 
                        '$isbn', 
                        " . ($copyright_year !== NULL ? "$copyright_year" : "NULL") . ", 
                        '$status', '$gen', 
                        " . ($book_image !== NULL ? "'$book_image'" : "NULL") . ", 
                        NOW(), '$remark'
                    )";
                    
                    // Execute the query
                    $result = mysqli_query($con, $sql);
                    
                    if (!$result) {
                        // Show error but don't stop execution
                        echo "<div class='alert alert-danger'>";
                        echo "<strong>Database Error:</strong> " . mysqli_error($con) . "<br>";
                        echo "</div>";
                    } else {
                        // Insert barcode record
                        mysqli_query($con, "INSERT INTO barcode (pre_barcode, mid_barcode, suf_barcode) VALUES ('$pre', '$mid', '$suf')") or die(mysqli_error($con));
                        
                        // Redirect to view barcode
                        header("location: view_barcode.php?code=" . $gen);
                        exit();
                    }
                }
                ?>
                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to automatically set available copies based on status and total copies -->
<script>
$(document).ready(function() {
    // Set initial available copies equal to total copies
    $('#total_copies').on('input', function() {
        var totalCopies = parseInt($(this).val()) || 0;
        var currentAvailable = parseInt($('#available_copies').val()) || 0;
        var status = $('#status_select').val();
        
        if (status === 'Lost' || status === 'Damaged') {
            $('#available_copies').val(0);
        } else if (currentAvailable > totalCopies) {
            $('#available_copies').val(totalCopies);
        }
        
        // Update max attribute
        $('#available_copies').attr('max', totalCopies);
    });
    
    // Update available copies when status changes
    $('#status_select').change(function() {
        var status = $(this).val();
        var totalCopies = parseInt($('#total_copies').val()) || 0;
        
        if (status === 'Lost' || status === 'Damaged') {
            $('#available_copies').val(0);
            $('#available_copies').prop('readonly', true);
        } else {
            $('#available_copies').prop('readonly', false);
            // Set available copies to total copies if it's currently 0
            var currentAvailable = parseInt($('#available_copies').val()) || 0;
            if (currentAvailable === 0) {
                $('#available_copies').val(totalCopies);
            }
        }
    });
    
    // Validate available copies doesn't exceed total copies
    $('#available_copies').on('input', function() {
        var totalCopies = parseInt($('#total_copies').val()) || 0;
        var availableCopies = parseInt($(this).val()) || 0;
        var status = $('#status_select').val();
        
        if (status !== 'Lost' && status !== 'Damaged') {
            if (availableCopies > totalCopies) {
                $(this).val(totalCopies);
                alert('Available copies cannot exceed total copies!');
            }
        } else {
            $(this).val(0);
        }
    });
});
</script>

<?php include ('footer.php'); ?>