<?php
session_start();

// Her laves sessionen, så brugeren kan logge ind og ud og tilgå siderne der er låst for gæster
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