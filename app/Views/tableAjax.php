<div class="container mt-5">
    <h2>Personenliste (AJAX)</h2>
<?= base_url("home/getPersonenAjax") ?>

    <table
        id="personenTabelle"
        class="table"
        data-toggle="table"
        data-url="<?= base_url('home/getPersonenAjax') ?>"
        data-search="true"
        data-pagination="true"
        data-show-refresh="true"
        data-show-columns="true"
        data-side-pagination="client"
    >
    <thead>
    <tr>
        <th data-field="id" data-sortable="true">#</th>
        <th data-field="vorname" data-sortable="true">Vorname</th>
        <th data-field="name" data-sortable="true">Nachname</th>
        <th data-field="strasse">Straße</th>
        <th data-field="plz">PLZ</th>
        <th data-field="ort">Ort</th>
        <th data-field="username" data-sortable="true">Username</th>
    </tr>
    </thead>
    </table>
</div>
<?php
