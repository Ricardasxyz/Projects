<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Freckle+Face&display=swap" rel="stylesheet">
    <link href="style/welcome.css" rel="stylesheet" />
</head>

<body>
    <div class="page-header">
        <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our website! ( Which, of course, is still in progress. )</h2>
    </div>
    <p>
        <!-- <a href="reset-password.php" class="btn loginBtn hoverbtn">Reset Your Password</a> -->
        <a href="logout.php" class="btn btn-success hoverbtn">Sign Out of Your Account</a>
    </p>
    <h1>To be continued.</h1>

</body>

</html>