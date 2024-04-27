<?php 
include 'session.php';
include 'checkSession.php';
include './includeviews/header.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/api.css">
    <title>Genshin API</title>
</head>
<body>
    <!-- Selve API'en, benyttet en random spil relateret API -->
    <main style="margin-top: 10px; text-align: center;">
        <form action="../controller/genshin.php" method="get">
            <label for="id" id="text">Enter a character ID:</label>
            <input type="number" id="id" name="id" min="1" max="51">
            <input type="submit" value="Submit">
        </form>
    </main>
