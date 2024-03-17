<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Voeg een nieuwe boekjaar toe</h2>
        <form action="fiscal-year.php" method="post">
            <div>
                <label>Jaar:</label>
                <input type="number" name="jaar" min="2023" max="2123" step="1" autocomplete="off" required autofocus>
            </div>
            <div class="prefix">
                <label>Basisbedrag:</label>
                <input type="number" name="basisbedrag" min="0" autocomplete="off" required>
                <span class="euro">&euro;</span>
            </div>
            <button class="btn-submit" type="submit" name="submit" value="create">Toevoegen</button>
            <button class="btn-cancel" type="submit" name="cancel" formnovalidate>Annuleer</button>
        </form>
    </div>
</article>