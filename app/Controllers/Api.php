<?php
namespace App\Controllers;

use App\Models\PersonModel;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{

    protected $format = 'json';

    public function index()
    {
        $model    = new PersonModel();
        $personen = $model->getPersonen();
        return $this->respond($personen);
    }

    public function reqWithAuth()
    {
        // Get the Authorization header
        $authHeader = $this->request->getHeaderLine('Authorization');

        // Check if Authorization header exists and starts with "Bearer "
        if (empty($authHeader) || ! str_starts_with($authHeader, 'Bearer ')) {
            return $this->response->setStatusCode(401)->setJSON(["error" => 'Sie sind nicht autorisiert.']);
        }

        // Extract the token
        $token = trim(substr($authHeader, 7));

        // Validate the token (replace this with your actual token validation logic)
        if ($token !== "Team#04") {
            return $this->response->setStatusCode(403)->setJSON(["error" => 'Ungültiger Bearer-Token.']);

        }

        // Alles ok , dann return data
        $model = new PersonModel();

        $personen = $model->getPersonen();
        return $this->respond($personen);

    }

}
