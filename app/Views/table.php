<div class="container mt-5">
    <h2>Personenliste</h2>
    <table
        data-toggle="table"
        data-search="true"
        data-pagination="true"
        data-show-columns="true"
        data-show-refresh="true"
        data-toolbar="#toolbar"
        class="table"
    >

    <thead>
        <tr>
            <th>#</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Straße</th>
            <th>PLZ</th>
            <th>Ort</th>
            <th>Username</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($personen) && is_array($personen)): ?>
            <?php foreach ($personen as $person): ?>
                <tr>
                    <td><?= esc($person['id']) ?></td>
                    <td><?= esc($person['vorname']) ?></td>
                    <td><?= esc($person['name']) ?></td>
                    <td><?= esc($person['strasse']) ?></td>
                    <td><?= esc($person['plz']) ?></td>
                    <td><?= esc($person['ort']) ?></td>
                    <td>@<?= esc($person['username']) ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr><td colspan="7">Keine Daten gefunden.</td></tr>
        <?php endif ?>
        </tbody>
    </table>
</div>
