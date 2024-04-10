<?php
// Start session
session_start();

// Include config file
require_once '../dbinfo.php';

// Assuming $con is your mysqli connection object

// Fetch current background image
$background_image_query = "SELECT header_background_image FROM banner WHERE id = 1";
$background_image_result = mysqli_query($con, $background_image_query);
$background_image_row = mysqli_fetch_assoc($background_image_result);
$background_image_url = $background_image_row['header_background_image'];

// Initialize variable for displaying messages
$message = "";

// If the new image URL is provided by the user
if(isset($_POST['new_image_url'])) {
    // Sanitize the input to prevent SQL injection
    $new_image_url = mysqli_real_escape_string($con, $_POST['new_image_url']);
    
    // Update the record in the table
    $update_query = "UPDATE banner SET header_background_image = '$new_image_url' WHERE id = 1";
    $update_result = mysqli_query($con, $update_query);
    
    if($update_result) {
        $message = "Background image updated successfully!";
    } else {
        $message = "Error updating background image: " . mysqli_error($con);
    }

    // Redirect to admin-index.php after completing the task
    header("Location: admin-index.php");
    exit; // Make sure to stop script execution after redirection
}

?>
