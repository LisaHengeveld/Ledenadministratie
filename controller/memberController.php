<?php
include "./model/memberModel.php";

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
                    $this->model->createDataMember();
                    break;
                // Indien data is opgeslagen uit het 'update' formulier, roep functie aan om de data te wijzigen
                case 'update':
                    $this->model->updateDataMember();
            }
        }

        // Bouw de benodigde webpagina (door switch bepaald) op. In alle gevallen wordt de 'standaard' webpagina met een overzicht opgebouwd.
        // Wanneer op create, read of update is geklikt komt hier een extra 'overlay' overheen.
        $action = isset($_GET['action']) ? $_GET['action'] : 'no action'; // Betreffende actie, wanneer op een CRUD-knop is geklikt.
        switch ($action) {
            // Wanneer op create (toevoegen) is geklikt
            case 'create':
                $memberList = $this->model->getMemberList(); // Haal data van alle leden op
                $familyList = $this->model->getFamilyList(); // Haal data van families op
                $membershipList = $this->model->getmembershipList(); // Haal data van soort leden op
                include './view/header-and-nav.php';
                include './view/memberTable.php';
                include './view/memberCreate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op read (bekijk) is geklikt
            case 'read':
                $member = $this->model->getMember(); // Haal data van lid op, waarbij op read is geklikt
                $memberList = $this->model->getMemberList(); // Haal data van alle leden op
                include './view/header-and-nav.php';
                include './view/memberTable.php';
                include './view/memberRead.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op update (bewerk) is geklikt
            case 'update':
                $member = $this->model->getMember(); // Haal data van lid op, waarbij op update is geklikt
                $memberList = $this->model->getMemberList(); // Haal data van alle leden op
                $familyList = $this->model->getFamilyList(); // Haal data van alle failies op
                $membershipList = $this->model->getmembershipList(); // Haal data van alle soorten leden op
                include './view/header-and-nav.php';
                include './view/memberTable.php';
                include './view/memberUpdate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op delete (verwijder) is geklikt
            case 'delete':
                $this->model->deleteDataMember(); // Verwijdert de data van lid, waarbij op delete is geklikt
                break;
            // Wanneer op geen van de CRUD-knoppen is geklikt.
            default:
                include './view/header-and-nav.php';
                $memberList = $this->model->getMemberList(); // Haal data van alle leden op
                include './view/memberTable.php';
                include './view/footer.php'; 
        }
    }
}
?>