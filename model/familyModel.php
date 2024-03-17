<?php
class Family {
    public $id;
    public $naam;
    public $adres;
    
    public function __construct($id, $naam, $adres) {
        $this->id = $id;
        $this->naam = $naam;
        $this->adres = $adres;
    }
}

class FamilyContribution {
    public $id;
    public $naam;
    public $bedrag;
    
    public function __construct($id, $naam, $bedrag) {
        $this->id = $id;
        $this->naam = $naam;
        $this->bedrag = $bedrag;
    }
}

class Model {
    public function getFamilyList() {
        include 'login.php'; // Maak verbinding met de database

        // Maak array voor de data
        $families = array();

        // Haal alle data op uit de tabel familie
        $stmt = $pdo->query("SELECT familie.id, familie.naam, sum(contributie.bedrag)
                                FROM familie
                                LEFT JOIN familielid ON familie.id=familielid.familie
                                LEFT JOIN contributie ON familielid.id=contributie.familielid
                                GROUP BY familie.id, familie.naam
                                ORDER BY familie.naam");

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $id = htmlspecialchars($row['id']);
                $naam = htmlspecialchars($row['naam']);
                $bedrag = round(htmlspecialchars($row['sum(contributie.bedrag)']));
                
                $families[] = new FamilyContribution($id, $naam, $bedrag);
            }
        }
        
        // Geef de array met alle data terug
        return $families;
    }

    public function getFamily() {
        include 'login.php'; // Maak verbinding met de database

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Haal data op dat hoort bij het id
        $stmt = $pdo->prepare("SELECT * FROM familie WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $naam = htmlspecialchars($row['naam']);
        $adres = htmlspecialchars($row['adres']);

        // Maak object aan met de gevonden data en geef deze terug
        $family = new Family($id, $naam, $adres);
        return $family;
    }

    public function createDataFamily() {
        include 'login.php'; // Maak verbinding met de database

        // Voeg nieuwe data toe
        $stmt = $pdo->prepare("INSERT INTO familie(naam, adres) VALUES(?,?)");
        $stmt->bindParam(1, $naam, PDO::PARAM_STR);
        $stmt->bindParam(2, $adres, PDO::PARAM_STR);

        $naam = $_POST['naam'];
        $adres = $_POST['adres'];

        $stmt->execute();
    }

    public function readDataFamily() {
        include 'login.php'; // Maak verbinding met de database

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Maak array voor de data
        $members = array();

        // Haal alle data op uit de tabel familie
        $stmt = $pdo->prepare("SELECT familielid.naam, sum(contributie.bedrag)
                                FROM familielid
                                INNER JOIN contributie ON familielid.id=contributie.familielid
                                INNER JOIN familie ON familielid.familie=familie.id
                                WHERE familie.id=?
                                GROUP BY familielid.naam");

        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $naam = htmlspecialchars($row['naam']);
                $bedrag = round(htmlspecialchars($row['sum(contributie.bedrag)']));
                
                $members[$naam] = $bedrag;
            }
        }
        
        // Geef de array met alle data terug
        return $members;
    }

    public function updateDataFamily() {
        include 'login.php'; // Maak verbinding met de database

        // Pas de data (die overeenkomt met het unieke id dat is meegegeven in het formulier) 
        // aan met de nieuwe data uit het formulier
        $stmt = $pdo->prepare("UPDATE familie SET id=?, naam=?, adres=? WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $naam, PDO::PARAM_STR);
        $stmt->bindParam(3, $adres, PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);

        $id=$_POST['id'];
        $naam=$_POST['naam'];
        $adres=$_POST['adres'];

        $stmt->execute();
    }

    public function deleteDataFamily() {
        include 'login.php';

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Verwijder record die overeenkomt met meegegeven id
        $stmt = $pdo->prepare("DELETE FROM familie WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        // Keer terug naar hoofdpagina, wanneer artikel is verwijderd
        header('location:home.php');
    }
}
?>