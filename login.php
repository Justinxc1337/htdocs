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


$stmt  = $conn->prepare("SELECT username, password FROM brugertabel WHERE username=?");
$stmt->bind_param("s", $user);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 1) {
  $row = mysqli_fetch_array($result);
  if (password_verify($pass, $row["password"])) {
    $res = "Bruger fundet " . $user;
  } else {
    $res = "Fejl: Forkert kodeord.";
  }
} else {
  $res = "Fejl: Bruger ikke fundet.";
}

$sql = "SELECT username, password FROM brugertabel WHERE username='$user'";
$result = ($conn->query($sql));
if ($result->num_rows == 0) {
  $sql = "INSERT INTO brugertabel (username, password) VALUES ('$user', '$pass')";
  $result = ($conn->query($sql));
  
  $res = $user . " tilføjet til databasen.";
  
} else {
  $res = "Fejl: Bruger eksisterer allerede.";
}


$conn->close();
?>

<html>

<head>
  <title>Php - Dag 1 - Svarside</title>
  <link rel="stylesheet" type="text/css" href="php-dag1.css">
  <meta charset="utf-8">
</head>

<body>
  Du tastede <?php echo $res;?>
</body>

</html>
