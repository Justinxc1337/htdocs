<?php
include './includeviews/header.php';
?>

<!DOCTYPE html>

<html>

<head>
  <title>createUser</title>
  <link rel="stylesheet" type="text/css" href="../public/style.css">
  <meta charset="utf-8">
</head>

<body>
  <section>
    <!-- Bruger oprettes her og sættes ind i databasen som tillader at login virker med det nye Username og Password -->
    <h1 class="coke">Opret Bruger</h1>
    <form action="../controller/createUser.php" method="post">
      <label for="uname" class="cokey">Username:</label>
      <input name="username" id="uname" type="text"></input>
      <br><br>
      <label for="passw" class="cokey">Password:</label>
      <input name="password" id="passw" type="text"></input>
      <br><br>
      <input value="Opret Bruger" type="submit"></input>
    </form>
    <br>
    <a href="index.php" class="link">Gå til Login side</a>
  </section>
</body>

</html>

<?php
include './includeviews/footer.php';
?>