<?php
include "./model/contributionsModel.php";

class Controller {
    public $model;
    
    public function __construct() {
        $this->model = new Model(); // Roep model aan
    }

    // Functie voor opbouwen van de webpagina
    public function invoke() {
        include './view/header-and-nav.php';
        $contributionsList = $this->model->getContributionsList(); // Haal alle benodigde data op
        include './view/contributionsTable.php';
        include './view/footer.php';
    }
}
?>