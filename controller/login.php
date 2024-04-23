<?php
include '../view/session.php';
include '../view/checkSession.php';
include '../view/includeviews/header2.php';

$user = $_POST["username"];
$pass = $_POST["password"];
$res = "forkert";

$dbserver = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "logindb";

$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
  die("Connection error: " . $conn->connect_error);
}

echo "Forbindelsen er oprettet.";

$stmt = $conn->prepare("SELECT username, password FROM brugertabel WHERE username=?");
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

$_SESSION["user"] = $user;
?>

<html>

<head>
  <title>ypu</title>
  <link rel="stylesheet" type="text/css" href="??.css">
  <meta charset="utf-8">
</head>

<body>
  <p>Velkommen, <?php echo $_SESSION["user"];?></p>

  <?php echo $res;?>
</body>

</html>
