<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bewerk gegevens</h2>
        <form action="membership.php" method="post">
            <div>
                <label>Omschrijving:</label>
                <input type="text" name="omschrijving" maxlength="100" value="<?php echo $membership->omschrijving; ?>" autocomplete="off" required>
            </div>
            <div class="suffix">
                <label>Korting:</label>
                <input type="text" name="korting" min="0" max="100" value="<?php echo $membership->korting; ?>" autocomplete="off" required>
                <span class="percent">&percnt;</span>
            </div>
            
            <!-- Verborgen veld om unieke id mee te sturen, zodat de betreffende data door het model gevonden kan worden -->
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

            <button class="btn-submit" type="submit" name="submit" value="update">Bijwerken</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>