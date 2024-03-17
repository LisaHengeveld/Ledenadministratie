<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Voeg een nieuw soort lid toe</h2>
        <form action="membership.php" method="post">
            <div>
                <label>Omschrijving:</label>
                <input type="text" name="omschrijving" maxlength="100" autocomplete="off" required autofocus>
            </div>
            <div class="suffix">
                <label>Korting:</label>
                <input type="number" name="korting" min="0" max="100" autocomplete="off" required>
                <span class="percent">%</span>
            </div>
            <button class="btn-submit" type="submit" name="submit" value="create">Toevoegen</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>