<div class="container mt-5">
    <h2>Personenliste</h2>
    <table class="table table-bordered table-striped">
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
