<?php
include "./model/fiscalYearModel.php";

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
                    $this->model->createDataFiscalYear();
                    break;
                // Indien data is opgeslagen uit het 'update' formulier, roep functie aan om de data te wijzigen
                case 'update':
                    $this->model->updateDataFiscalYear();
            }
        }
        
        // Bouw de benodigde webpagina (door switch bepaald) op. In alle gevallen wordt de 'standaard' webpagina met een overzicht opgebouwd.
        // Wanneer op create, read of update is geklikt komt hier een extra 'overlay' overheen.
        $action = isset($_GET['action']) ? $_GET['action'] : 'no action'; // Betreffende actie, wanneer op een CRUD-knop is geklikt.
        switch ($action) {
            // Wanneer op create (toevoegen) is geklikt
            case 'create':
                $fiscalYearList = $this->model->getFiscalYearList(); // Haal data van alle boekjaren op
                include './view/header-and-nav.php';
                include './view/fiscalYearTable.php';
                include './view/fiscalYearCreate.php';  // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op read (bekijk) is geklikt
            case 'read':
                $fiscalYear = $this->model->getFiscalYear(); // Haal data van boekjaar op, waarbij op read is geklikt
                $fiscalYearList = $this->model->getFiscalYearList(); // Haal data van alle boekjaren op
                include './view/header-and-nav.php';
                include './view/fiscalYearTable.php';
                include './view/fiscalYearRead.php';  // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op update (bewerk) is geklikt
            case 'update':
                $fiscalYear = $this->model->getFiscalYear(); // Haal data van boekjaar op, waarbij op update is geklikt
                $fiscalYearList = $this->model->getFiscalYearList(); // Haal data van alle boekjaren op
                include './view/header-and-nav.php';
                include './view/fiscalYearTable.php';
                include './view/fiscalYearUpdate.php';  // Overlay
                include './view/footer.php'; 
                break;
            // Wanneer op delete (verwijder) is geklikt
            case 'delete':
                $this->model->deleteDataFiscalYear();
                break;
            // Wanneer op geen van de CRUD-knoppen is geklikt.
            default:
                include './view/header-and-nav.php';
                $fiscalYearList = $this->model->getFiscalYearList(); // Haal data van alle boekjaren op
                include './view/fiscalYearTable.php';
                include './view/footer.php'; 
        }
    }
}
?>