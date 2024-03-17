<?php
include "./model/familyModel.php";

class Controller {
    public $model;
    
    public function __construct() {
        $this->model = new Model(); // Roep model aan
    }

    // Functie voor opbouwen van de homepage
    public function invoke() {
        
        // Check eerst of er (nieuwe) data is binnengekomen via een formulier, voor dat de website wordt opgebouwd
        if(isset($_POST['submit'])) {
            switch ($_POST['submit']) {
                // Indien data is opgeslagen uit het 'create' formulier, roep functie aan om de data op te slaan
                case 'create':
                    $this->model->createDataFamily();
                    break;
                // Indien data is opgeslagen uit het 'update' formulier, roep functie aan om de data te wijzigen
                case 'update':
                    $this->model->updateDataFamily();
            }
        }
        
        // Bouw de benodigde webpagina (door switch bepaald) op. In alle gevallen wordt de 'standaard' webpagina met een overzicht opgebouwd.
        // Wanneer op create, read of update is geklikt komt hier een extra 'overlay' overheen.
        $action = isset($_GET['action']) ? $_GET['action'] : 'no action'; // Betreffende actie, wanneer op een CRUD-knop is geklikt.
        switch ($action) {
            // Wanneer op create (toevoegen) is geklikt
            case 'create':
                $familyList = $this->model->getFamilyList(); // Haal data van alle families op
                include './view/header-and-nav.php';
                include './view/familyTable.php';
                include './view/familyCreate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op read (bekijk) is geklikt
            case 'read':
                $family = $this->model->getFamily(); // Haal data van familie op, waarbij op read is geklikt
                $familyList = $this->model->getFamilyList(); // Haal data van alle families op
                $members = $this->model->readDataFamily(); // Haalt ook data van contributies op
                include './view/header-and-nav.php';
                include './view/familyTable.php';
                include './view/familyRead.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op update (bewerk) is geklikt
            case 'update':
                $family = $this->model->getFamily(); // Haal data van familie op, waarbij op read is geklikt
                $familyList = $this->model->getFamilyList(); // Haal data van alle families op
                include './view/header-and-nav.php';
                include './view/familyTable.php';
                include './view/familyUpdate.php'; // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op delete (verwijder) is geklikt
            case 'delete':
                $this->model->deleteDataFamily(); // Verwijdert de data van de familie, waarbij op delete is geklikt
                break;
            // Wanneer op geen van de CRUD-knoppen is geklikt.
            default:
                include './view/header-and-nav.php';
                $familyList = $this->model->getFamilyList(); // Haal data van alle families op
                include './view/familyTable.php';
                include './view/footer.php'; 
        }
    }
}
?>