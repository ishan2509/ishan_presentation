<?php
// Include the database connection file
include 'dbinfo.php';

// Fetch tutorials from the database
$tutorials_query = "SELECT * FROM tutorials";
$tutorials_result = mysqli_query($con, $tutorials_query);

// Fetch articles from the database
$articles_query = "SELECT * FROM articles";
$articles_result = mysqli_query($con, $articles_query);

// Fetch the background image URL from the database
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
<title>My Blog</title>
<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-hGJwpnOh+gQpJFEeMz+2Nkftnmc1T9F88JgfP5nA9ie0HWimEydhjPL4A5hQJz+I" crossorigin="anonymous">

</head>
<body>
<header style="background-image: url('<?php echo $background_image_url; ?>');">
    <h1>Assignment 2 - Dynamic Blog</h1>
    <?php include 'nav-bar.php'; ?>
    <div class="button-container">
        <a href="admin/login.php" class="admin-login-button"><i class="fas fa-user"></i>Admin Panel Login</a>
    </div>
</header>

<main>
    <aside>
        <?php while($tutorial = mysqli_fetch_assoc($tutorials_result)) { ?>
            <div class="tutorial-card">
                <h3><?php echo $tutorial['title']; ?></h3>
                <div class="video-container">
                <iframe width="1007" height="566" src="<?php 
                echo str_replace('width="560" height="315"', 'width="560" height="315"', $tutorial['video_url']); ?>"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>"
                </div>
            </div>
        <?php } ?>
    </aside>

    <article>
        <?php while($article = mysqli_fetch_assoc($articles_result)) { ?>
            <h2><?php echo $article['title']; ?></h2>
            <div class="blog-post">
                <img src="<?php echo $article['image_url']; ?>" alt="Image Description">
                <p><?php echo $article['content']; ?></p>
            </div>
        <?php } ?>
    </article>

</main>
<?php include 'footer.php'; ?>
</body>
</html>
