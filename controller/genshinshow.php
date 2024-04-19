<?php
include '../view/includeviews/header2.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genshin API</title>
</head>
<body>
    <main style="margin-top: 10px; text-align: center;">
        <form action="genshin.php" method="get">
            <label for="id">Enter a character ID:</label>
            <input type="number" id="id" name="id" min="1" max="51">
            <input type="submit" value="Submit">
        </form>
    </main>
