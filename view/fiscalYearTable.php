<!-- Content -->
<main>
    <article>
        <h2>Overzicht van boekjaren</h2>
        <table>
            <thead>
                <tr>
                    <th>Jaar</th>
                    <th>Basisbedrag</th>
                    <th><a class="btn-create" href="fiscal-year.php?action=create"><i class="fa-solid fa-circle-plus"></i> Toevoegen</a></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loop door alle boekjaren en genereer tabelrij met data
                foreach ($fiscalYearList as $fiscalYearItem) {
                    // Geef id mee op de link voor bekijken/aanpassen/verwijderen om terug te kunnen koppelen
                    // Geef daarnaast ook de actie van de CRUD-knop mee.
                    echo '<tr>
                    <td>'.$fiscalYearItem->jaar.'</td>
                    <td>&euro; '.$fiscalYearItem->basisbedrag.'</td>
                    <td>
                        <a class="crud-icon" href="fiscal-year.php?action=read&id='.$fiscalYearItem->id.'" tooltip="Bekijk"><i class="fa-solid fa-eye"></i></a>
                        <a class="crud-icon" href="fiscal-year.php?action=update&id='.$fiscalYearItem->id.'" tooltip="Bewerk"><i class="fa-solid fa-pen"></i></a>
                        <a class="crud-icon" href="fiscal-year.php?action=delete&id='.$fiscalYearItem->id.'" tooltip="Verwijder"><i class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>';
                }
            ?>
            </tbody>
        </table>
    </article>
</main>