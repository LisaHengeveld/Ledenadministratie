<!-- Content -->
<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bekijk lid</h2>
        <form action="members.php" method="post">        
            <p>
                <strong>Voornaam:</strong>
                <?php echo $member->naam; ?>
            </p>
            <p>
                <strong>Achternaam:</strong>
                <?php echo $member->familie; ?>
            </p>
            <p>
                <strong>Geboortedatum:</strong>
                <?php echo $member->geboortedatum; ?>
            </p>
            <button class="btn-cancel" type="submit" name="cancel">Terug</button>
        </form> 
    </div>
</article>