<?php
session_start();

if (!isset($_SESSION["user"])) { $_SESSION["user"] = "Guest"; }

include './includeviews/header.php';
?>

<html>

<head>
  <title>Php - Login</title>
  <link rel="stylesheet" type="text/css" href="../public/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
</head>

<body>
  <main>
    <section>
      <h1 class="coke">Login Side</h1>
      <form action="../controller/login.php" method="post">
        <label for="uname" class="cokey">Brugernavn:</label>
        <input name="username" id="uname" type="text"></input>
        <br><br>
        <label for="passw" class="cokey">Adgangskode:</label>
        <input name="password" id="passw" type="text"></input>
        <br><br>
        <input value="Login" type="submit"></input>
      </form>
      <br>
      <a href="create.php" class="link">Gå til opret bruger side</a>
    </section>
  </main>
</body>

</html>