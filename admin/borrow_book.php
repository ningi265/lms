<?php include ('header.php'); ?>
<?php 
$school_number = $_GET['school_number'];

// Single query to get user data
$user_query = mysqli_query($con,"SELECT * FROM user WHERE school_number = '$school_number' ");
$user_row = mysqli_fetch_array($user_query);

// Check if user is a teacher or student
$user_type = isset($user_row['type']) ? $user_row['type'] : 'Student';
$is_teacher = ($user_type == 'Teacher');

// Debug: Uncomment to check the value
// echo "User type value: " . $user_row['type'] . "<br>";
// echo "Is teacher: " . ($is_teacher ? 'Yes' : 'No');
?>
        <div class="page-title">
            <div class="title_left">
                <h3>
					<small>Home /</small> Borrowed Transaction
                </h3>
            </div>
        </div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
				<h2>
				Borrower Name : <span style="color:maroon;"><?php echo $user_row['firstname']." ".$user_row['middlename']." ".$user_row['lastname']; ?></span>
				<span class="label label-<?php echo $is_teacher ? 'info' : 'primary'; ?>" style="margin-left: 10px;">
					<?php echo $is_teacher ? 'Teacher' : 'Student'; ?>
				</span>
				</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->
				
				<div class="table-responsive">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="borrowedBooksTable">
						<thead>
							<tr>
								<th>Barcode</th>
								<th>Title</th>
								<th>Author</th>
								<th>ISBN</th>
								<?php if($is_teacher): ?>
								<th>Qty</th>
								<?php endif; ?>
								<th>Date Borrowed</th>
								<th>Due Date</th>
								<th>Penalty</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							// Modified query to group by book_id and get count for teachers
							if ($is_teacher) {
								// For teachers: Group by book_id to show quantity
								$borrow_query = mysqli_query($con,"SELECT 
										book.book_id,
										book.book_barcode,
										book.book_title,
										book.author,
										book.isbn,
										book.status,
										COUNT(borrow_book.borrow_book_id) as quantity,
										MIN(borrow_book.date_borrowed) as earliest_date_borrowed,
										MAX(borrow_book.due_date) as latest_due_date
									FROM borrow_book
									LEFT JOIN book ON borrow_book.book_id = book.book_id
									WHERE borrow_book.user_id = '".$user_row['user_id']."' 
									AND borrow_book.borrowed_status = 'borrowed'
									GROUP BY book.book_id
									ORDER BY earliest_date_borrowed DESC") or die(mysqli_error());
							} else {
								// For students: Show all rows as before
								$borrow_query = mysqli_query($con,"SELECT * FROM borrow_book
									LEFT JOIN book ON borrow_book.book_id = book.book_id
									WHERE user_id = '".$user_row['user_id']."' && borrowed_status = 'borrowed' ORDER BY borrow_book_id DESC") or die(mysqli_error());
							}
							
							$borrow_count = mysqli_num_rows($borrow_query);
							
							if ($borrow_count > 0) {
								if ($is_teacher) {
									// Display grouped results for teachers
									while($borrow_row = mysqli_fetch_array($borrow_query)){
										$due_date = $borrow_row['latest_due_date'];
										$date_borrowed = $borrow_row['earliest_date_borrowed'];
										
										$timezone = "Asia/Manila";
										if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
										$cur_date = date("Y-m-d H:i:s");
										$date_returned = date("Y-m-d H:i:s");
										
										$penalty_amount_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
										$penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
										
										$penalty = 'No Penalty';
										if ($date_returned > $due_date) {
											$penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
											$penalty = "₱" . number_format($penalty, 2);
										}
										
										// Format dates properly
										$date_borrowed_formatted = date("M d, Y h:i:s a", strtotime($date_borrowed));
										$due_date_formatted = ($borrow_row['status'] != 'Hardbound') 
											? date('M d, Y h:i:s a', strtotime($due_date))
											: 'Hardbound Book, Inside Only';
										
										$penalty_display = ($borrow_row['status'] != 'Hardbound') 
											? $penalty
											: 'Hardbound Book, Inside Only';
										
										// Get all borrow IDs for this book to return them all
										$borrow_ids_query = mysqli_query($con,"SELECT borrow_book_id FROM borrow_book 
											WHERE user_id = '".$user_row['user_id']."' 
											AND book_id = '".$borrow_row['book_id']."' 
											AND borrowed_status = 'borrowed'") or die(mysqli_error());
										$borrow_ids = array();
										while($id_row = mysqli_fetch_array($borrow_ids_query)) {
											$borrow_ids[] = $id_row['borrow_book_id'];
										}
										$borrow_ids_str = implode(',', $borrow_ids);
						?>
						<tr>
							<td><?php echo htmlspecialchars($borrow_row['book_barcode']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['book_title']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['author']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['isbn']); ?></td>
							<td><span class="badge bg-blue"><?php echo $borrow_row['quantity']; ?></span></td>
							<td><?php echo $date_borrowed_formatted; ?></td>
							<td><?php echo $due_date_formatted; ?></td>
							<td><?php echo $penalty_display; ?></td>
							<td>
							<form method="post" action="" style="margin: 0;">
							<input type="hidden" name="date_returned" value="<?php echo $date_returned; ?>">
							<input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
							<input type="hidden" name="borrow_book_ids" value="<?php echo $borrow_ids_str; ?>">
							<input type="hidden" name="book_id" value="<?php echo $borrow_row['book_id']; ?>">
							<input type="hidden" name="quantity" value="<?php echo $borrow_row['quantity']; ?>">
							<input type="hidden" name="date_borrowed" value="<?php echo $date_borrowed; ?>">
							<input type="hidden" name="due_date" value="<?php echo $due_date; ?>">
							<button name="return_all" class="btn btn-danger btn-xs" onclick="return confirm('Return all <?php echo $borrow_row['quantity']; ?> copy(ies) of this book?');">
								<i class="fa fa-undo"></i> Return All
							</button>
							</form>
							</td>
						</tr>
						<?php 
									}
								} else {
									// Display individual rows for students
									while($borrow_row = mysqli_fetch_array($borrow_query)){
										$due_date = $borrow_row['due_date'];
									
									$timezone = "Asia/Manila";
									if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
									$cur_date = date("Y-m-d H:i:s");
									$date_returned = date("Y-m-d H:i:s");
									
									$penalty_amount_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
									$penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
									
									$penalty = 'No Penalty';
									if ($date_returned > $due_date) {
										$penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
										$penalty = "₱" . number_format($penalty, 2);
									}
									
									// Format dates properly
									$date_borrowed_formatted = date("M d, Y h:i:s a", strtotime($borrow_row['date_borrowed']));
									$due_date_formatted = ($borrow_row['status'] != 'Hardbound') 
										? date('M d, Y h:i:s a', strtotime($borrow_row['due_date']))
										: 'Hardbound Book, Inside Only';
									
									$penalty_display = ($borrow_row['status'] != 'Hardbound') 
										? $penalty
										: 'Hardbound Book, Inside Only';
						?>
						<tr>
							<td><?php echo htmlspecialchars($borrow_row['book_barcode']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['book_title']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['author']); ?></td>
							<td><?php echo htmlspecialchars($borrow_row['isbn']); ?></td>
							<td><?php echo $date_borrowed_formatted; ?></td>
							<td><?php echo $due_date_formatted; ?></td>
							<td><?php echo $penalty_display; ?></td>
							<td>
							<form method="post" action="" style="margin: 0;">
							<input type="hidden" name="date_returned" value="<?php echo $date_returned; ?>">
							<input type="hidden" name="user_id" value="<?php echo $borrow_row['user_id']; ?>">
							<input type="hidden" name="borrow_book_id" value="<?php echo $borrow_row['borrow_book_id']; ?>">
							<input type="hidden" name="book_id" value="<?php echo $borrow_row['book_id']; ?>">
							<input type="hidden" name="date_borrowed" value="<?php echo $borrow_row['date_borrowed']; ?>">
							<input type="hidden" name="due_date" value="<?php echo $borrow_row['due_date']; ?>">
							<button name="return" class="btn btn-danger btn-xs"><i class="fa fa-undo"></i> Return</button>
							</form>
							</td>
						</tr>
						<?php 
									}
								}
							} else {
								echo '
								<tr>
									<td colspan="'.($is_teacher ? '9' : '8').'" class="text-center">
										<div class="alert alert-info">No books currently borrowed</div>
									</td>
								</tr>
								';
							}
						?>
						</tbody>
					</table>
				</div>
				
				<!-- Book borrowing section -->
				<div class="row" style="margin-top:30px;">
					<div class="col-md-12">
						<form method="post" class="form-inline">
							<div class="form-group">
								<label for="barcode" class="control-label">Scan/Enter Barcode:</label>
								<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Enter barcode here....." autofocus required style="margin-left: 10px; margin-right: 10px;">
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
							</div>
						</form>
					</div>
					
					<?php 
					if (isset($_POST['barcode'])){
						$barcode = mysqli_real_escape_string($con, $_POST['barcode']);
						
						$book_query = mysqli_query($con,"SELECT * FROM book WHERE book_barcode = '$barcode' ") or die(mysqli_error());
						$book_count = mysqli_num_rows($book_query);
						
						if ($book_count == 0){
							echo '
							<div class="col-md-12" style="margin-top: 20px;">
								<div class="alert alert-warning">
									<i class="fa fa-exclamation-triangle"></i> No match for the barcode entered!
								</div>
							</div>
							';
						} else {
							$book_row = mysqli_fetch_array($book_query);
							$available_copies = isset($book_row['available_copies']) ? $book_row['available_copies'] : $book_row['book_copies'];
					?>
					<div class="col-md-12" style="margin-top: 20px;">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-book"></i> Book Found</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3 text-center">
										<?php if($book_row['book_image'] != ""): ?>
										<img src="upload/<?php echo $book_row['book_image']; ?>" class="img-thumbnail" style="max-width: 200px;">
										<?php else: ?>
										<img src="images/book_image.jpg" class="img-thumbnail" style="max-width: 200px;">
										<?php endif; ?>
										<br><br>
										<div class="well">
											<h4>Available: 
												<span class="label label-<?php 
													if ($available_copies == 0) echo 'danger';
													elseif ($available_copies < $book_row['book_copies']) echo 'warning';
													else echo 'success';
												?>">
													<?php echo $available_copies; ?> / <?php echo $book_row['book_copies']; ?>
												</span>
											</h4>
										</div>
									</div>
									<div class="col-md-9">
										<h3><?php echo htmlspecialchars($book_row['book_title']); ?></h3>
										<hr>
										<table class="table table-striped">
											<tr>
												<th width="30%">Barcode:</th>
												<td><strong><?php echo $book_row['book_barcode']; ?></strong></td>
											</tr>
											<tr>
												<th>Author:</th>
												<td><?php echo htmlspecialchars($book_row['author']); ?></td>
											</tr>
											<tr>
												<th>ISBN:</th>
												<td><?php echo $book_row['isbn']; ?></td>
											</tr>
											<tr>
												<th>Status:</th>
												<td>
													<span class="label label-<?php 
														switch($book_row['status']) {
															case 'New': echo 'success'; break;
															case 'Old': echo 'primary'; break;
															case 'Lost': echo 'danger'; break;
															case 'Damaged': echo 'warning'; break;
															case 'Replacement': echo 'info'; break;
															case 'Hardbound': echo 'default'; break;
															default: echo 'default';
														}
													?>">
														<?php echo $book_row['status']; ?>
													</span>
												</td>
											</tr>
											<tr>
												<th>Remarks:</th>
												<td>
													<span class="label label-<?php echo ($book_row['remarks'] == 'Available') ? 'success' : 'danger'; ?>">
														<?php echo $book_row['remarks']; ?>
													</span>
												</td>
											</tr>
										</table>
										
										<?php if($available_copies > 0 && $book_row['status'] != 'Damaged' && $book_row['status'] != 'Lost'): ?>
										<hr>
										<form method="post" action="">
										<input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
										<input type="hidden" name="book_id" value="<?php echo $book_row['book_id']; ?>">
										
										<?php
										$allowable_days_query = mysqli_query($con,"SELECT * FROM allowed_days ORDER BY allowed_days_id DESC LIMIT 1") or die(mysqli_error());
										$allowable_days_row = mysqli_fetch_assoc($allowable_days_query);
										
										$timezone = "Asia/Manila";
										if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
										$cur_date = date("Y-m-d H:i:s");
										$date_borrowed = date("Y-m-d H:i:s");
										$due_date = date('Y-m-d H:i:s', strtotime("+".$allowable_days_row['no_of_days']." day"));
										?>
										<input type="hidden" name="due_date" value="<?php echo $due_date; ?>">
										<input type="hidden" name="date_borrowed" value="<?php echo $date_borrowed; ?>">
										
										<?php if($is_teacher): ?>
										<div class="form-group">
											<label for="quantity">Quantity to Borrow:</label>
											<select name="quantity" id="quantity" class="form-control" style="width: 100px; display: inline-block; margin-left: 10px;">
												<?php 
												$max_qty = min($available_copies, 10);
												for($i = 1; $i <= $max_qty; $i++): 
												?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?> copy<?php echo $i > 1 ? 'ies' : ''; ?></option>
												<?php endfor; ?>
											</select>
										</div>
										<br>
										<?php endif; ?>
										
										<button name="borrow" class="btn btn-success btn-lg">
											<i class="fa fa-check"></i> 
											<?php if($is_teacher): ?>
											Borrow Selected Copies
											<?php else: ?>
											Borrow This Book
											<?php endif; ?>
										</button>
										</form>
										<?php elseif($available_copies == 0): ?>
										<div class="alert alert-danger">
											<i class="fa fa-times-circle"></i> This book is currently not available for borrowing.
										</div>
										<?php elseif($book_row['status'] == 'Damaged' || $book_row['status'] == 'Lost'): ?>
										<div class="alert alert-warning">
											<i class="fa fa-exclamation-triangle"></i> This book cannot be borrowed at the moment.
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } } ?>
				</div>
				
				<?php
				// Handle book return - for individual returns (students or single copy returns)
				if (isset($_POST['return'])) {
					$user_id = $_POST['user_id'];
					$borrow_book_id = $_POST['borrow_book_id'];
					$book_id = $_POST['book_id'];
					$date_borrowed = $_POST['date_borrowed'];
					$due_date = $_POST['due_date'];
					$date_returned = $_POST['date_returned'];

					// Get current available copies
					$update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
					$copies_row = mysqli_fetch_assoc($update_copies);

					$available_copies = $copies_row['available_copies'];
					$new_available_copies = $available_copies + 1;

					// Don't exceed total copies
					$total_copies = $copies_row['book_copies'];
					if ($new_available_copies > $total_copies) {
						$new_available_copies = $total_copies;
					}

					// Update remarks based on available copies
					if ($new_available_copies == '0') {
						$remark = 'Not Available';
					} else {
						$remark = 'Available';
					}

					// Update available copies, NOT total copies
					mysqli_query($con,"UPDATE book SET available_copies = '$new_available_copies' where book_id = '$book_id'") or die (mysqli_error());
					mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
					
					$timezone = "Asia/Manila";
					if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
					$cur_date = date("Y-m-d H:i:s");
					$date_returned_now = date("Y-m-d H:i:s");
					
					$penalty_amount_query = mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
					$penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
					
					if ($date_returned > $due_date) {
						$penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
					} elseif ($date_returned < $due_date) {
						$penalty = 'No Penalty';
					} else {
						$penalty = 'No Penalty';
					}
				
					mysqli_query($con,"UPDATE borrow_book SET borrowed_status = 'returned', date_returned = '$date_returned_now', book_penalty = '$penalty' WHERE borrow_book_id = '$borrow_book_id' and user_id = '$user_id' and book_id = '$book_id' ") or die (mysqli_error());
					
					mysqli_query($con,"INSERT INTO return_book (user_id, book_id, date_borrowed, due_date, date_returned, book_penalty)
					values ('$user_id', '$book_id', '$date_borrowed', '$due_date', '$date_returned', '$penalty')") or die (mysqli_error());
					
					$report_history1 = mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
					$report_history_row1 = mysqli_fetch_array($report_history1);
					$admin_row1 = $report_history_row1['firstname']." ".$report_history_row1['middlename']." ".$report_history_row1['lastname'];	
					
					mysqli_query($con,"INSERT INTO report 
					(book_id, user_id, admin_name, detail_action, date_transaction)
					VALUES ('$book_id','$user_id','$admin_row1','Returned Book',NOW())") or die(mysqli_error());
					
					echo "<script>window.location='borrow_book.php?school_number=$school_number';</script>";
				}
				
				// Handle return all copies for teachers
				if (isset($_POST['return_all'])) {
					$user_id = $_POST['user_id'];
					$borrow_book_ids = $_POST['borrow_book_ids'];
					$book_id = $_POST['book_id'];
					$quantity = $_POST['quantity'];
					$date_borrowed = $_POST['date_borrowed'];
					$due_date = $_POST['due_date'];
					$date_returned = $_POST['date_returned'];

					// Get current available copies
					$update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
					$copies_row = mysqli_fetch_assoc($update_copies);

					$available_copies = $copies_row['available_copies'];
					$new_available_copies = $available_copies + $quantity;

					// Don't exceed total copies
					$total_copies = $copies_row['book_copies'];
					if ($new_available_copies > $total_copies) {
						$new_available_copies = $total_copies;
					}

					// Update remarks based on available copies
					if ($new_available_copies == '0') {
						$remark = 'Not Available';
					} else {
						$remark = 'Available';
					}

					// Update available copies, NOT total copies
					mysqli_query($con,"UPDATE book SET available_copies = '$new_available_copies' where book_id = '$book_id'") or die (mysqli_error());
					mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
					
					$timezone = "Asia/Manila";
					if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
					$cur_date = date("Y-m-d H:i:s");
					$date_returned_now = date("Y-m-d H:i:s");
					
					$penalty_amount_query = mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
					$penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
					
					if ($date_returned > $due_date) {
						$penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
					} elseif ($date_returned < $due_date) {
						$penalty = 'No Penalty';
					} else {
						$penalty = 'No Penalty';
					}
					
					// Update all borrow records for this book
					$borrow_ids_array = explode(',', $borrow_book_ids);
					foreach($borrow_ids_array as $borrow_id) {
						mysqli_query($con,"UPDATE borrow_book SET borrowed_status = 'returned', date_returned = '$date_returned_now', book_penalty = '$penalty' WHERE borrow_book_id = '$borrow_id' and user_id = '$user_id' and book_id = '$book_id' ") or die (mysqli_error());
						
						mysqli_query($con,"INSERT INTO return_book (user_id, book_id, date_borrowed, due_date, date_returned, book_penalty)
						values ('$user_id', '$book_id', '$date_borrowed', '$due_date', '$date_returned', '$penalty')") or die (mysqli_error());
					}
					
					$report_history1 = mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
					$report_history_row1 = mysqli_fetch_array($report_history1);
					$admin_row1 = $report_history_row1['firstname']." ".$report_history_row1['middlename']." ".$report_history_row1['lastname'];	
					
					mysqli_query($con,"INSERT INTO report 
					(book_id, user_id, admin_name, detail_action, date_transaction)
					VALUES ('$book_id','$user_id','$admin_row1','Returned '.$quantity.' copy(ies) of Book',NOW())") or die(mysqli_error());
					
					echo "<script>window.location='borrow_book.php?school_number=$school_number';</script>";
				}
				
				// Handle book borrowing
				if (isset($_POST['borrow'])){
					$user_id = $_POST['user_id'];
					$book_id = $_POST['book_id'];
					$date_borrowed = $_POST['date_borrowed'];
					$due_date = $_POST['due_date'];
					$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default to 1 if not set
					
					// Check if user is allowed to borrow more books
					$trapBookCount = mysqli_query($con,"SELECT count(*) as books_allowed from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed'") or die (mysqli_error());
					$countBorrowed = mysqli_fetch_assoc($trapBookCount);
					
					// For students, check if they already have this book
					if (!$is_teacher) {
						$bookCountQuery = mysqli_query($con,"SELECT count(*) as book_count from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed' and book_id = $book_id") or die (mysqli_error());
						$bookCount = mysqli_fetch_assoc($bookCountQuery);
						
						if ($bookCount['book_count'] == 1){
							echo "<script>alert('Book Already Borrowed!'); window.location='borrow_book.php?school_number=".$school_number."'</script>";
							exit();
						}
					}
					
					// Check allowed books per user
					$allowed_book_query = mysqli_query($con,"select * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
					$allowed = mysqli_fetch_assoc($allowed_book_query);
					
					if ($countBorrowed['books_allowed'] + $quantity > $allowed['qntty_books']){
						echo "<script>alert('Maximum ".$allowed['qntty_books']." books allowed per user!'); window.location='borrow_book.php?school_number=".$school_number."'</script>";
						exit();
					}
					
					// Get book details
					$update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
					$copies_row = mysqli_fetch_assoc($update_copies);

					$total_copies = $copies_row['book_copies'];
					$available_copies = $copies_row['available_copies'];
					$new_available_copies = $available_copies - $quantity;

					// Check if book is available
					if ($new_available_copies < 0){
						echo "<script>alert('Not enough copies available! Only $available_copies copies available.'); window.location='borrow_book.php?school_number=".$school_number."'</script>";
						exit();
					} elseif ($copies_row['status'] == 'Damaged'){
						echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrow_book.php?school_number=".$school_number."'</script>";
						exit();
					} elseif ($copies_row['status'] == 'Lost'){
						echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrow_book.php?school_number=".$school_number."'</script>";
						exit();
					} else {
						
						// Update remarks based on available copies
						if ($new_available_copies == '0') {
							$remark = 'Not Available';
						} else {
							$remark = 'Available';
						}
						
						// Update available copies
						mysqli_query($con,"UPDATE book SET available_copies = '$new_available_copies' where book_id = '$book_id' ") or die (mysqli_error());
						mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
						
						// Check if quantity_borrowed column exists
						$check_column = mysqli_query($con, "SHOW COLUMNS FROM borrow_book LIKE 'quantity_borrowed'");
						$column_exists = (mysqli_num_rows($check_column) > 0);
						
						// Insert multiple borrow records for teachers borrowing multiple copies
						for ($i = 0; $i < $quantity; $i++) {
							if ($column_exists) {
								// Column exists, use it
								mysqli_query($con,"INSERT INTO borrow_book(user_id, book_id, date_borrowed, due_date, borrowed_status, quantity_borrowed)
								VALUES('$user_id', '$book_id', '$date_borrowed', '$due_date', 'borrowed', '$quantity')") or die (mysqli_error());
							} else {
								// Column doesn't exist, use basic insert
								mysqli_query($con,"INSERT INTO borrow_book(user_id, book_id, date_borrowed, due_date, borrowed_status)
								VALUES('$user_id', '$book_id', '$date_borrowed', '$due_date', 'borrowed')") or die (mysqli_error());
							}
						}
						
						$report_history = mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
						$report_history_row = mysqli_fetch_array($report_history);
						$admin_row = $report_history_row['firstname']." ".$report_history_row['middlename']." ".$report_history_row['lastname'];	
						
						mysqli_query($con,"INSERT INTO report 
						(book_id, user_id, admin_name, detail_action, date_transaction)
						VALUES ('$book_id','$user_id','$admin_row','Borrowed $quantity copy(ies) of Book',NOW())") or die(mysqli_error());
						
						echo "<script>window.location='borrow_book.php?school_number=".$school_number."';</script>";
					}
				}
				?>
				
                        <!-- content ends here -->
                    </div>
                </div>
            </div>
        </div>

<!-- DataTables Initialization -->
<script>
$(document).ready(function() {
    // Simple DataTables initialization with error handling
    var table = $('#borrowedBooksTable');
    
    // Check if table has rows (excluding the "no books" message row)
    var hasDataRows = table.find('tbody tr').length > 0;
    var hasNoBooksMessage = table.find('tbody tr td[colspan]').length > 0;
    
    if (hasDataRows && !hasNoBooksMessage) {
        try {
            table.DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[<?php echo $is_teacher ? 5 : 4; ?>, "desc"]], // Sort by date borrowed column
                "language": {
                    "emptyTable": "No books currently borrowed",
                    "info": "Showing _START_ to _END_ of _TOTAL_ books",
                    "infoEmpty": "Showing 0 to 0 of 0 books",
                    "infoFiltered": "(filtered from _MAX_ total books)",
                    "lengthMenu": "Show _MENU_ books",
                    "search": "Search:",
                    "zeroRecords": "No matching books found"
                }
            });
        } catch(e) {
            console.error("DataTables error:", e);
            // Fallback - add basic table styling
            table.addClass('table-hover');
        }
    } else {
        // If no data or only "no books" message, hide the table controls
        table.find('thead').hide();
    }
});
</script>

<?php include ('footer.php'); ?>