<?php
    class Contribution {
        public $voornaam;
        public $achternaam;
        public $soort_lid;
        public $boekjaar;
        public $contributie;
        
        public function __construct($voornaam, $achternaam, $soort_lid, $boekjaar, $contributie) {
            $this->voornaam = $voornaam;
            $this->achternaam = $achternaam;
            $this->soort_lid = $soort_lid;
            $this->boekjaar = $boekjaar;
            $this->contributie = $contributie;
        }
    }

    class Model {
        public function getContributionsList() {
            include 'login.php'; // Maak verbinding met de database

            // Maak array voor de data
            $contributions = array();

            // Haal benodigde data op uit alle tabellen
            $stmt = $pdo->query("SELECT contributie.bedrag, boekjaar.jaar, familielid.naam AS voornaam, familie.naam, soort_lid.omschrijving 
                                 FROM contributie
                                 INNER JOIN boekjaar ON contributie.boekjaar=boekjaar.id
                                 INNER JOIN familielid ON contributie.familielid=familielid.id
                                 INNER JOIN familie ON familielid.familie=familie.id
                                 LEFT JOIN soort_lid ON familielid.soort_lid=soort_lid.id
                                 ORDER BY familie.naam, voornaam, boekjaar.jaar");

            if($stmt) {
                // Zolang er nog records in de data zijn, voeg deze toe aan de array
                while($row = $stmt->fetch()) {
                    $voornaam = htmlspecialchars($row['voornaam']);
                    $achternaam = htmlspecialchars($row['naam']);
                    $soort_lid = htmlspecialchars($row['omschrijving']);
                    $boekjaar = htmlspecialchars($row['jaar']);
                    $contributie = round(htmlspecialchars($row['bedrag'])); // bedrag afgerond naar een geheel getal

                    $contributions[] = new Contribution($voornaam, $achternaam, $soort_lid, $boekjaar, $contributie);
                }
            }

            // Geef de array met alle data terug
            return $contributions;
        }
    }
?>