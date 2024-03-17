<main>
    <article>
        <h2>Overzicht van contributies van families</h2>
        <p>
            Hieronder vindt u een overzicht van alle families met hun totale contributie. Dit totaal omvat de contributies
            van de individuele gezinsleden voor alle boekjaren.<br>
            Klik voor een gedetaileerd overzicht per familie op 'bekijk'.
        </p>
        <table>
            <thead>
                <tr>
                    <th>Familie</th>
                    <th>Contributie (totaal)</th>
                    <th><a class="btn-create" href="home.php?action=create"><i class="fa-solid fa-circle-plus"></i> Toevoegen</a></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loop door alle families en genereer tabelrij met data
                foreach ($familyList as $familyItem) {
                    // Geef id mee op de link voor bekijken/aanpassen/verwijderen om terug te kunnen koppelen.
                    // Geef daarnaast ook de actie van de CRUD-knop mee.
                    echo '<tr>
                    <td>'.$familyItem->naam.'</td>
                    <td>&euro; '.$familyItem->bedrag.'</td>
                    <td>
                        <a class="crud-icon" href="home.php?action=read&id='.$familyItem->id.'" tooltip="Bekijk"><i class="fa-solid fa-eye"></i></a>
                        <a class="crud-icon" href="home.php?action=update&id='.$familyItem->id.'" tooltip="Bewerk"><i class="fa-solid fa-pen"></i></a>
                        <a class="crud-icon" href="home.php?action=delete&id='.$familyItem->id.'" tooltip="Verwijder"><i class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>';
                }
            ?>
            </tbody>
        </table>
    </article>
</main>