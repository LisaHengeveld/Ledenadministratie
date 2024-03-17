<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bewerk gegevens</h2>
        <form action="home.php" method="post">
            <div>
                <label>Achternaam:</label>
                <input type="text" name="naam" maxlength="50" value="<?php echo $family->naam; ?>" autocomplete="off" required>
            </div>
            <div>
                <label>Adres:</label>
                <input type="text" name="adres" maxlength="100" value="<?php echo $family->adres; ?>" autocomplete="off" required>
            </div>
            
            <!-- Verborgen veld om unieke id mee te sturen, zodat de betreffende data door het model gevonden kan worden -->
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

            <button class="btn-submit" type="submit" name="submit" value="update">Bijwerken</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>