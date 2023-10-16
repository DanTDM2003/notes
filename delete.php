<?php
    include "database.php";
    session_start();

    $sql = "DELETE FROM note WHERE note.id=$id AND note.note_name LIKE '$note_name'";
    mysqli_query($conn, $sql);
    header("Location: notes.php");
?>