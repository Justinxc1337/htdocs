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
echo "Der er forbindelse.";

$stmt = $conn->prepare("SELECT username, password FROM brugertabel WHERE username=?");
$stmt->bind_param("s", $user);
$stmt->execute(); 
$result = $stmt->get_result();

$hpass = password_hash($pass, PASSWORD_DEFAULT);

if ($result->num_rows == 0) {
  $stmt = $conn->prepare("INSERT INTO brugertabel (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $user, $hpass);
  $stmt->execute(); 
  
  $res = $user . " tilføjet til databasen.";
  
} else {
  $res = "Fejl: Bruger eksisterer allerede.";
}

$conn->close();

$_SESSION["user"] = $user;
header('Location: ../view/index.php');
?>

<html>

<head>
  <title>Php</title>
  <link rel="stylesheet" type="text/css" href="index.css">
  <meta charset="utf-8">
</head>

<body>
  <p>Velkommen, <?php echo $_SESSION["user"];?></p>
  
  <?php echo $res;?>
</body>

</html>
