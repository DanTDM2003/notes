<?php
    session_start();
    $_SESSION["username"] = "";
    $_SESSION["id"] = null;
    $_SESSION["delete-counter"] = 0;
    $_SESSION["delete-items"] = array();
    $_SESSION["state"] = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;1,500&display=swap" rel="stylesheet">
</head>
<?php
    include "database.php";
?>
<body>
    <?php
        include "header-footer/header.php";
    ?>
    <div class="container">
        <div class="login-form">
            <h1>Welcome To Notes</h1>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <div class="input">
                    <span class='icon'><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="username" placeholder="Enter A Username..." required>
                </div>
                <div class="input">
                    <span class='icon'><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" placeholder="Enter A Password..." required>
                </div>
                <p id="warn">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                            
                            $sql = "SELECT * 
                                    FROM account AS acc
                                    WHERE acc.username LIKE '$username'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) == 0) {
                                echo "This account does not exists";
                            } else {
                                $row = mysqli_fetch_assoc($result);
                                if (!password_verify($password, $row["password"])) {
                                    echo "Wrong password";
                                } else {
                                    $_SESSION["id"] = $row["id"];
                                    $_SESSION["username"] = $username;
                                    header("Location: notes-manage.php");
                                }
                            }
                        }
                    ?>
                </p>
                <div class="btn">
                    <button type="submit">Submit</button>
                </div>
                <div id="no-acc">
                    Don't have an account? <a id="link" href="register.php">Register now</a>
                </div>
            </form>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>