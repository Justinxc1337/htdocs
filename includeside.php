<?php
include 'header.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section>
        <h1>Super Duper Toaster mk11 med varmebehandling</h1>
        <img src="toaster.png" alt="actually a toaster" id="toast">
        <h2>1200 kr,-</h2>
    </section>
    <style>
        body {
            margin: 0;
            width: 100%;
            height: 100vh;
            box-sizing: border-box;
        }

        #toast {
            width: 20%;
            height: 50%;
        }

        section {
            background-color: lightgreen;
            text-align: center;
            margin: 0;
            padding-top: 0;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
        }
    </style>
</body>
</html>

<?php
include 'footer.php';
?>