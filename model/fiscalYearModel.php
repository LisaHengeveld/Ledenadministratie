<?php
    class fiscalYear {
        public $id;
        public $jaar;
        public $basisbedrag;
        
        public function __construct($id, $jaar, $basisbedrag) {
            $this->id = $id;
            $this->jaar = $jaar;
            $this->basisbedrag = $basisbedrag;
        }
    }

    class Model {
        public function getFiscalYearList() {
            include 'login.php'; // Maak verbinding met de database

            // Maak array voor de data
            $fiscalYears = array();

            // Haal alle data op uit de tabel boekjaar
            $stmt = $pdo->query("SELECT * FROM boekjaar ORDER BY jaar");

            if($stmt) {
                // Zolang er nog records in de data zijn, voeg deze toe aan de array
                while($row = $stmt->fetch()) {
                    $id = htmlspecialchars($row['id']);
                    $jaar = htmlspecialchars($row['jaar']);
                    $basisbedrag = round(htmlspecialchars($row['basisbedrag']));

                    $fiscalYears[] = new fiscalYear($id, $jaar, $basisbedrag);
                }
            }

            // Geef de array met alle data terug
            return $fiscalYears;
        }

        public function getFiscalYear() {
            include 'login.php'; // Maak verbinding met de database

            // Sla uniek id op dat is meegegeven op de link
            $id = $_GET['id'];

            // Haal data op dat hoort bij het id
            $stmt = $pdo->prepare("SELECT * FROM boekjaar WHERE id=?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            $jaar = htmlspecialchars($row['jaar']);
            $basisbedrag = round(htmlspecialchars($row['basisbedrag']));

            // Maak object aan met de gevonden data en geef deze terug
            $fiscalYear = new fiscalYear($id, $jaar, $basisbedrag);
            return $fiscalYear;
        }

        public function createDataFiscalYear() {
            include 'login.php'; // Maak verbinding met de database

            // Sla nieuwe data op
            $jaar = $_POST['jaar'];
            $basisbedrag = $_POST['basisbedrag'];

            // Check eerst of het boekjaar al in de dataset bestaat
            $stmt = $pdo->prepare('SELECT * FROM boekjaar WHERE jaar=?');
            $stmt->bindParam(1, $jaar, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();

            // Stop de functie en geef een melding aan de gebruiker wanneer het boekjaar al bestaat
            if ($row) {
                echo '<script>alert("Dit boekjaar bestaat al.")</script>';
                return;
            }

            // Voeg nieuwe data toe
            $stmt = $pdo->prepare("INSERT INTO boekjaar(jaar, basisbedrag) VALUES(?,?)");
            $stmt->bindParam(1, $jaar, PDO::PARAM_INT);
            $stmt->bindParam(2, $basisbedrag, PDO::PARAM_INT);

            $stmt->execute();
            $idJaar = $pdo->lastInsertId(); // Sla primary key op

            // Voeg nieuwe data toe aan contributietabel
            // Haal hiervoor eers alle leden op met de te ontvangen korting
            $members = array();
            $stmt = $pdo->query("SELECT familielid.id, familielid.geboortedatum, soort_lid.korting
                                 FROM familielid
                                 INNER JOIN soort_lid ON familielid.soort_lid=soort_lid.id");

            if($stmt) {
                while($row = $stmt->fetch()) {
                    $id = htmlspecialchars($row['id']);
                    $geboortedatum = htmlspecialchars($row['geboortedatum']);
                    $korting = htmlspecialchars($row['korting']);

                    // Bereken leeftijd
                    $geboortedatum = new DateTime($geboortedatum);
                    $huidigeDatum = new DateTime();
                    $verschil = $huidigeDatum->diff($geboortedatum);
                    $leeftijd = $verschil->y;

                    $members[] = array('id' => $id,
                                       'leeftijd' => $leeftijd,
                                       'korting' => $korting);
                }
            }

            // Voeg voor ieder lid een nieuwe record toe aan de contributietabel met de data behorend bij het nieuwe boekjaar
            $stmt = $pdo->prepare("INSERT INTO contributie(leeftijd, familielid, bedrag, boekjaar) VALUES(?,?,?,?)");
            foreach ($members as $member) {
                $stmt->bindParam(1, $member['leeftijd'], PDO::PARAM_INT);
                $stmt->bindParam(2, $member['id'], PDO::PARAM_INT);
                $stmt->bindParam(3, $bedrag, PDO::PARAM_INT);
                $stmt->bindParam(4, $idJaar, PDO::PARAM_INT);

                // Bereken contributie
                $bedrag = $basisbedrag * (1 - $member['korting']);

                $stmt->execute();
            }
        }

        public function updateDataFiscalYear() {
            include 'login.php'; // Maak verbinding met de database

            // Pas de data (die overeenkomt met het unieke id dat is meegegeven in het formulier) 
            // aan met de nieuwe data uit het formulier
            $stmt = $pdo->prepare("UPDATE boekjaar SET id=?, jaar=?, basisbedrag=? WHERE id=?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $jaar, PDO::PARAM_INT);
            $stmt->bindParam(3, $basisbedrag, PDO::PARAM_INT);
            $stmt->bindParam(4, $id, PDO::PARAM_INT);

            $id=$_POST['id'];
            $jaar=$_POST['jaar'];
            $basisbedrag=$_POST['basisbedrag'];

            $stmt->execute();

            // Pas alle records die horen bij het aangepaste boekjaar aan met de nieuwe contributie
            $stmt = $pdo->prepare("UPDATE contributie 
                                   INNER JOIN familielid ON contributie.familielid=familielid.id
                                   INNER JOIN soort_lid ON familielid.soort_lid=soort_lid.id
                                   SET contributie.bedrag=?*(1-soort_lid.korting)
                                   WHERE boekjaar=?");
            $stmt->bindParam(1, $basisbedrag, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function deleteDataFiscalYear() {
            include 'login.php';

            // Sla uniek id op dat is meegegeven op de link
            $id = $_GET['id'];

            // Verwijder record die overeenkomt met meegegeven id
            $stmt = $pdo->prepare("DELETE FROM boekjaar WHERE id=?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            // Keer terug naar hoofdpagina, wanneer boekjaar is verwijderd
            header('location:fiscal-year.php');
        }
    }
?>