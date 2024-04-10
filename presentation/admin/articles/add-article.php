<?php
// Include the database connection file
require_once '../../dbinfo.php';


// Initialize variables
$title = $image_url = $content = '';
$title_err = $image_url_err = $content_err = '';


// Process form data when the form is submitted
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

    // Check input errors before inserting into database
    if (empty($title_err) && empty($image_url_err) && empty($content_err)) {
        // Prepare an insert statement
        $sql = 'INSERT INTO articles (title, image_url, content) VALUES (?, ?, ?)';

        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('sss', $param_title, $param_image_url, $param_content);

            // Set parameters
            $param_title = $title;
            $param_image_url = $image_url;
            $param_content = $content;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to the admin index page after successful addition
                header('location: ../admin-index.php');
                exit();
            } else {
                echo 'Something went wrong. Please try again later.';
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Close the database connection
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        span {
            color: #dc3545;
            font-size: 0.8em;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            display: block;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Add Article</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo $title; ?>">
            <span><?php echo $title_err; ?></span>
        </div>
        <div>
            <label>Image URL:</label>
            <input type="text" name="image_url" value="<?php echo $image_url; ?>">
            <span><?php echo $image_url_err; ?></span>
        </div>
        <div>
            <label>Content:</label>
            <textarea name="content" rows="4" cols="50"><?php echo $content; ?></textarea>
            <span><?php echo $content_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Add Article">
        </div>
    </form>
</div>
</body>
</html>