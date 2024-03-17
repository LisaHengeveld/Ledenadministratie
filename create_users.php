<?php
// Maak verbinding met de database
include 'model/login.php';

// Gebruikersnaam en wachtwoord (verander deze waarden om een nieuwe gebruiker toe te voegen)
$gebruikersnaam = "penningmeester";
$wachtwoord = "wwpenm";

// Check of de gebruikersnaam al bestaat
$stmt = $pdo->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam=?');
$stmt->bindParam(1, $gebruikersnaam, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();

// Stop het script en geef een foutmelding indien er data is gevonden en dus de gebruikersnaam al bestaat
if ($row) {
    die("Deze gebruikersnaam bestaat al");
// Voeg de nieuwe data toe indien de gebruikersnaam nog niet bestaat
} else {
    $stmt = $pdo->prepare('INSERT INTO gebruikers(gebruikersnaam, wachtwoord) VALUES(?, ?)');

    $stmt->bindParam(1, $gebruikersnaam, PDO::PARAM_STR);
    $stmt->bindParam(2, password_hash($wachtwoord, PASSWORD_DEFAULT), PDO::PARAM_STR);

    $stmt->execute();

    echo "Gebruiker toegevoegd";
}
?>