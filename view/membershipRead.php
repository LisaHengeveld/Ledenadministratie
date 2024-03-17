<!-- Content -->
<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bekijk soort lid</h2>
        <form action="membership.php" method="post">        
            <p>
                <strong>Omschrijving:</strong>
                <?php echo $membership->omschrijving; ?>
            </p>
            <p>
                <strong>Korting:</strong>
                <?php echo $membership->korting; ?>%
            </p>
            <button class="btn-cancel" type="submit" name="cancel">Terug</button>
        </form> 
    </div>
</article>