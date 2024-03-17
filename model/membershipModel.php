<?php
class Membership {
    public $id;
    public $omschrijving;
    public $korting;
    
    public function __construct($id, $omschrijving, $korting) {
        $this->id = $id;
        $this->omschrijving = $omschrijving;
        $this->korting = $korting * 100;
    }
}

class Model {
    public function getMembershipList() {
        include 'login.php'; // Maak verbinding met de database

        // Maak array voor de data
        $memberships = array();

        // Haal alle data op uit de tabel soort_lid
        $stmt = $pdo->query("SELECT * FROM soort_lid");

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $id = htmlspecialchars($row['id']);
                $omschrijving = htmlspecialchars($row['omschrijving']);
                $korting = htmlspecialchars($row['korting']);

                $memberships[] = new Membership($id, $omschrijving, $korting);
            }
        }

        // Geef de array met alle data terug
        return $memberships;
    }

    public function getMembership() {
        include 'login.php'; // Maak verbinding met de database

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Haal data op dat hoort bij het id
        $stmt = $pdo->prepare("SELECT * FROM soort_lid WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $omschrijving = htmlspecialchars($row['omschrijving']);
        $korting = htmlspecialchars($row['korting']);

        // Maak object aan met de gevonden data en geef deze terug
        $membership = new Membership($id, $omschrijving, $korting);
        return $membership;
    }

    public function createDataMembership() {
        include 'login.php'; // Maak verbinding met de database

        // Voeg nieuwe data toe
        $stmt = $pdo->prepare("INSERT INTO soort_lid(omschrijving, korting) VALUES(?,?)");
        $stmt->bindParam(1, $omschrijving, PDO::PARAM_STR);
        $stmt->bindParam(2, $korting, PDO::PARAM_STR);

        $omschrijving = $_POST['omschrijving'];
        $korting = $_POST['korting'] / 100;

        $stmt->execute();
    }

    public function updateDataMembership() {
        include 'login.php'; // Maak verbinding met de database

        // Pas de data (die overeenkomt met het unieke id dat is meegegeven in het formulier) 
        // aan met de nieuwe data uit het formulier
        $stmt = $pdo->prepare("UPDATE soort_lid SET id=?, omschrijving=?, korting=? WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $omschrijving, PDO::PARAM_STR);
        $stmt->bindParam(3, $korting, PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);

        $id = $_POST['id'];
        $omschrijving = $_POST['omschrijving'];
        $korting = $_POST['korting'] / 100;

        $stmt->execute();

        // Bereken het nieuwe contributiebedrag en pas deze aan in de contributietabel
        // Haal hiervoor eers alle boekjaren met het basisbedrag op
        $fiscalYears = array();
        $stmt = $pdo->query("SELECT id, basisbedrag FROM boekjaar");

        if($stmt) {
            while($row = $stmt->fetch()) {
                $idBoekjaar = htmlspecialchars($row['id']);
                $basisbedrag = htmlspecialchars($row['basisbedrag']);

                $fiscalYears[$idBoekjaar] = $basisbedrag;
            }
        }

        // Pas alle records die horen bij het aangepaste soort lid aan met de nieuwe contributie
        $stmt = $pdo->prepare("UPDATE contributie 
                                INNER JOIN familielid ON contributie.familielid=familielid.id
                                SET contributie.bedrag=?
                                WHERE familielid.soort_lid=? AND boekjaar=?");
        foreach ($fiscalYears as $idBoekjaar => $basisbedrag) {
            $stmt->bindParam(1, $bedrag, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->bindParam(3, $idBoekjaar, PDO::PARAM_INT);

            // Bereken contributie
            $bedrag = $basisbedrag * (1 - $korting);

            $stmt->execute();
        }
    }

    public function deleteDataMembership() {
        include 'login.php';

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Bereken de nieuwe contributie (op basis van de standaard 0% korting) en sla deze op in de contributietabel, voordat het soort lid wordt verwijderd.
        // Haal hiervoor eers alle boekjaren met het basisbedrag op
        $fiscalYears = array();
        $stmt = $pdo->query("SELECT id, basisbedrag FROM boekjaar");

        if($stmt) {
            while($row = $stmt->fetch()) {
                $idBoekjaar = htmlspecialchars($row['id']);
                $basisbedrag = htmlspecialchars($row['basisbedrag']);

                $fiscalYears[$idBoekjaar] = $basisbedrag;
            }
        }

        // Pas alle records die horen bij het te verwijderden soort lid aan met de nieuwe contributie
        $stmt = $pdo->prepare("UPDATE contributie 
                                INNER JOIN familielid ON contributie.familielid=familielid.id
                                SET contributie.bedrag=?
                                WHERE familielid.soort_lid=? AND boekjaar=?");
        foreach ($fiscalYears as $idBoekjaar => $basisbedrag) {
            $stmt->bindParam(1, $basisbedrag, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->bindParam(3, $idBoekjaar, PDO::PARAM_INT);

            $stmt->execute();
        }

        // Verwijder uiteindelijk de record uit de tabel soort_lid die overeenkomt met meegegeven id
        $stmt = $pdo->prepare("DELETE FROM soort_lid WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        // Keer terug naar hoofdpagina
        header('location:membership.php');
    }
}
?>