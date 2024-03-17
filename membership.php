<?php
    include "controller/membershipController.php";
    $controller = new Controller();
    $controller->invoke(); // Roept controller aan die alle interactie van de gebruiker opgvangt
?>