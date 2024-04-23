<?php
session_start();

if(isset($_POST['username'])) {
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
}

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}

?>