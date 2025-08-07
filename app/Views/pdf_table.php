<style>
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    th, td { border: 1px solid #000; padding: 3px; text-align: left; }
    th { background-color: #f2f2f2; font-weight: bold; }
</style>

<h2>Personenliste</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Vorname</th>
            <th>Name</th>
            <th>Ort</th>
            <th>Username</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($personen as $person): ?>
        <tr>
            <td><?= htmlspecialchars($person['id']) ?></td>
            <td><?= htmlspecialchars($person['vorname']) ?></td>
            <td><?= htmlspecialchars($person['name']) ?></td>
            <td><?= htmlspecialchars($person['ort'] ?? '') ?></td>
            <td><?= htmlspecialchars($person['username']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>