<?php
session_start();

// Check of er is ingelogd
// Stuur terug naar de inlogpagina indien de gebruikersnaam niet bekend is op de server
if (!isset($_SESSION['gebruikersnaam'])) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ledenadministratie</title>
        <link rel="stylesheet" href="./css/main.css">
        <script src="https://kit.fontawesome.com/d921f63147.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Header -->
        <header class="page-header">
            <h1>Ledenadministratie</h1>
        </header>

        <!-- Navigatiemenu -->
        <nav class="main-nav">
            <ul>
                <!-- Geef de link de class 'active', wanneer de betreffende pagina geopend is -->
                <li><a <?php if(basename($_SERVER['PHP_SELF']) == "home.php") echo "class='active'"; ?> href="./home.php">Home</a></li>
                <li><a <?php if(basename($_SERVER['PHP_SELF']) == "members.php") echo "class='active'"; ?> href="./members.php">Leden</a></li>
                <li><a <?php if(basename($_SERVER['PHP_SELF']) == "contributions.php") echo "class='active'"; ?> href="./contributions.php">Contributies</a></li>
                <li><a <?php if(basename($_SERVER['PHP_SELF']) == "membership.php") echo "class='active'"; ?> href="./membership.php">Soort leden</a></li>
                <li><a <?php if(basename($_SERVER['PHP_SELF']) == "fiscal-year.php") echo "class='active'"; ?> href="./fiscal-year.php">Boekjaar</a></li>
            </ul>
        </nav>

        <!-- Knop voor uitloggen -->
        <a class="btn-logout" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Uitloggen</a>