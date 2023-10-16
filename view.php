<?php
    session_start();
    $_SESSION["page_name"] = $_GET["page_name"];
    $_SESSION["table"] = $_GET["table"];
    header("Location: notes.php");
?>