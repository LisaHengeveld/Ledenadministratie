<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bewerk boekjaar</h2>
        <form action="fiscal-year.php" method="post">
            <div>
                <label>Jaar:</label>
                <input type="number" name="jaar" min="2023" max="2123" step="1" value="<?php echo $fiscalYear->jaar; ?>" autocomplete="off" required>
            </div>
            <div class="prefix">
                <label>Basisbedrag:</label>
                <input type="number" name="basisbedrag" min="0" value="<?php echo $fiscalYear->basisbedrag; ?>" autocomplete="off" required>
                <span class="euro">&euro;</span>
            </div>
            
            <!-- Verborgen veld om unieke id mee te sturen, zodat de betreffende data door het model gevonden kan worden -->
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

            <button class="btn-submit" type="submit" name="submit" value="update">Bijwerken</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>