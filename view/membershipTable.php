<!-- Content -->
<main>
    <article>
        <h2>Overzicht van soort leden</h2>
        <table>
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th>Te ontvangen korting</th>
                    <th><a class="btn-create" href="membership.php?action=create"><i class="fa-solid fa-circle-plus"></i> Toevoegen</a></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loop door alle soort leden en genereer tabelrij met data
                foreach ($membershipList as $membershipItem) {
                    // Geef id mee op de link voor bekijken/aanpassen/verwijderen om terug te kunnen koppelen
                    // Geef daarnaast ook de actie van de CRUD-knop mee.
                    echo '<tr>
                    <td>'.$membershipItem->omschrijving.'</td>
                    <td>'.$membershipItem->korting.'%</td>
                    <td>
                        <a class="crud-icon" href="membership.php?action=read&id='.$membershipItem->id.'" tooltip="Bekijk"><i class="fa-solid fa-eye"></i></a>
                        <a class="crud-icon" href="membership.php?action=update&id='.$membershipItem->id.'" tooltip="Bewerk"><i class="fa-solid fa-pen"></i></a>
                        <a class="crud-icon" href="membership.php?action=delete&id='.$membershipItem->id.'" tooltip="Verwijder"><i class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>';
                }
            ?>
            </tbody>
        </table>
    </article>
</main>