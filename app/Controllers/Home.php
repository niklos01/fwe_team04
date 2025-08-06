<?php

namespace App\Controllers;

use App\Models\PersonModel;

class Home extends BaseController
{
    public function index(): void
    {
        echo view('templates/header');
        echo view('tableAjax');
        echo view('templates/footer');
    }

    public function getPersonenAjax()
    {
        $model = new PersonModel();
        $personen = $model->getPersonen();

        return json_encode($personen);
    }
}
