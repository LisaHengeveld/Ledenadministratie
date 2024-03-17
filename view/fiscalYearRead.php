<!-- Content -->
<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bekijk boekjaar</h2>
        <form action="fiscal-year.php" method="post">        
            <p>
                <strong>Jaar:</strong>
                <?php echo $fiscalYear->jaar; ?>
            </p>
            <p>
                <strong>Basisbedrag:</strong>
                <?php echo "&euro; $fiscalYear->basisbedrag"; ?>
            </p>
            <button class="btn-cancel" type="submit" name="cancel">Terug</button>
        </form> 
    </div>
</article>