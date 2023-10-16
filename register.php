<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;1,500&display=swap" rel="stylesheet">
</head>
<?php
    include "database.php";
    function checkUsername($username) {
        global $conn;
        $sql = "SELECT *
                FROM account AS acc
                WHERE acc.username LIKE '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return false;
        }
        return true;
    }

    function checkEmail($email) {
        global $conn;
        $sql = "SELECT *
                FROM account AS acc
                WHERE acc.email LIKE '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return false;
        }
        return true;
    }
?>
<body>
    <?php
        include "header-footer/header.php";
    ?>
    <div class="container">
        <div class="register-form">
            <h1>Create A New Account</h1>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="input">
                    <input type="text" name="username" placeholder="Enter A Username" required>
                </div>
                <div class="input">
                    <input type="password" name="password" placeholder="Enter A Password" required minlength=8>
                </div>
                <div class="input">
                    <input type="password" name="verified" placeholder="Verify Password" required>
                </div>
                <div class="input">
                    <input type="email" name="email" placeholder="Enter An Email" required>
                </div>
                <div id="warn">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                            $verified_password = filter_input(INPUT_POST, "verified", FILTER_SANITIZE_SPECIAL_CHARS);
                            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                            if (!checkUsername($username)) {
                                echo "This username has been taken";
                            } else if ($password != $verified_password) {
                                echo "Verify password wrongly";
                            } else if (!checkEmail($email)) {
                                echo "This email has been used";
                            } else {
                                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO account(username, password, email)
                                        VALUES ('$username', '$hash_password', '$email')";
                                mysqli_query($conn, $sql);
                                header("Location: login.php");
                            }
                        }
                    ?>
                </div>
                <div class="btn">
                    <button type="submit">Create Account</button>
                </div>
            </form>
            <div id="link">
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </div>
</body>
</html>