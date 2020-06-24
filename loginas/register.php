<?php
// prijungiu db
require_once "db.php";

$username = $password = $confirm_password = "";
$username_error = $password_error = $confirm_password_error = "";

// patikrinu ar informacija tikrai is form post 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //  jeigu nera jokio username, tuomet atsiranda username error text
    if (empty(trim($_POST["username"]))) {
        $username_error = "Please enter a username.";
    } else {
        // sukuriam statement
        $sql = "SELECT id FROM users WHERE username = ?";




        // paruosiam parametra
        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            // execute param
            if (mysqli_stmt_execute($stmt)) {
                // idedam rezultatus
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_error = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // uzdarom statement
            mysqli_stmt_close($stmt);
        }
    }








    // jei tuscias, arba maziau nei 6 chars

    if (empty(trim($_POST["password"]))) {
        $password_error = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    //tikrina confirm password: jei tuscias, ismeta error, jei ne, lygina su password ar nematch
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_error = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_error) && ($password != $confirm_password)) {
            $confirm_password_error = "Password did not match.";
        }
    }



    // patikrinam input error
    if (empty($username_error) && empty($password_error) && empty($confirm_password_error)) {

        // paruosiam sql 
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";


        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // nustatom param
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash


            if (mysqli_stmt_execute($stmt)) {
                // nukeliam i login page if ok 
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Freckle+Face&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <img src="images/avatar.png" />
        <h1>Sign Up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn loginBtn " value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>