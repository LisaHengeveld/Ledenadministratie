<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bewerk gegevens</h2>
        <form action="members.php" method="post">
            <div>
                <label>Voornaam:</label>
                <input type="text" name="naam" maxlength="50" value="<?php echo $member->naam; ?>" autocomplete="off" required>
            </div>
            <div>
                <label>Achternaam:</label>
                <select name="familie" required>
                    <?php
                        // Loop door alle families en maak een keuzeoptie aan (met id als value)
                        foreach ($familyList as $id => $family) {
                            // Indien de familie overeenkomt met die van het lid waarvan nu de gegevens worden bewerkt, deze instellen als voorgeselecteerd
                            echo "<option value='$id' " . ($member->familie == $family ? 'selected>' : '>') . "$family</option>";
                        }
                    ?>
                </select>
            </div>
            <div>
                <label>Geboortedatum:</label>
                <input type="date" name="geboortedatum" value="<?php echo date("Y-m-d", strtotime($member->geboortedatum)); ?>" required>
            </div>
            <div>
                <label>Soort lid:</label>
                <select name="soort_lid" required>
                    <?php
                        // Loop door alle soort leden en maak een keuzeoptie aan (met id als value)
                        foreach ($membershipList as $id => $membership) {
                            // Indien het soort lid overeenkomt met die van het lid waarvan nu de gegevens worden bewerkt, deze instellen als voorgeselecteerd
                            echo "<option value='$id' " . ($member->soort_lid == $id ? 'selected>' : '>') . "$membership</option>";
                        }
                    ?>
                </select>
            </div>
            
            <!-- Verborgen veld om unieke id mee te sturen, zodat de betreffende data door het model gevonden kan worden -->
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

            <button class="btn-submit" type="submit" name="submit" value="update">Bijwerken</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>