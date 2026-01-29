<?php include ('include/dbcon.php');
$book_id = $_GET['book_id']; // Use clearer variable name
?>
<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home / Books /</small> Edit Book Information
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i> Edit Book</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->
                <?php
                $query1 = mysqli_query($con, "SELECT * FROM book 
                    LEFT JOIN category ON book.category_id = category.category_id
                    WHERE book_id = '$book_id'") or die(mysqli_error());
                $book_data = mysqli_fetch_assoc($query1); // Changed variable name
                
                // Get current available copies (if column exists)
                $available_copies = isset($book_data['available_copies']) ? $book_data['available_copies'] : $book_data['book_copies'];
                ?>

                <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Book Image</label>
                        <div class="col-md-4">
                            <a href="#">
                                <?php if($book_data['book_image'] != ""): ?>
                                    <img src="upload/<?php echo $book_data['book_image']; ?>" width="100px" height="100px" style="border:4px groove #CCCCCC; border-radius:5px;">
                                <?php else: ?>
                                    <img src="images/book_image.jpg" width="100px" height="100px" style="border:4px groove #CCCCCC; border-radius:5px;">
                                <?php endif; ?>
                            </a>
                            <input type="file" style="height:44px; margin-top:10px;" name="image" id="last-name2" class="form-control col-md-7 col-xs-12" />
                            <input type="hidden" name="current_image" value="<?php echo $book_data['book_image']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Title <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="book_title" value="<?php echo $book_data['book_title']; ?>" id="first-name2" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 1 <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="author" id="first-name2" value="<?php echo $book_data['author']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 2</label>
                        <div class="col-md-4">
                            <input type="text" name="author_2" id="first-name2" value="<?php echo $book_data['author_2']; ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 3</label>
                        <div class="col-md-4">
                            <input type="text" name="author_3" id="first-name2" value="<?php echo $book_data['author_3']; ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 4</label>
                        <div class="col-md-4">
                            <input type="text" name="author_4" id="first-name2" value="<?php echo $book_data['author_4']; ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 5</label>
                        <div class="col-md-4">
                            <input type="text" name="author_5" id="first-name2" value="<?php echo $book_data['author_5']; ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publication</label>
                        <div class="col-md-4">
                            <input type="text" name="book_pub" value="<?php echo $book_data['book_pub']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publisher</label>
                        <div class="col-md-4">
                            <input type="text" name="publisher_name" value="<?php echo $book_data['publisher_name']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">ISBN <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="isbn" id="last-name2" value="<?php echo $book_data['isbn']; ?>" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Copyright</label>
                        <div class="col-md-4">
                            <input type="text" name="copyright_year" value="<?php echo $book_data['copyright_year']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    
                    <!-- TOTAL COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Total Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-2">
                            <input type="number" name="book_copies" id="total_copies" value="<?php echo $book_data['book_copies']; ?>" step="1" min="1" max="1000" required class="form-control">
                            <small class="text-muted">Total inventory copies</small>
                        </div>
                    </div>
                    
                    <!-- AVAILABLE COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Available Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-2">
                            <input type="number" name="available_copies" id="available_copies" value="<?php echo $available_copies; ?>" step="1" min="0" max="1000" required class="form-control">
                            <small class="text-muted">Copies currently available for borrowing</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Status <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <select name="status" class="select2_single form-control" tabindex="-1" required id="status_select">
                                <option value="<?php echo $book_data['status']; ?>"><?php echo $book_data['status']; ?></option>
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
                            <select name="category_id" class="select2_single form-control" tabindex="-1" required>
                                <option value="<?php echo $book_data['category_id']; ?>"><?php echo $book_data['classname']; ?></option>
                                <?php
                                $cat_result = mysqli_query($con, "SELECT * FROM category") or die(mysqli_error());
                                while ($cat_row = mysqli_fetch_array($cat_result)) {
                                ?>
                                <option value="<?php echo $cat_row['category_id']; ?>"><?php echo $cat_row['classname']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href="book.php"><button type="button" class="btn btn-primary"><i class="fa fa-times-circle-o"></i> Cancel</button></a>
                            <button type="submit" name="update11" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Update</button>
                        </div>
                    </div>
                </form>
                
                <?php
                if (isset($_POST['update11'])) {
                    // Handle file upload
                    $image = $_FILES["image"]["name"];
                    $image_name = addslashes($_FILES['image']['name']);
                    $size = $_FILES["image"]["size"];
                    $error = $_FILES["image"]["error"];
                    
                    // Get form data
                    $book_title = mysqli_real_escape_string($con, $_POST['book_title']);
                    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
                    $author = mysqli_real_escape_string($con, $_POST['author']);
                    $author_2 = mysqli_real_escape_string($con, $_POST['author_2']);
                    $author_3 = mysqli_real_escape_string($con, $_POST['author_3']);
                    $author_4 = mysqli_real_escape_string($con, $_POST['author_4']);
                    $author_5 = mysqli_real_escape_string($con, $_POST['author_5']);
                    $book_copies = mysqli_real_escape_string($con, $_POST['book_copies']);
                    $available_copies_input = mysqli_real_escape_string($con, $_POST['available_copies']); // Changed variable name
                    $book_pub = mysqli_real_escape_string($con, $_POST['book_pub']);
                    $publisher_name = mysqli_real_escape_string($con, $_POST['publisher_name']);
                    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
                    $copyright_year = mysqli_real_escape_string($con, $_POST['copyright_year']);
                    $status = mysqli_real_escape_string($con, $_POST['status']);
                    $current_image = $_POST['current_image'];
                    
                    // Validate that available copies doesn't exceed total copies
                    if ($available_copies_input > $book_copies) {
                        echo "<script>alert('Error: Available copies cannot exceed total copies!'); window.location='edit_book.php?book_id=$book_id';</script>";
                        exit();
                    }
                    
                    // Set remarks based on status and available copies
                    if ($status == 'Lost' || $status == 'Damaged') {
                        $remark = 'Not Available';
                        // If status is Lost or Damaged, force available copies to 0
                        $available_copies_input = 0;
                    } elseif ($available_copies_input == 0) {
                        $remark = 'Not Available';
                    } else {
                        $remark = 'Available';
                    }
                    
                    // Handle image upload
                    $image_update = "";
                    if (!empty($image)) {
                        if ($size > 10000000) {
                            echo "<script>alert('Error: File size is too big! Maximum size is 10MB.'); window.location='edit_book.php?book_id=$book_id';</script>";
                            exit();
                        }
                        
                        move_uploaded_file($_FILES["image"]["tmp_name"], "upload/" . $_FILES["image"]["name"]);
                        $image_update = ", book_image = '$image'";
                    }
                    
                    // Debug: Check what values are being used
                    echo "<!-- Debug: book_id = $book_id -->";
                    echo "<!-- Debug: available_copies_input = $available_copies_input -->";
                    
                    // Update book information including available_copies
                    $update_query = "UPDATE book SET 
                        book_title = '$book_title',
                        category_id = '$category_id',
                        author = '$author',
                        author_2 = '$author_2',
                        author_3 = '$author_3',
                        author_4 = '$author_4',
                        author_5 = '$author_5',
                        book_copies = '$book_copies',
                        available_copies = '$available_copies_input',
                        book_pub = '$book_pub',
                        publisher_name = '$publisher_name',
                        isbn = '$isbn',
                        copyright_year = '$copyright_year',
                        status = '$status',
                        remarks = '$remark'
                        $image_update
                        WHERE book_id = '$book_id'";
                    
                    // Debug: Show the query
                    echo "<!-- Debug Query: $update_query -->";
                    
                    if (mysqli_query($con, $update_query)) {
                        echo "<script>alert('Successfully Updated Book Info!'); window.location='book.php'</script>";
                    } else {
                        echo "<script>alert('Error updating book: " . mysqli_error($con) . "'); window.location='edit_book.php?book_id=$book_id';</script>";
                    }
                }
                ?>
                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for form validation -->
<script>
$(document).ready(function() {
    // Set initial max value for available copies
    var totalCopies = parseInt($('#total_copies').val()) || 0;
    $('#available_copies').attr('max', totalCopies);
    
    // Update available copies max when total copies changes
    $('#total_copies').on('input', function() {
        var totalCopies = parseInt($(this).val()) || 0;
        var currentAvailable = parseInt($('#available_copies').val()) || 0;
        var status = $('#status_select').val();
        
        // Update max attribute
        $('#available_copies').attr('max', totalCopies);
        
        // If status is Lost or Damaged, set available copies to 0
        if (status === 'Lost' || status === 'Damaged') {
            $('#available_copies').val(0);
            $('#available_copies').prop('readonly', true);
        } else if (currentAvailable > totalCopies) {
            // If current available exceeds new total, adjust it
            $('#available_copies').val(totalCopies);
        }
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
            var currentAvailable = parseInt($('#available_copies').val()) || 0;
            // Ensure available copies doesn't exceed total
            if (currentAvailable > totalCopies) {
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
    
    // Form submission validation
    $('form').submit(function(e) {
        var totalCopies = parseInt($('#total_copies').val()) || 0;
        var availableCopies = parseInt($('#available_copies').val()) || 0;
        var status = $('#status_select').val();
        
        // Additional validation
        if (availableCopies > totalCopies) {
            e.preventDefault();
            alert('Error: Available copies cannot exceed total copies!');
            return false;
        }
        
        if ((status === 'Lost' || status === 'Damaged') && availableCopies > 0) {
            e.preventDefault();
            alert('Error: Lost or Damaged books must have 0 available copies!');
            return false;
        }
        
        return true;
    });
});
</script>

<?php include ('footer.php'); ?>