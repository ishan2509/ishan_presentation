<?php
include 'dbinfo.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert the form data into the feedback table
    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($con, $sql)) {
        // Alert message after successful submission
        echo '<script>alert("Feedback submitted successfully!");</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

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
<title>Contact Us</title>
<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" href="style/contact.css">
</head>
<body>
<header style="background-image: url('<?php echo $background_image_url; ?>');">
    <h1>Contact Us</h1>
    <?php include 'nav-bar.php'; ?>
    <div class="button-container">
        <a href="admin/login.php" class="admin-login-button"><i class="fas fa-user"></i>Admin Panel Login</a>
    </div>

</header>
<main>
    <section>
        <h2>Get in Touch</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
