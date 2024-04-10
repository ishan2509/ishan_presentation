<?php
// Include the database connection file
require_once '../../dbinfo.php';


// Initialize variables
$title = $description = $video_url = '';
$title_err = $description_err = $video_url_err = '';


// Process form data when the form is submitted
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

    // Validate video URL
    if (empty(trim($_POST['video_url']))) {
        $video_url_err = 'Please enter a video URL.';
    } else {
        $video_url = trim($_POST['video_url']);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($description_err) && empty($video_url_err)) {
        // Prepare an insert statement
        $sql = 'INSERT INTO tutorials (title, description, video_url) VALUES (?, ?, ?)';

        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('sss', $param_title, $param_description, $param_video_url);

            // Set parameters
            $param_title = $title;
            $param_description = $description;
            $param_video_url = $video_url;

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
    <title>Add Tutorial</title>
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
    <h2>Add Tutorial</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo $title; ?>">
            <span><?php echo $title_err; ?></span>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description" rows="4" cols="50"><?php echo $description; ?></textarea>
            <span><?php echo $description_err; ?></span>
        </div>
        <div>
        <label>Video URL:</label>
        <input type="text" name="video_url" value="<?php echo $video_url; ?>">
        <span><?php echo $video_url_err; ?></span>
        <br><br>
        <iframe width="1007" height="566" src="<?php echo $video_url; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div>
            <input type="submit" value="Add Tutorial">
        </div>
    </form>
</div>
</body>
</html>