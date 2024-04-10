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
$name = $position = '';
$name_err = $position_err = '';


// Process form data on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate name
    if (empty(trim($_POST['name']))) {
        $name_err = 'Please enter a name.';
    } else {
        $name = trim($_POST['name']);
    }


    // Validate position
    if (empty(trim($_POST['position']))) {
        $position_err = 'Please enter a position.';
    } else {
        $position = trim($_POST['position']);
    }


    // Check if there are no errors, update tutorial
    if (empty($name_err) && empty($position_err)) {
        // Prepare an update statement
        $sql = 'UPDATE our_team SET name = ?, position = ? WHERE id = ?';


        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('ssi', $param_name, $param_position, $param_id);


            // Set parameters
            $param_name = $name;
            $param_position = $position;
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
    // Retrieve article data from database
    $sql = 'SELECT id, name, position FROM our_team WHERE id = ?';


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
                $stmt->bind_result($id, $name, $position);
                if ($stmt->fetch()) {
                    // Article data
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
        <h2 class="text-center mb-4">Edit Our Team</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" value='<?php echo $position; ?>'>
                <span class="help-block"><?php echo $position_err; ?></span>
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
