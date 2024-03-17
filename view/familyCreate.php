<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Voeg een nieuwe familie toe</h2>
        <form action="home.php" method="post">
            <div>
                <label>Achternaam:</label>
                <input type="text" name="naam" maxlength="50" autocomplete="off" required autofocus>
            </div>
            <div>
                <label>Adres:</label>
                <input type="text" name="adres" maxlength="100" autocomplete="off" required>
            </div>
            <button class="btn-submit" type="submit" name="submit" value="create">Toevoegen</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>