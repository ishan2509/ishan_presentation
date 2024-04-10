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
$title = $description = $video_url = '';
$title_err = $description_err = $video_url_err = '';


// Process form data on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate title
    if (empty(trim($_POST['title']))) {
        $title_err = 'Please enter a title.';
    } else {
        $title = trim($_POST['title']);
    }

    // Validate description
    if (empty(trim($_POST['description']))) {
        $description_err = 'Please enter a description.';
    } else {
        $description = trim($_POST['description']);
    }

    // Validate video_url
    if (empty(trim($_POST['video_url']))) {
        $video_url_err = 'Please enter a video URL.';
    } else {
        $video_url = trim($_POST['video_url']);
    }


    // Check if there are no errors, update tutorial
    if (empty($title_err) && empty($description_err) && empty($video_url_err)) {
        // Prepare an update statement
        $sql = 'UPDATE tutorials SET title = ?, description = ?, video_url = ? WHERE id = ?';


        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('sssi', $param_title, $param_description, $param_video_url, $param_id);


            // Set parameters
            $param_title = $title;
            $param_description = $description;
            $param_video_url = $video_url;
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
    $sql = 'SELECT id, title, description, video_url FROM tutorials WHERE id = ?';


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
                $stmt->bind_result($id, $title, $description, $video_url);
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
        <h2 class="text-center mb-4">Edit Tutorial</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group">
                <label>Video URL</label>
                 <input type="text" name="video_url" class="form-control" value="<?php echo htmlspecialchars($video_url); ?>">
                 <span class="help-block"><?php echo $video_url_err; ?></span>
            </div>

            <div>
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