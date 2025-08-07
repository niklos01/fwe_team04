<?php
namespace App\Controllers;

use App\Models\PersonModel;
use CodeIgniter\RESTful\ResourceController;

class Api2 extends ResourceController
{

    protected $format = 'json';

    public function index()
    {
        $model    = new PersonModel();
        $personen = $model->getPersonen();
        return $this->respond($personen);
    }

}
