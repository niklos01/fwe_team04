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

    public function authenticate($authHeader = null)
    {

        // Check if Authorization header exists and starts with "Bearer "
        if (empty($authHeader) || ! str_starts_with($authHeader, 'Bearer ')) {
            return $this->response->setStatusCode(401)->setJSON(["error" => 'Sie sind nicht autorisiert.']);
        }

        // Extract the token
        $token = trim(substr($authHeader, 7));

        // Validate the token
        if ($token === "Team#04") {
            return true;
        } else {
            return $this->response->setStatusCode(403)->setJSON(["error" => 'Ungültiger Bearer-Token.']);
        }
    }

    public function getWithAuth()
    {

        $authHeader = $this->request->getHeaderLine('Authorization');
        $authResult = $this->authenticate($authHeader);

        if ($authResult instanceof \CodeIgniter\HTTP\Response) {
            return $authResult;
        }

        // Authentication successful, proceed with getting data
        $model = new PersonModel();

        $personen = $model->getPersonen();
        return $this->respond($personen);

    }

    public function postWithAuth()
    {

        $authHeader = $this->request->getHeaderLine('Authorization');
        $authResult = $this->authenticate($authHeader);

        if ($authResult instanceof \CodeIgniter\HTTP\Response) {
            return $authResult;
        }

        // For form-data or x-www-form-urlencoded requests

        // If still empty, return error
        if (empty($_POST)) {
            return $this->response->setStatusCode(400)->setJSON([
                "error" => "Keine Daten im Request gefunden.",
            ]);
        }

        // Create new person model
        $model = new PersonModel();

        // Prepare data for insertion
        $data = [
            'vorname'  => $_POST["vorname"],
            "nachname" => $_POST["nachname"],
            'plz'      => $_POST["plz"],
            'ort'      => $_POST["ort"],
            'strasse'  => $_POST["strasse"],
            'username' => $_POST["username"],
        ];

        return $data;

        // Insert the data using CodeIgniter's query builder
        $builder = $this->db->table('personen');
        $builder->insert($data);
        $id = $this->db->insertID();

        if ($id) {
            // Return success with the created resource
            return $this->response->setStatusCode(201)->setJSON([
                "message" => "Person erfolgreich erstellt",
                "id"      => $id,
                "person"  => $data,
            ]);
        } else {
            // Return error if insertion failed
            return $this->response->setStatusCode(500)->setJSON([
                "error" => "Fehler beim Erstellen der Person",
            ]);
        }
    }
}
