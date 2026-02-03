<?php 
include ('include/dbcon.php');
$book_id = $_GET['book_id']; // Use clearer variable name
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
            // Add proper event listener
            var element = formElements[i];
            
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
});
</script>

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
                    <li><a class="collapse-link" href="javascript:void(0);"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link" href="javascript:void(0);"><i class="fa fa-close"></i></a></li>
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

                <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id="editBookForm">
                    <!-- Add hidden input to help with focus management -->
                    <input type="text" style="position:absolute; opacity:0; height:0; padding:0; border:0; width:0;">
                    
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
                            <input type="text" name="book_title" value="<?php echo $book_data['book_title']; ?>" id="first-name2" required="required" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 1 <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="author" id="first-name2" value="<?php echo $book_data['author']; ?>" required="required" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 2</label>
                        <div class="col-md-4">
                            <input type="text" name="author_2" id="first-name2" value="<?php echo $book_data['author_2']; ?>" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 3</label>
                        <div class="col-md-4">
                            <input type="text" name="author_3" id="first-name2" value="<?php echo $book_data['author_3']; ?>" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 4</label>
                        <div class="col-md-4">
                            <input type="text" name="author_4" id="first-name2" value="<?php echo $book_data['author_4']; ?>" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Author 5</label>
                        <div class="col-md-4">
                            <input type="text" name="author_5" id="first-name2" value="<?php echo $book_data['author_5']; ?>" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publication</label>
                        <div class="col-md-4">
                            <input type="text" name="book_pub" value="<?php echo $book_data['book_pub']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Publisher</label>
                        <div class="col-md-4">
                            <input type="text" name="publisher_name" value="<?php echo $book_data['publisher_name']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">ISBN <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="isbn" id="last-name2" value="<?php echo $book_data['isbn']; ?>" class="form-control col-md-7 col-xs-12" required onfocus="this.select()">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Copyright</label>
                        <div class="col-md-4">
                            <input type="text" name="copyright_year" value="<?php echo $book_data['copyright_year']; ?>" id="last-name2" class="form-control col-md-7 col-xs-12" onfocus="this.select()">
                        </div>
                    </div>
                    
                    <!-- TOTAL COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Total Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-2">
                            <input type="number" name="book_copies" id="total_copies" value="<?php echo $book_data['book_copies']; ?>" step="1" min="1" max="1000" required class="form-control" onfocus="this.select()">
                            <small class="text-muted">Total inventory copies</small>
                        </div>
                    </div>
                    
                    <!-- AVAILABLE COPIES -->
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Available Copies <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-2">
                            <input type="number" name="available_copies" id="available_copies" value="<?php echo $available_copies; ?>" step="1" min="0" max="1000" required class="form-control" onfocus="this.select()">
                            <small class="text-muted">Copies currently available for borrowing</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Status <span class="required" style="color:red;">*</span></label>
                        <div class="col-md-4">
                            <select name="status" class="select2_single form-control" tabindex="-1" required id="status_select"
                                    onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
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
                            <select name="category_id" class="select2_single form-control" tabindex="-1" required
                                    onfocus="this.select()" onkeydown="return event.keyCode !== 38 && event.keyCode !== 40 || true">
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
                    
                    // Get form data with proper sanitization
                    $book_title = mysqli_real_escape_string($con, $_POST['book_title']);
                    $category_id = (int)$_POST['category_id'];
                    $author = mysqli_real_escape_string($con, $_POST['author']);
                    $author_2 = !empty($_POST['author_2']) ? mysqli_real_escape_string($con, $_POST['author_2']) : NULL;
                    $author_3 = !empty($_POST['author_3']) ? mysqli_real_escape_string($con, $_POST['author_3']) : NULL;
                    $author_4 = !empty($_POST['author_4']) ? mysqli_real_escape_string($con, $_POST['author_4']) : NULL;
                    $author_5 = !empty($_POST['author_5']) ? mysqli_real_escape_string($con, $_POST['author_5']) : NULL;
                    $book_copies = (int)$_POST['book_copies'];
                    $available_copies_input = (int)$_POST['available_copies']; // Changed variable name
                    $book_pub = !empty($_POST['book_pub']) ? mysqli_real_escape_string($con, $_POST['book_pub']) : NULL;
                    $publisher_name = !empty($_POST['publisher_name']) ? mysqli_real_escape_string($con, $_POST['publisher_name']) : NULL;
                    $isbn = mysqli_real_escape_string($con, $_POST['isbn']);
                    $copyright_year = !empty($_POST['copyright_year']) ? mysqli_real_escape_string($con, $_POST['copyright_year']) : NULL;
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
                    
                    // Build update query with proper NULL handling
                    $update_query = "UPDATE book SET 
                        book_title = '$book_title',
                        category_id = $category_id,
                        author = '$author',
                        author_2 = " . ($author_2 !== NULL ? "'$author_2'" : "NULL") . ",
                        author_3 = " . ($author_3 !== NULL ? "'$author_3'" : "NULL") . ",
                        author_4 = " . ($author_4 !== NULL ? "'$author_4'" : "NULL") . ",
                        author_5 = " . ($author_5 !== NULL ? "'$author_5'" : "NULL") . ",
                        book_copies = $book_copies,
                        available_copies = $available_copies_input,
                        book_pub = " . ($book_pub !== NULL ? "'$book_pub'" : "NULL") . ",
                        publisher_name = " . ($publisher_name !== NULL ? "'$publisher_name'" : "NULL") . ",
                        isbn = '$isbn',
                        copyright_year = " . ($copyright_year !== NULL ? "'$copyright_year'" : "NULL") . ",
                        status = '$status',
                        remarks = '$remark'
                        $image_update
                        WHERE book_id = '$book_id'";
                    
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
    
    // JavaScript for form validation
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