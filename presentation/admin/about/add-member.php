<?php
// Include the database connection file
require_once '../../dbinfo.php';


// Initialize variables
$name = $position = '';
$name_err = $position_err =  '';


// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate name
    if (empty(trim($_POST['name']))) {
        $name_err = 'Please enter a name.';
    } else {
        $name = trim($_POST['name']);
    }


    // Validate image URL
    if (empty(trim($_POST['position']))) {
        $position_err = 'Please enter a position';
    } else {
        $position = trim($_POST['position']);
    }


    // Check input errors before inserting into database
    if (empty($name_err) && empty($position_err)) {
        // Prepare an insert statement
        $sql = 'INSERT INTO our_team (name, position) VALUES (?, ?)';


        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param('ss', $param_name, $param_position);


            // Set parameters
            $param_name = $name;
            $param_position = $position;


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
    <title>Add Team Member</title>
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


        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
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
        <h2>Add Team Member</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span><?php echo $name_err; ?></span>
            </div>
            <div>
                <label>Position:</label>
                <input type="text" name="position" value="<?php echo $position; ?>">
                <span><?php echo $position_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Add Team Member">
            </div>
        </form>
    </div>
</body>


</html>
