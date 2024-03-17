<!-- Content -->
<main>
    <article>
        <h2>Overzicht van leden</h2>
        <p>
            Hieronder vindt u een overzicht van alle (gezins)leden.<br>
            Voor het toevoegen van een nieuw lid, moet eerst de familie bekend zijn.
            Is dat nog niet het geval, voeg dan een nieuwe familie toe op de homepagina.
        </p>
        <table>
            <thead>
                <tr>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Leeftijd</th>
                    <th><a class="btn-create" href="members.php?action=create"><i class="fa-solid fa-circle-plus"></i> Toevoegen</a></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loop door alle gezinsleden en genereer tabelrij met data
                foreach ($memberList as $memberItem) {
                    // Geef id mee op de link voor bekijken/aanpassen/verwijderen om terug te kunnen koppelen
                    // Geef daarnaast ook de actie van de CRUD-knop mee.
                    echo '<tr>
                    <td>'.$memberItem->naam.'</td>
                    <td>'.$memberItem->familie.'</td>
                    <td>'.$memberItem->leeftijd.'</td>
                    <td>
                        <a class="crud-icon" href="members.php?action=read&id='.$memberItem->id.'" tooltip="Bekijk"><i class="fa-solid fa-eye"></i></a>
                        <a class="crud-icon" href="members.php?action=update&id='.$memberItem->id.'" tooltip="Bewerk"><i class="fa-solid fa-pen"></i></a>
                        <a class="crud-icon" href="members.php?action=delete&id='.$memberItem->id.'" tooltip="Verwijder"><i class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>';
                }
            ?>
            </tbody>
        </table>
    </article>
</main>