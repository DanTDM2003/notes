<?php
    include "database.php";
    $page_name = $_GET["page_name"];
    $state = $_GET["state"];
    if ($state == "tempt") {
        $sql = "UPDATE note_page SET state = 'delete' WHERE page_name = '{$page_name}'";
        mysqli_query($conn, $sql);
        header("Location: notes-manage.php");
    } else {
        $sql = "DELETE FROM note_page WHERE page_name = '{$page_name}'";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM note WHERE page_name = '{$page_name}'";
        mysqli_query($conn, $sql);
        header("Location: trash.php");
    }
?>