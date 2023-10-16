<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit();
}

// Access user information from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo $name; ?>!</h1>
    <p>Your username is: <?php echo $username; ?></p>
    <p>User ID: <?php echo $user_id; ?></p>

    <!-- Add additional content as needed -->

    <p><a href="../logout.php">Logout</a></p>
</body>
</html>
