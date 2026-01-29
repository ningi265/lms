<?php
if (isset($_POST['submit'])) {
    include('include/dbcon.php');

    //Import uploaded file to Database
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    $count = 0;
    $successCount = 0;
    $errorCount = 0;
    $errors = array();

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($count == 0) {
            $count++;
            continue; // Skip header row
        }
        
        // Escape all values from CSV
        $escaped_data = array();
        foreach ($data as $key => $value) {
            $escaped_data[$key] = mysqli_real_escape_string($con, $value);
        }
        
        // Ensure we have at least 10 columns (0-9)
        if (count($escaped_data) >= 10) {
            $query = "INSERT INTO user 
                      (school_number, firstname, middlename, lastname, contact, gender, address, type, level, section, status, user_added)
                      VALUES
                      ('$escaped_data[0]', '$escaped_data[1]', '$escaped_data[2]', '$escaped_data[3]', 
                       '$escaped_data[4]', '$escaped_data[5]', '$escaped_data[6]', '$escaped_data[7]', 
                       '$escaped_data[8]', '$escaped_data[9]', 'Active', NOW())";
            
            if (mysqli_query($con, $query)) {
                $successCount++;
            } else {
                $errorCount++;
                $errors[] = "Row " . ($count + 1) . ": " . mysqli_error($con);
            }
        } else {
            $errorCount++;
            $errors[] = "Row " . ($count + 1) . ": Insufficient columns in CSV data";
        }
        
        $count++;
    }
    fclose($handle);

    // Display results
    if ($errorCount == 0) {
        echo "<script type='text/javascript'>alert('Successfully imported $successCount records!');</script>";
    } else {
        $errorMsg = "Imported $successCount records successfully. Failed: $errorCount records.";
        if (!empty($errors)) {
            $errorMsg .= "\\nErrors:\\n" . implode("\\n", array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $errorMsg .= "\\n... and " . (count($errors) - 5) . " more errors";
            }
        }
        echo "<script type='text/javascript'>alert('$errorMsg');</script>";
    }
    
    echo "<script>document.location='user.php'</script>";
}
?>