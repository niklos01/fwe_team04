<div class="container mt-5">
    <h2>Personenliste</h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>       <!-- id -->
            <th scope="col">First</th>   <!-- vorname -->
            <th scope="col">Last</th>    <!-- name -->
            <th scope="col">Handle</th>  <!-- username -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($personen as $person): ?>
            <tr>
                <th scope="row"><?= esc($person['id']) ?></th>
                <td><?= esc($person['vorname']) ?></td>
                <td><?= esc($person['name']) ?></td>
                <td>@<?= esc($person['username']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
