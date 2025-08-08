<?php

namespace App\Controllers;

use App\Models\PersonModel;
use CodeIgniter\API\ResponseTrait;

class PersonenApi extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new PersonModel();
    }

    public function index($id = null)
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (empty($authHeader) || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->response->setStatusCode(401)->setJSON(["error" => 'Sie sind nicht autorisiert.']);
        }

        $token = trim(substr($authHeader, 7));

        if ($token !== "Team#04") {
            return $this->response->setStatusCode(403)->setJSON(["error" => 'Ungültiger Bearer-Token.']);
        }

        $method = $this->request->getMethod();
        $data = $this->request->getJSON(true);

        switch ($method) {
            case 'GET':
                return $this->response->setJSON($this->model->crud('read', ['id' => $id]));

            case 'POST':
                return $this->response->setJSON($this->model->crud('create', $data));

            case 'PUT':
                if ($id) {
                    $data['id'] = $id;
                }
                return $this->response->setJSON($this->model->crud('update', $data));

            case 'DELETE':
                return $this->response->setJSON($this->model->crud('delete', ['id' => $id]));

            default:
                return $this->fail("Methode " . $method . " nicht erlaubt", 405);

        }
    }
}
