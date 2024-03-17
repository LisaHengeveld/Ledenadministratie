<?php
include "./model/membershipModel.php";

class Controller {
    public $model;
    
    public function __construct() {
        $this->model = new Model(); // Roep model aan
    }

    // Functie voor opbouwen van de webpagina
    public function invoke() {
        
        // Check eerst of er (nieuwe) data is binnengekomen via een formulier, voor dat de website wordt opgebouwd
        if(isset($_POST['submit'])) {
            switch ($_POST['submit']) {
                // Indien data is opgeslagen uit het 'create' formulier, roep functie aan om de data op te slaan
                case 'create':
                    $this->model->createDataMembership();
                    break;
                // Indien data is opgeslagen uit het 'update' formulier, roep functie aan om de data te wijzigen
                case 'update':
                    $this->model->updateDataMembership();
            }
        }
        
        // Bouw de benodigde webpagina (door switch bepaald) op. In alle gevallen wordt de 'standaard' webpagina met een overzicht opgebouwd.
        // Wanneer op create, read of update is geklikt komt hier een extra 'overlay' overheen.
        $action = isset($_GET['action']) ? $_GET['action'] : 'no action'; // Betreffende actie, wanneer op een CRUD-knop is geklikt.
        switch ($action) {
            // Wanneer op create (toevoegen) is geklikt
            case 'create':
                $membershipList = $this->model->getMembershipList(); // Haal data op van alle soorten leden
                include './view/header-and-nav.php';
                include './view/membershipTable.php';
                include './view/membershipCreate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op read (bekijk) is geklikt
            case 'read':
                $membership = $this->model->getMembership(); // Haal data van soort lid op, waarbij op read is geklikt
                $membershipList = $this->model->getMembershipList(); // Haal data op van alle soorten leden
                include './view/header-and-nav.php';
                include './view/membershipTable.php';
                include './view/membershipRead.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op update (bewerk) is geklikt
            case 'update':
                $membership = $this->model->getMembership(); // Haal data van soort lid op, waarbij op update is geklikt
                $membershipList = $this->model->getMembershipList(); // Haal data op van alle soorten leden
                include './view/header-and-nav.php';
                include './view/membershipTable.php';
                include './view/membershipUpdate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op delete (verwijder) is geklikt
            case 'delete':
                $this->model->deleteDataMembership(); // Verwijdert de data van het soort lid, waarbij op delete is geklikt
                break;
            // Wanneer op geen van de CRUD-knoppen is geklikt.
            default:
                include './view/header-and-nav.php';
                $membershipList = $this->model->getMembershipList(); // Haal data op van alle soorten leden
                include './view/membershipTable.php';
                include './view/footer.php'; 
        }
    }
}
?>