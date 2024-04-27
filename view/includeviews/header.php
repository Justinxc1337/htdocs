<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../public/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../public/js/nav.js"></script>
    <title>header</title>

</head>
<body>
    <header>
        <a href="includeside.php" id="headerlinktext"><h1 id="headername">Tomatkongen</h1></a>
        <h2 id="headertitel">De bedste hjemmegroet tomater</h2>
    </header>
    <!-- Header for PC -->
    <nav id="navmenu">
        <a href="includeside.php" class="navlinks">Forside</a>
        <a href="omos.php" class="navlinks">Om Os</a>
        <a href="produkter.php" class="navlinks">Produkter</a>
        <a href="kurv.php" class="navlinks">Min Kurv</a>
        <a href="genshinshow.php" class="navlinks">Genshin</a>
        <form action="session.php" method="post">
            <input type="submit" name="logout" value="Logout" class="navlinks2">
        </form>
    </nav>
    <!-- Header for mobil -->
    <nav class="topnav">
        <a href="includeside.php" class="active">Tomatkongen</a>
        <section id="myLinks">
            <a href="includeside.php" class="navlinks">Forside</a>
            <a href="omos.php" class="navlinks">Om Os</a>
            <a href="produkter.php" class="navlinks">Produkter</a>
            <a href="kurv.php" class="navlinks">Min Kurv</a>
            <a href="genshinshow.php" class="navlinks">Genshin</a>
        </section>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</body>
</html>