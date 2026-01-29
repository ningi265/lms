<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home /</small> Books
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <a href="book_print3.php" target="_blank" style="background:none;">
                <button class="btn btn-danger pull-right"><i class="fa fa-print"></i> Print Books List</button>
            </a>
            <a href="print_barcode13.php" target="_blank" style="background:none;">
                <button class="btn btn-danger pull-right"><i class="fa fa-print"></i> Print Books Barcode</button>
            </a>
            <br />
            <br />
            <div class="x_title">
                <h2><i class="fa fa-book"></i> Damaged Books List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="add_book.php" style="background:none;">
                            <button class="btn btn-primary"><i class="fa fa-plus"></i> Add Book</button>
                        </a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
                <ul class="nav nav-pills">
                    <li role="presentation"><a href="book.php">All</a></li>
                    <li role="presentation"><a href="new_books.php">New Books</a></li>
                    <li role="presentation"><a href="old_books.php">Old Books</a></li>
                    <li role="presentation"><a href="lost_books.php">Lost Books</a></li>
                    <li role="presentation" class="active"><a href="damage_books.php">Damaged Books</a></li>
                    <li role="presentation"><a href="sub_rep.php">Subject for Replacement Books</a></li>
                    <li role="presentation"><a href="hard_bound.php">Hardbound Books</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="width:100px;">Book Image</th>
                                <th>Barcode</th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th>Author/s</th>
                                <th>Total Copies</th>
                                <th>Available Copies</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($con, "SELECT * FROM book WHERE status = 'Damaged' ORDER BY book_id DESC") or die(mysqli_error());
                            while ($row = mysqli_fetch_array($result)) {
                                $id = $row['book_id'];
                                $category_id = $row['category_id'];
                                
                                $cat_query = mysqli_query($con, "SELECT * FROM category WHERE category_id = '$category_id'") or die(mysqli_error());
                                $cat_row = mysqli_fetch_array($cat_query);
                            ?>
                            <tr>
                                <td>
                                    <?php if($row['book_image'] != ""): ?>
                                        <img src="upload/<?php echo $row['book_image']; ?>" class="img-thumbnail" width="75px" height="50px">
                                    <?php else: ?>
                                        <img src="images/book_image.jpg" class="img-thumbnail" width="75px" height="50px">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a target="_blank" href="print_barcode_individual1.php?code=<?php echo $row['book_barcode']; ?>">
                                        <?php echo $row['book_barcode']; ?>
                                    </a>
                                    <button type="button" class="btn btn-xs btn-default copy-barcode" 
                                            data-barcode="<?php echo $row['book_barcode']; ?>" 
                                            title="Copy Barcode"
                                            data-toggle="tooltip"
                                            data-placement="top">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </td>
                                <td style="word-wrap: break-word; width: 10em;"><?php echo $row['book_title']; ?></td>
                                <td style="word-wrap: break-word; width: 10em;"><?php echo $row['isbn']; ?></td>
                                <td style="word-wrap: break-word; width: 10em;">
                                    <?php 
                                    $authors = array();
                                    if (!empty($row['author'])) $authors[] = $row['author'];
                                    if (!empty($row['author_2'])) $authors[] = $row['author_2'];
                                    if (!empty($row['author_3'])) $authors[] = $row['author_3'];
                                    if (!empty($row['author_4'])) $authors[] = $row['author_4'];
                                    if (!empty($row['author_5'])) $authors[] = $row['author_5'];
                                    echo implode("<br />", $authors);
                                    ?>
                                </td>
                                <td><?php echo $row['book_copies']; ?></td> 
                                <td>
                                    <?php 
                                    // Display available copies with color coding
                                    $available_copies = isset($row['available_copies']) ? $row['available_copies'] : 0;
                                    // Damaged books should always have 0 available copies
                                    echo '<span class="label label-danger">' . $available_copies . '</span>';
                                    ?>
                                </td> 
                                <td><?php echo $cat_row['classname']; ?></td> 
                                <td>
                                    <?php 
                                    // Display status with appropriate badge
                                    $status = $row['status'];
                                    $badge_class = '';
                                    switch($status) {
                                        case 'New': $badge_class = 'label-success'; break;
                                        case 'Old': $badge_class = 'label-primary'; break;
                                        case 'Lost': $badge_class = 'label-danger'; break;
                                        case 'Damaged': $badge_class = 'label-warning'; break;
                                        case 'Replacement': $badge_class = 'label-info'; break;
                                        case 'Hardbound': $badge_class = 'label-default'; break;
                                        default: $badge_class = 'label-default';
                                    }
                                    echo '<span class="label ' . $badge_class . '">' . $status . '</span>';
                                    ?>
                                </td> 
                                <td>
                                    <?php 
                                    // Display remarks with appropriate badge
                                    $remarks = $row['remarks'];
                                    // Damaged books should always show "Not Available"
                                    echo '<span class="label label-danger">Not Available</span>';
                                    ?>
                                </td> 
                                <td>
                                    <a class="btn btn-primary btn-xs" for="ViewAdmin" href="view_book.php<?php echo '?book_id='.$id; ?>">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <a class="btn btn-warning btn-xs" for="ViewAdmin" href="edit_book.php<?php echo '?book_id='.$id; ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td> 
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<!-- Copy Barcode JavaScript -->
<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Function to copy text to clipboard
    function copyToClipboard(text, button) {
        // Create a temporary textarea element
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.left = '-999999px';
        textarea.style.top = '-999999px';
        document.body.appendChild(textarea);
        
        // Select and copy the text
        textarea.select();
        textarea.setSelectionRange(0, 99999);
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                // Show success feedback
                const originalTitle = $(button).attr('data-original-title') || 'Copy Barcode';
                $(button).attr('data-original-title', 'Copied!');
                $(button).tooltip('show');
                
                // Reset tooltip after 1.5 seconds
                setTimeout(() => {
                    $(button).attr('data-original-title', originalTitle);
                    $(button).tooltip('hide');
                }, 1500);
            } else {
                $(button).attr('data-original-title', 'Failed to copy');
                $(button).tooltip('show');
                setTimeout(() => {
                    $(button).attr('data-original-title', 'Copy Barcode');
                    $(button).tooltip('hide');
                }, 1500);
            }
        } catch (err) {
            console.error('Error copying text: ', err);
            $(button).attr('data-original-title', 'Error copying');
            $(button).tooltip('show');
            setTimeout(() => {
                $(button).attr('data-original-title', 'Copy Barcode');
                $(button).tooltip('hide');
            }, 1500);
        }
        
        // Remove the temporary element
        document.body.removeChild(textarea);
    }
    
    // Use jQuery event delegation for dynamically added elements
    $(document).on('click', '.copy-barcode', function(e) {
        e.preventDefault();
        const barcode = $(this).data('barcode');
        copyToClipboard(barcode, this);
    });
    
    // Check if DataTable is already initialized to avoid re-initialization
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "drawCallback": function(settings) {
                // Re-initialize tooltips when table is redrawn
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }
});
</script>

<?php include ('footer.php'); ?>