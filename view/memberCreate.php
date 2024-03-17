<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Voeg een nieuw lid toe</h2>
        <form action="members.php" method="post">
            <div>
                <label>Voornaam:</label>
                <input type="text" name="naam" maxlength="50" autocomplete="off" required autofocus>
            </div>
            <div>
                <label>Achternaam:</label>
                <select name="familie" required>
                    <option value='' selected disabled hidden>Maak een keuze...</option> 
                    <?php
                        // Loop door alle families en maak een keuzeoptie aan (met id als value)
                        foreach ($familyList as $id => $family) {
                            echo "<option value='$id'>$family</option>";
                        }
                    ?>
                </select>
            </div>
            <div>
                <label>Geboortedatum:</label>
                <input type="date" name="geboortedatum" required>
            </div>
            <div>
                <label>Soort lid:</label>
                <select name="soort_lid" required>
                    <option value='' selected disabled hidden>Maak een keuze...</option>
                    <?php
                        // Loop door alle soort leden en maak een keuzeoptie aan (met id als value)
                        foreach ($membershipList as $id => $membership) {
                            echo "<option value='$id'>$membership</option>";
                        }
                    ?>
                </select>
            </div>
            <button class="btn-submit" type="submit" name="submit" value="create">Toevoegen</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>