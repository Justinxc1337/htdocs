<?php
include './includeviews/header.php';
session_start();
  
if (!isset($_SESSION["user"])) { $_SESSION["user"] = "Guest"; }
?>

<html>

<head>
  <title>Php - Login</title>
  <link rel="stylesheet" type="text/css" href="../public/style.css">
  <meta charset="utf-8">
</head>

<body>
  <section>
    <h1 class="coke">Login Side</h1>
    <form action="../controller/login.php" method="post">
      <label for="uname" class="cokey">Username:</label>
      <input name="username" id="uname" type="text"></input>
      <br><br>
      <label for="passw" class="cokey">Password:</label>
      <input name="password" id="passw" type="text"></input>
      <br><br>
      <input value="Login" type="submit"></input>
    </form>
    <br>
    <a href="create.php" class="link">Gå til opret bruger side</a>
  </section>
</body>

</html>

<?php
include './includeviews/footer.php';
?>