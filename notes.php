<?php
    include "database.php";
    session_start();
    // $sql = "ALTER TABLE note AUTO_INCREMENT = 1";
    // mysqli_query($conn, $sql);
    if (empty($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link rel="stylesheet" href="./css/notes.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&family=Pacifico&family=Roboto:ital,wght@0,400;0,500;1,500&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include "header-footer/header.php";
    ?>
    <div class="container">
        <div class="note-page">
            <div class="out-btn"><button id="out" onclick="deleteNote()"><ion-icon name="exit-outline"></ion-icon></button></div>
            <h1>Note's Name</h1>
            <div class="pad">
                <div class="note-content">
                    <form class="content" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
                        <div id="content" class="content-line">
                        <?php
                            $sql = "SELECT *
                                    FROM note
                                    WHERE note.id = {$_SESSION["id"]} AND note.page_name LIKE '{$_SESSION["page_name"]}'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) == 0) {
                                echo "<div class='warn'>No notes created</div>";
                            } else {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($_SESSION["delete-items"] != null) {
                                        if (!in_array($row["note_name"], $_SESSION["delete-items"])) {
                                            echo "<div id='delete' class='drag'>
                                                <div class='d'><strong class='d'>{$row["note_name"]}</strong>: {$row["content"]}</div>
                                                <div>
                                                    <input id='checkbox' type='checkbox' name='notes[]' value='{$row['note_name']}'>
                                                </div>
                                                </div>";
                                        }
                                    } else {
                                        echo "<div id='delete' class='drag'>
                                                <div class='d'><strong class='d'>{$row["note_name"]}</strong>: {$row["content"]}</div>
                                                <div>
                                                    <input type='checkbox' name='notes[]' value='{$row['note_name']}'>
                                                </div>
                                                </div>";
                                    }
                                }
                            }
                        ?>
                        </div>
                        <div class="del-save">
                            <button type="submit" name="delete" value="delete"><ion-icon name="trash-bin"></ion-icon></button>
                            <button type="submit" name="undo" value="undo"><ion-icon name="arrow-undo"></ion-icon></button>
                            <button type="submit" name="redo" value="redo"><ion-icon name="arrow-redo"></ion-icon></button>
                        </div>
                    </form>
                    <?php
                        if (isset($_POST["delete"]) && isset($_POST["notes"])) {
                            for ($i = 0; $i < count($_POST["notes"]); $i++) {
                                $_SESSION["delete-items"][$_SESSION["delete-counter"] + $i] = $_POST["notes"][$i];
                            }
                            $_SESSION["delete-counter"] += count($_POST["notes"]);
                            $_SESSION["state"] = "save";
                            header("Refresh:0");
                        } else if (isset($_POST["undo"]) && $_SESSION["delete-counter"] != 0) {
                            $_SESSION["tempt-delete-counter"] = $_SESSION["delete-counter"];
                            $_SESSION["tempt-delete-items"] = $_SESSION["delete-items"];
                            $_SESSION["delete-counter"] = 0;
                            $_SESSION["delete-items"] = null;
                            $_SESSION["state"] = "undo";
                            header("Refresh:0");
                        } else if (isset($_POST["redo"]) && isset($_SESSION["tempt-delete-items"]) && isset($_SESSION["state"])) {
                            if ($_SESSION["state"] == "undo") {
                                $_SESSION["delete-counter"] =  $_SESSION["tempt-delete-counter"];
                                $_SESSION["delete-items"] = $_SESSION["tempt-delete-items"];
                                header("Refresh:0");
                            }
                        }
                    ?>
                </div>
                <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
                    <div class="input-text">
                        <input type="text" name="title" placeholder="Enter title" required maxlength="10">
                        <input type="text" name="content" placeholder="Enter content" required>
                    </div>
                    <div class="btn">
                        <button class="function-btn" type="submit" name="add" value="add"><div class="add-btn"><ion-icon class="icon-add" name="add-circle"></ion-icon>Add</div></button>
                    </div>
                </form>
                <?php
                    if (isset($_POST["add"])) {
                        $note_name = $_POST["title"];
                        $content = $_POST["content"];
                        $id = $_SESSION["id"];
                        $sql = "INSERT INTO note (id, page_name, note_name, content)
                                VALUES ($id, '{$_SESSION["page_name"]}', '$note_name', '$content')";
                        mysqli_query($conn, $sql);
                        header("Refresh:0");
                    }
                ?>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        const dragArea = document.querySelector(".content-line");
        new Sortable(dragArea, {
            animation: 150
        });
    </script>
    <script src="index.js"></script>
</body>
</html>
