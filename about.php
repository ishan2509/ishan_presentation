<?php
include 'dbinfo.php'; // Include the database connection file

// Fetch data for "Our Story" from the database
$sql_story = "SELECT * FROM our_story";
$result_story = mysqli_query($con, $sql_story);
$row_story = mysqli_fetch_assoc($result_story);

// Fetch data for "Our Team" from the database
$sql_team = "SELECT * FROM our_team";
$result_team = mysqli_query($con, $sql_team);

$background_image_query = "SELECT header_background_image FROM banner WHERE id = 1"; 
$background_image_result = mysqli_query($con, $background_image_query);
$background_image_row = mysqli_fetch_assoc($background_image_result);
$background_image_url = $background_image_row['header_background_image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us</title>
<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" href="style/about.css">
</head>
<body>
<header style="background-image: url('<?php echo $background_image_url; ?>');">
    <div class="button-container">
        <a href="admin/login.php" class="admin-login-button"><i class="fas fa-user"></i>Admin Panel Login</a>
    </div>

    <h1>About Us</h1>
    <?php include 'nav-bar.php'; ?>
</header>
<main>
    <section>
        <h2>Our Story</h2>
        <p><?php echo $row_story['content']; ?></p>
    </section>
    <section>
        <h2>Our Team</h2>
        <ul>
            <?php while ($row_team = mysqli_fetch_assoc($result_team)) { ?>
                <li><?php echo $row_team['name']; ?> - <?php echo $row_team['position']; ?></li>
            <?php } ?>
        </ul>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
