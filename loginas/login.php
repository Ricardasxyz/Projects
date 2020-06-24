<?php
// session pradzia
session_start();

// jei logged in, redirect i welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// connection su db file
require_once "db.php";

$username = $password = "";
$username_error = $password_error = "";

// isitikinam, kad data is form bus
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $username_error = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }


    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }


    if (empty($username_error) && empty($password_error)) {

        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);


            $param_username = $username;


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                // paziurim ar slaptazodis egzistuoja, jei taip bind 
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // slaptazodis geras, pradedam sesija
                            session_start();

                            // irasom informacija i session variable
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // nukeliam i welcome page
                            header("location: welcome.php");
                        } else {

                            $password_error = "The password you entered was not valid.";
                        }
                    }
                } else {

                    $username_error = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // uzdarom statement
            mysqli_stmt_close($stmt);
        }
    }

    // uzdarom connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Freckle+Face&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <img src="images/avatar.png" alt="avatar"/>
        <h1>Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" placeholder="example user:test" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" placeholder="example password:test123" name="password" class="form-control">
                <span class="help-block"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn loginBtn" value="Login">
            </div>
            <p>New User? <a href="register.php">Register here</a>.</p>
        </form>

    </div>
</body>

</html>