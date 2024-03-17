<?php
class Member {
    public $id;
    public $naam;
    public $familie;
    public $geboortedatum;
    public $leeftijd;
    public $soort_lid;
    
    public function __construct($id, $naam, $familie, $geboortedatum, $soort_lid) {
        $this->id = $id;
        $this->naam = $naam;
        $this->familie = $familie;
        $this->geboortedatum = date("d-m-Y", strtotime($geboortedatum));

        // Bereken leeftijd obv geboortedatum
        $this->leeftijd = $this->calcAge($geboortedatum);

        $this->soort_lid = $soort_lid;
    }

    // Functie voor berekenen leeftijd obv geboortedatum
    public static function calcAge($geboortedatum) {
        $geboortedatum = new DateTime($geboortedatum);
        $huidigeDatum = new DateTime();
        $verschil = $huidigeDatum->diff($geboortedatum);
        $leeftijd = $verschil->y;
        
        return $leeftijd;
    }
}

class Model {
    public function getMemberList() {
        include 'login.php'; // Maak verbinding met de database

        // Maak array voor de data
        $members = array();

        // Haal alle data op uit de tabel familielid en de bijbehorende familie uit de tabel familie
        $stmt = $pdo->query("SELECT familielid.id, familielid.naam, familielid.geboortedatum, familielid.soort_lid, familie.naam AS familie
                                FROM familielid
                                INNER JOIN familie ON familielid.familie=familie.id
                                ORDER BY familie, familielid.naam");

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $id = htmlspecialchars($row['id']);
                $naam = htmlspecialchars($row['naam']);
                $familie = htmlspecialchars($row['familie']);
                $geboortedatum = htmlspecialchars($row['geboortedatum']);
                $soort_lid = htmlspecialchars($row['soort_lid']);

                $members[] = new Member($id, $naam, $familie, $geboortedatum, $soort_lid);
            }
        }

        // Geef de array met alle data terug
        return $members;
    }

    public function getMember() {
        include 'login.php'; // Maak verbinding met de database

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Haal data op dat hoort bij het id
        $stmt = $pdo->prepare("SELECT familielid.naam, familielid.geboortedatum, familielid.soort_lid, familie.naam AS familie
                                FROM familielid
                                INNER JOIN familie ON familielid.familie=familie.id
                                WHERE familielid.id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $naam = htmlspecialchars($row['naam']);
        $familie = htmlspecialchars($row['familie']);
        $geboortedatum = htmlspecialchars($row['geboortedatum']);
        $soort_lid = htmlspecialchars($row['soort_lid']);

        // Maak object aan met de gevonden data en geef deze terug
        $member = new Member($id, $naam, $familie, $geboortedatum, $soort_lid);
        return $member;
    }

    public function getFamilyList() {
        include 'login.php'; // Maak verbinding met de database

        // Maak array voor de data
        $familyList = array();

        // Haal data van id en naam op uit de tabel familie
        $stmt = $pdo->query("SELECT id, naam FROM familie");

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $id = htmlspecialchars($row['id']);
                $naam = htmlspecialchars($row['naam']);

                $familyList[$id] = $naam;
            }
        }

        // Sorteer de array op naam (voor de dropdown bij create/update data member)
        asort($familyList);

        // Geef de array met alle data terug
        return $familyList;
    }

    public function getmembershipList() {
        include 'login.php'; // Maak verbinding met de database

        // Maak array voor de data
        $membershipList = array();

        // Haal data van id en omschrijving op uit de tabel soort_lid
        $stmt = $pdo->query("SELECT id, omschrijving FROM soort_lid");

        if($stmt) {
            // Zolang er nog records in de data zijn, voeg deze toe aan de array
            while($row = $stmt->fetch()) {
                $id = htmlspecialchars($row['id']);
                $omschrijving = htmlspecialchars($row['omschrijving']);

                $membershipList[$id] = $omschrijving;
            }
        }

        // Geef de array met alle data terug
        return $membershipList;
    }

    public function createDataMember() {
        include 'login.php'; // Maak verbinding met de database
        
        // Voeg nieuwe data toe
        $stmt = $pdo->prepare("INSERT INTO familielid(naam, geboortedatum, soort_lid, familie) VALUES(?,?,?,?)");
        $stmt->bindParam(1, $naam, PDO::PARAM_STR);
        $stmt->bindParam(2, $geboortedatum, PDO::PARAM_STR);
        $stmt->bindParam(3, $soort_lid, PDO::PARAM_INT);
        $stmt->bindParam(4, $familie, PDO::PARAM_INT);

        $naam = $_POST['naam'];
        $geboortedatum = date("Y-m-d", strtotime($_POST['geboortedatum']));
        $soort_lid = $_POST['soort_lid'];
        $familie = $_POST['familie'];

        $stmt->execute();
        $idFamilielid = $pdo->lastInsertId(); // Sla primary key op

        // Voeg bijbehorende data per boekjaar toe aan contributietabel
        // Bereken eerst leeftijd obv geboortedatum
        $leeftijd = Member::calcAge($geboortedatum);

        // Bepaal korting
        $stmt = $pdo->query("SELECT korting FROM soort_lid WHERE id=$soort_lid");
        $korting = $stmt->fetch();
        $korting = $korting['korting'];


        // Haal alle boekjaren met het basisbedrag op
        $fiscalYears = array();
        $stmt = $pdo->query("SELECT id, basisbedrag FROM boekjaar");

        if($stmt) {
            while($row = $stmt->fetch()) {
                $idBoekjaar = htmlspecialchars($row['id']);
                $basisbedrag = htmlspecialchars($row['basisbedrag']);

                $fiscalYears[$idBoekjaar] = $basisbedrag;
            }
        }

        // Voeg voor ieder boekjaar een nieuwe record toe aan de tabel contributies
        $stmt = $pdo->prepare("INSERT INTO contributie(leeftijd, familielid, bedrag, boekjaar) VALUES(?,?,?,?)");
        foreach ($fiscalYears as $idBoekjaar => $basisbedrag) {
            $stmt->bindParam(1, $leeftijd, PDO::PARAM_INT);
            $stmt->bindParam(2, $idFamilielid, PDO::PARAM_INT);
            $stmt->bindParam(3, $bedrag, PDO::PARAM_INT);
            $stmt->bindParam(4, $idBoekjaar, PDO::PARAM_INT);

            // Bereken contributie
            $bedrag = $basisbedrag * (1 - $korting);

            $stmt->execute();
        }
    }

    public function updateDataMember() {
        include 'login.php'; // Maak verbinding met de database

        // Pas de data (die overeenkomt met het unieke id dat is meegegeven in het formulier) aan met de nieuwe data uit het formulier
        $stmt = $pdo->prepare("UPDATE familielid SET id=?, naam=?, geboortedatum=?, soort_lid=?, familie=? WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $naam, PDO::PARAM_STR);
        $stmt->bindParam(3, $geboortedatum, PDO::PARAM_STR);
        $stmt->bindParam(4, $soort_lid, PDO::PARAM_INT);
        $stmt->bindParam(5, $familie, PDO::PARAM_INT);
        $stmt->bindParam(6, $id, PDO::PARAM_INT);

        $id=$_POST['id'];
        $naam = $_POST['naam'];
        $geboortedatum = date("Y-m-d", strtotime($_POST['geboortedatum']));
        $soort_lid = $_POST['soort_lid'];
        $familie = $_POST['familie'];

        $stmt->execute();

        // Pas de bijbehorende data in de contributietabel aan
        // Bereken eerst leeftijd obv geboortedatum
        $leeftijd = Member::calcAge($geboortedatum);

        // Bepaal (nieuwe) korting
        $stmt = $pdo->query("SELECT korting FROM soort_lid WHERE id=$soort_lid");
        $korting = $stmt->fetch();
        $korting = $korting['korting'];


        // Haal alle boekjaren met het basisbedrag op
        $fiscalYears = array();
        $stmt = $pdo->query("SELECT id, basisbedrag FROM boekjaar");

        if($stmt) {
            while($row = $stmt->fetch()) {
                $idBoekjaar = htmlspecialchars($row['id']);
                $basisbedrag = htmlspecialchars($row['basisbedrag']);

                $fiscalYears[$idBoekjaar] = $basisbedrag;
            }
        }

        // Pas alle records die horen bij het familielid aan met de nieuwe data
        $stmt = $pdo->prepare("UPDATE contributie SET leeftijd=?, bedrag=? WHERE familielid=? AND boekjaar=?");
        foreach ($fiscalYears as $idBoekjaar => $basisbedrag) {
            $stmt->bindParam(1, $leeftijd, PDO::PARAM_INT);
            $stmt->bindParam(2, $bedrag, PDO::PARAM_INT);
            $stmt->bindParam(3, $id, PDO::PARAM_INT);
            $stmt->bindParam(4, $idBoekjaar, PDO::PARAM_INT);

            // Bereken contributie
            $bedrag = $basisbedrag * (1 - $korting);

            $stmt->execute();
        }
    }

    public function deleteDataMember() {
        include 'login.php';

        // Sla uniek id op dat is meegegeven op de link
        $id = $_GET['id'];

        // Verwijder record die overeenkomt met meegegeven id
        $stmt = $pdo->prepare("DELETE FROM familielid WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        // Keer terug naar hoofdpagina, wanneer artikel is verwijderd
        header('location:members.php');
    }
}
?>