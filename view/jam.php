<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<?php
include './includeviews/header.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/style.css">

</head>
<body>
    <section>
        <h1 class="coke">Jam</h1>
        <img src="../public/jam.png" alt="actually a toaster" id="toast">

    </section>

</body>
</html>

<?php
include './includeviews/footer.php';
?>