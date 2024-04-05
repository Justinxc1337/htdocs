<?php
include 'header.php';
?>

<html>

<head>
  <title>Php - Login</title>
  <link rel="stylesheet" type="text/css" href="php-dag1.css">
  <link rel="stylesheet" href="style.css">
  <meta charset="utf-8">
</head>

<body>
  <section>
    <h1 class="cokey">Login Side</h1>
    <form action="login.php" method="post">
      <label for="uname">Username:</label>
      <input name="username" id="uname" type="text"></input>
      <br><br>
      <label for="passw">Password:</label>
      <input name="password" id="passw" type="text"></input>
      <br><br>
      <input value="Login" type="submit"></input>
    </form>
  </section>
</body>

</html>

<?php
include 'footer.php';
?>