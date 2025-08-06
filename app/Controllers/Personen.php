<?php

namespace App\Controllers;

use App\Models\PersonModel;

class Home extends BaseController
{
    public function index(): void
    {
        $this->renderLayout([
            'tableAjax'
        ]);
    }

    public function getPersonenAjax()
    {
        $model = new PersonModel();
        $personen = $model->getPersonen();

        return json_encode($personen);
    }
}
