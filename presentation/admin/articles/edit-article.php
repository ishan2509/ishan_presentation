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
$title = $image_url = $content = '';
$title_err = $image_url_err = $content_err = '';


// Process form data on submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate title
    if (empty(trim($_POST['title']))) {
        $title_err = 'Please enter a title.';
    } else {
        $title = trim($_POST['title']);
    }

    // Validate image URL
    if (empty(trim($_POST['image_url']))) {
        $image_url_err = 'Please enter an image URL.';
    } else {
        $image_url = trim($_POST['image_url']);
    }

    // Validate content
    if (empty(trim($_POST['content']))) {
        $content_err = 'Please enter some content.';
    } else {
        $content = trim($_POST['content']);
    }


    // Check if there are no errors, update tutorial
    if (empty($title_err) && empty($image_url_err) && empty($content_err)) {
        // Prepare an update statement
        $sql = 'UPDATE articles SET title = ?, image_url = ?, content = ? WHERE id = ?';


        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('ssss', $param_title, $param_image_url, $param_content, $param_id);


            // Set parameters
            $param_title = $title;
            $param_image_url = $image_url;
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
    // Retrieve article data from database
    $sql = 'SELECT id, title, image_url, content FROM articles WHERE id = ?';


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
                $stmt->bind_result($id, $title, $image_url, $content);
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
    <title>Edit Article</title>
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
        <h2 class="text-center mb-4">Edit Article</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                <span class="help-block"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url" class="form-control" value="<?php echo $image_url; ?>">
                <span class="help-block"><?php echo $image_url_err; ?></span>
            </div>
            <div class="form-group">
                <label>Content</label>
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