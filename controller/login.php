<?php
$user = $_POST["username"];
$pass = $_POST["password"];
$res = "";

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "logindb";

// Opret forbindelsen til databasen.
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

//Tjek forbindelsen - god stil.
if ($conn->connect_error) {
  die ("Connection failed: " . $conn->connect_error);
}
echo "Der er oprettet forbindelse.";


$stmt  = $conn->prepare("SELECT username, password FROM brugertabel WHERE username=?");
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows == 1) {
  $row = mysqli_fetch_array($result);
  if (password_verify($pass, $row['password'])) {
    $res = "Bruger fundet og password korrekt.";
  } else {
    $res = "Bruger fundet, men password forkert.";
  }
} else {
  $res = "Bruger eksisterer ikke.";
}

$conn->close();

$row = mysqli_fetch_array($result);
if (password_verify($pass, $row['password'])) {
    $res = "Bruger fundet og password korrekt.";
    $_SESSION["user"] = $user;
    $_SESSION['loggedin'] = true;
    header('Location: ../view/home.php');
    exit;
} else {
    $res = "Bruger fundet, men password forkert.";
}
?>

<html>

<head>
  <title>Php - Dag 1 - Svarside</title>
  <link rel="stylesheet" type="text/css" href="../public/style.css">
  <meta charset="utf-8">
</head>

<body>
  <p>Velkommen, <?php echo $_SESSION["user"];?></p>

  <?php echo $res;?>
</body>

</html>