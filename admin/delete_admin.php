<?php 
include('include/dbcon.php');

if(isset($_GET['admin_id']) && !empty($_GET['admin_id'])) {
    $get_id = mysqli_real_escape_string($con, $_GET['admin_id']);
    $query = "DELETE FROM admin WHERE admin_id = '$get_id'";
    
    if(mysqli_query($con, $query)) {
        header('location:admin.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    header('location:admin.php');
    exit();
}
?>