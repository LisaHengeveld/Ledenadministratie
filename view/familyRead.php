<article class="bg-modal create">
    <div class="modal-content create">
        <h2>Bekijk familie</h2>
        <form action="home.php" method="post">        
            <p>
                <strong>Achternaam:</strong>
                <?php echo $family->naam; ?>
            </p>
            <p>
                <strong>Adres:</strong>
                <?php echo $family->adres; ?>
            </p>
            <p>
                <strong>Gezinsleden met contributie p.p.:</strong><br>
                <?php
                    // Loop indien er gezinsleden zijn gevonden door alle leden en toon naam en hun totale contributie.
                    if ($members) {
                        foreach ($members as $naam => $bedrag) {
                            echo "$naam - &euro; $bedrag<br>";
                        }
                    } else {
                        echo "Nog geen gezinsleden toegevoegd.";
                    }
                    
                ?>  
            </p>
            <button class="btn-cancel" type="submit" name="cancel">Terug</button>
        </form> 
    </div>
</article>