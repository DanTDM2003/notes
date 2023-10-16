<?php
    include "database.php";
    session_start();
    $id = $_SESSION["id"];
    $table = "note_page";
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
    <title>Your Notes</title>
    <link rel="stylesheet" href="./css/note-manage.css">
    <link rel="stylesheet" href="./css/header.css">
</head>
<body>
    <?php
        include "header-footer/header.php";
    ?>
    <div class="container">
        <div class="add-section">
            <form class="add" method="post" action="notes-manage.php">
                <input name="note-name" id="note-name" type="text" placeholder="Enter a note's name..." required>
                <button type="submit" id="add-btn" name="add-btn" value="add">Add</button>
            </form>
            <div class="trash"><button id="trash-btn">Move to Trash</button></div>
        </div>
        <div class="manage-section">
            <div class="page-section">
                <?php
                    $sql = "SELECT *
                            FROM note_page AS nt
                            WHERE nt.id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<div id='warn'>No notes has been created</div>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["state"] == null) {
                                echo "<div class='note-box'>
                                      <div class='box-func'>
                                          <div>{$row["page_name"]}</div>
                                          <div class='form'>
                                              <button id='view-btn'><a href='view.php?page_name={$row["page_name"]}'><ion-icon name='eye-outline'></ion-icon></a></button>
                                              <button id='delete-btn'><a href='delete-page.php?page_name={$row["page_name"]}&state=tempt'><ion-icon name='trash-bin-outline'></ion-icon></a></button>
                                          </div>
                                      </div>
                                  </div>";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        if (isset($_POST["add-btn"])) {
            $page_name = filter_input(INPUT_POST, "note-name", FILTER_SANITIZE_SPECIAL_CHARS);
            $sql = "SELECT *
                    FROM note_page AS nt
                    WHERE nt.page_name = '$page_name' AND nt.id = '$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) != 0) {
                echo "This note name has been used";
            } else {
                $sql = "INSERT INTO note_page (id, page_name)
                        VALUES ($id, '$page_name')";
                mysqli_query($conn, $sql);
                header("Refresh:0");
            }
        }
    ?>
    <script src="index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>