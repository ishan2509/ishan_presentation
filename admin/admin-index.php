<?php
// Start session
session_start();

// Include config file
require_once '../dbinfo.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['role'])) {
    header('Location: ../index.php');
    exit;
}

// Check if the logged-in user is admin or user
if ($_SESSION['role'] === 'admin') {
    $canDelete = true;
    $dashboardTitle = "Admin Dashboard";
} else {
    $canDelete = false;
    $dashboardTitle = "Editor Dashboard";
}

// Fetch the background image URL from the database
$background_image_query = "SELECT header_background_image FROM banner WHERE id = 1";
$background_image_result = mysqli_query($con, $background_image_query);
$background_image_row = mysqli_fetch_assoc($background_image_result);
$background_image_url = $background_image_row['header_background_image'];

// Fetch tutorials from the database
$tu1 = "SELECT * FROM tutorials";
$tu2 = mysqli_query($con, $tu1);

// Fetch Articles from the database
$a1 = "SELECT * FROM articles";
$a2 = mysqli_query($con, $a1);

// Fetch team members from the database
$team_members_query = "SELECT * FROM our_team";
$team_members_result = mysqli_query($con, $team_members_query);

// Fetch story from the database
$story_query = "SELECT * FROM our_story";
$story_result = mysqli_query($con, $story_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dashboardTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }


        header {
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            padding: 50px 0; /* Increase the top and bottom padding */
            /* Add a dark shadow */
            box-shadow: inset 0 0 2000px rgba(0, 0, 0, 0.5);
        }


        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }


        main {
            padding: 20px;
        }


        h1 {
            margin-top: 0;
        }


        section {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }


        ul {
            padding: 0;
            list-style-type: none;
        }


        ul li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }


        ul li a {
            color: #007bff;
            text-decoration: none;
            margin-left: 10px;
        }


        form {
            margin-top: 20px;
        }


        label {
            display: block;
            margin-bottom: 5px;
        }


        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }


        input[type="submit"] {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }


        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>


<body>
    <header style="background-image: url('<?php echo $background_image_url; ?>');">
        <h1><?php echo $dashboardTitle; ?></h1>
        <nav>
            <ul>
                <li><a href="../index.php" target="_blank">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>


    <main>

        <section>
    <h2>Tutorials</h2>
    <ul>
        <?php 
        // Reset internal pointer of the result set
        mysqli_data_seek($tu2, 0);
        
        // Loop through tutorials
        while ($tu = mysqli_fetch_assoc($tu2)) : ?>
            <li>
                <div>
                    <?php echo $tu['title']; ?>
                </div>
                <div>
                    <a href="tutorials/edit-tutorial.php?id=<?php echo $tu['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <?php if ($canDelete) : ?>
                        <a href="tutorials/delete-tutorial.php?id=<?php echo $tu['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
        </section>


        <section>
            <h2>Add New Tutorial</h2>
            <form action="tutorials/add-tutorial.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required><br><br>
                <label for="video_url">Video URL:</label>
                <input type="text" id="video_url" name="video_url" required><br><br>
                <input type="submit" value="Add Tutorial">
            </form>
        </section>

    <section>
    <h2>Articles</h2>
    <ul>
        <?php 
        // Reset internal pointer of the result set
        mysqli_data_seek($a2, 0);
        
        // Loop through articles
        while ($a = mysqli_fetch_assoc($a2)) : ?>
            <li>
                <div>
                    <?php echo $a['title']; ?>
                </div>
                <div>
                    <?php echo substr($a['content'], 0, 100) . (strlen($a['content']) > 100 ? '...' : ''); ?>
                </div>
                <div>
                    <a href="articles/edit-article.php?id=<?php echo $a['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <?php if ($canDelete) : ?>
                        <a href="articles/delete-article.php?id=<?php echo $a['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
    </section>


        <section>
            <h2>Add New Article</h2>
            <form action="articles/add-article.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" required><br><br>
                <label for="content">Content:</label>
                <textarea type="text" id="content" name="content" required></textarea><br><br>

                <input type="submit" value="Add Article">
            </form>
        </section>

        <section>
            <h2>Edit Banner Image</h2>
            <form action="edit-banner.php" method="post">
             <label for="header_background_image">New Banner Image URL:</label>
             <input type="text" id="header_background_image" name="new_image_url" required><br><br>
             <input type="submit" class="btn btn-primary" value="Update">
             </form>
        </section>


    <section>
    <h2>Team Members</h2>
    <ul>
        <?php 
        // Reset internal pointer of the result set
        mysqli_data_seek($team_members_result, 0);
        
        // Loop through team members
        while ($team_member = mysqli_fetch_assoc($team_members_result)) : ?>
            <li>
                <div>
                    <?php echo $team_member['name']; ?>
                </div>
                <div>
                    <?php echo $team_member['position']; ?>
                </div>
                <div>
                    <a href="about/edit-member.php?id=<?php echo $team_member['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <?php if ($canDelete) : ?>
                        <a href="about/delete-member.php?id=<?php echo $team_member['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
    </section>




        <section>
            <h2>Add New Team Member</h2>
            <form action="about/add-member.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" required><br><br>
               
                <input type="submit" value="Add Team Member">
            </form>
        </section>

        <section>
            <h2>Our Story</h2>
            <ul>
            <?php while ($story = mysqli_fetch_assoc($story_result)) { ?>
                    <li>
                        <div>
                            <?php echo $story['content']; ?>
                        </div>
                        <div>
                            <a href="about/edit-story.php?id=<?php echo $story['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </section>
    </main>
</body>


</html>
