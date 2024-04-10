<?php
// Include the database connection file
require_once '../../dbinfo.php';


// Check if the tutorial ID is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];


    // Prepare a delete statement
    $sql = "DELETE FROM our_team WHERE id = ?";


    if ($stmt = $con->prepare($sql)) {
        // Bind the ID parameter
        $stmt->bind_param("i", $id);


        // Attempt to execute the statement
        if ($stmt->execute()) {
            // Redirect to the admin index page after successful deletion
            header("location: ../admin-index.php");
            exit();
        } else {
            echo "Error deleting record.";
        }


        // Close the statement
        $stmt->close();
    }


    // Close the database connection
    $con->close();
} else {
    // Redirect to the admin index page if the ID is not provided or invalid
    header("location: ../admin-index.php");
    exit();
}
?>
