<!-- Content -->
<main>
    <article>
        <h2>Overzicht van contributies (per lid)</h2>
        <table id="contributietabel">
            <thead>
                <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Soort lid</th>
                    <th>Boekjaar</th>
                    <th>Bedrag</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($contributionsList as $contributionItem) {
                    echo '<tr>
                    <td>'.$contributionItem->voornaam.'</td>
                    <td>'.$contributionItem->achternaam.'</td>
                    <td>'.$contributionItem->soort_lid.'</td>
                    <td>'.$contributionItem->boekjaar.'</td>
                    <td>&euro; '.$contributionItem->contributie.'</td>
                    </tr>';
                }
            ?>
            </tbody>
        </table>
    </article>
</main>