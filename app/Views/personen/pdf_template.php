<?php if (isset($person) && is_array($person)): ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Personenprofil – <?= esc($person['vorname']) ?> <?= esc($person['name']) ?></title>
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
                font-size: 12pt;
                color: #000;
                margin: 50px;
            }

            h1 {
                font-size: 20pt;
                margin-bottom: 0;
            }

            h2 {
                font-size: 14pt;
                margin-top: 30px;
                border-bottom: 1px solid #000;
                padding-bottom: 5px;
            }

            .label {
                display: inline-block;
                width: 120px;
                font-weight: bold;
            }

            .row {
                margin-bottom: 10px;
            }

            .spacer {
                height: 20px;
            }

        </style>
    </head>
    <body>

    <h1>Personenprofil</h1>
    <p><em>Erstellt am <?= date('d.m.Y') ?></em></p>

    <h2>Allgemeine Informationen</h2>
    <div class="row"><span class="label">ID:</span> <?= esc($person['id']) ?></div>
    <div class="row"><span class="label">Vorname:</span> <?= esc($person['vorname']) ?></div>
    <div class="row"><span class="label">Nachname:</span> <?= esc($person['name']) ?></div>
    <div class="row"><span class="label">Benutzername:</span> <?= esc($person['username']) ?></div>

    <h2>Adresse</h2>
    <div class="row"><span class="label">Straße:</span> <?= esc($person['strasse']) ?></div>
    <div class="row"><span class="label">PLZ:</span> <?= esc($person['plz']) ?></div>
    <div class="row"><span class="label">Ort:</span> <?= esc($person['ort']) ?></div>
    <div class="row">
        <span class="label">Google Maps:</span>
        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($person['strasse'] . ', ' . $person['plz'] . ' ' . $person['ort']) ?>" target="_blank">
            Adresse in Google Maps öffnen
        </a>
    </div>
    </body>
    </html>
<?php else: ?>
    <p><strong>Fehler:</strong> Die Person konnte nicht gefunden werden.</p>
<?php endif; ?>
