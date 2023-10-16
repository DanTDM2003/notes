<?php
    include "database.php";
    session_start();

    foreach ($_SESSION["delete-items"] as $value) {
        $sql = "DELETE FROM note
                WHERE '{$_SESSION["id"]}' = id AND '{$_SESSION["page_name"]}' LIKE page_name AND '$value' LIKE note_name";
        mysqli_query($conn, $sql);
    }
    header("Location: notes-manage.php");
?>