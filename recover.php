<?php
    include "database.php";
    $page_name = $_GET["page_name"];
    $sql = "UPDATE note_page SET state = NULL WHERE page_name = '{$page_name}'";
    mysqli_query($conn, $sql);
    header("Location: notes-manage.php");
?>