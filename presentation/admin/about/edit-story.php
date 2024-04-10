<?php
// Start session
session_start();


// Include config file
require_once '../../dbinfo.php';


// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    header('Location: ../../index.php');
    exit;
}


// Initialize variables
$content = '';
$content_err = '';


// Process form data on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {




    // Validate story content
    if (empty(trim($_POST['content']))) {
        $content_err = 'Please enter some content for the our story';
    } else {
        $content = trim($_POST['content']);
    }


    // Check if there are no errors, update tutorial
    if (empty($content_err)) {
        // Prepare an update statement
        $sql = 'UPDATE our_story SET content = ? WHERE id = ?';


        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('si', $param_content, $param_id);


            // Set parameters
            $param_content = $content;
            $param_id = $_GET['id'];


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to admin index
                header('Location: ../admin-index.php');
                exit;
            } else {
                echo 'Something went wrong. Please try again later.';
            }


            // Close statement
            $stmt->close();
        }
    }


    // Close connection
    $con->close();
} else {
    // Retrieve story data from database
    $sql = 'SELECT id, content FROM our_story WHERE id = ?';


    if ($stmt = $con->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param('i', $param_id);


        // Set parameters
        $param_id = $_GET['id'];


        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();


            // Check if article exists, if yes, populate form fields with its data
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $content);
                if ($stmt->fetch()) {
                    // Story data
                    // Display form with existing data
                }
            } else {
                // Tutorial does not exist, redirect to admin index
                header('Location: ../admin-index.php');
                exit;
            }
        } else {
            echo 'Oops! Something went wrong. Please try again later.';
        }


        // Close statement
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>Edit Tutorial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }


        .wrapper {
            max-width: 500px;
            margin: 0 auto;
        }


        .form-group {
            margin-bottom: 20px;
        }


        .help-block {
            color: #dc3545;
            font-size: 0.8em;
        }
    </style>
</head>


<body>
    <div class="wrapper">
        <h2 class="text-center mb-4">Edit Our Story</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="post">
            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" class="form-control"><?php echo $content; ?></textarea>
                <span class="help-block"><?php echo $content_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="../admin-index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


</html>
