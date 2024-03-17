<?php
session_start();

// Maak verbinding met de database
include 'model/login.php';

// Check of er een poging is gedaan om in te loggen
if (isset($_POST['login'])) {
    // Sla ingevoerde gebruikersnaam en wachtwoord op
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Haal bijbehorende data uit database
    $stmt = $pdo->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam=?');
    $stmt->bindParam(1, $gebruikersnaam, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check of gebruikersnaam en wachtwoord kloppen
    if (!$result) {
        $error_msg = "Combinatie van gebruikersnaam en wachtwoord is niet juist";
    } else {
        if (password_verify($wachtwoord, $result['wachtwoord'])) {
            // Maak een sessie variabele, zodat te zien is dat is ingelogd
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;

            // Stuur door naar de homepagina
            header('location:home.php');
        } else {
            $error_pw = "Het wachtwoord is onjuist";
        }
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ledenadministratie - Inloggen</title>
        <link rel="stylesheet" href="./css/main.css">
        <script src="https://kit.fontawesome.com/d921f63147.js" crossorigin="anonymous"></script>
    </head>
<body>
    <article class="bg-modal create">
        <div class="modal-content create">
            <h2>Ledenadministratie</h2>
            <form id="login" method="post">
                <div class="prefix">
                    <label>Gebruikersnaam:</label>
                    <input type="text" name="gebruikersnaam" maxlength="100" autocomplete="off" required autofocus>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="prefix">
                    <label>Wachtwoord:</label>
                    <input type="password" name="wachtwoord" required>
                    <?php
                        // Toon foutmelding indien gebruikersnaam niet is gevonden of het wachtwoord niet overeenkomt
                        if (isset($error_msg)) echo '<p class="error-msg">' . $error_msg . '</p>';
                        if (isset($error_pw)) echo '<p class="error-msg">' . $error_pw . '</p>'; 
                    ?>
                    <i class="fa-solid fa-key"></i>
                </div>
                <button class="btn-submit" type="submit" name="login" value="login">Inloggen</button>
            </form>
        </div>
    </article>
</body>
</html>