<?php

namespace App\Controllers;

use App\Models\PersonModel;

class Home extends BaseController
{
    public function index(): void
    {
        $model = new PersonModel();

        // Personen-Daten abrufen
        $personen = $model->getPersonen();

        // Views anzeigen
        echo view('templates/header');
        echo '<pre>';
        var_dump($personen);
        echo '</pre>';

        echo view('templates/footer');
    }
}
