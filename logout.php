<?php
    include "database.php";
    session_start();
    $id = $_SESSION["id"];

    if ($_SESSION["delete-counter"] > 0) {
        for ($i = 0; $i < $_SESSION["delete-counter"]; $i++) {
            $note_name = $_SESSION["delete-items"][$i];
            $sql = "DELETE FROM note
                    WHERE note.id = '$id' AND note.note_name LIKE '$note_name'";
            mysqli_query($conn, $sql);
        }
        $sql = "COMMIT";
        mysqli_query($conn, $sql);
    }
    session_destroy();
    header("Location: login.php");
?>