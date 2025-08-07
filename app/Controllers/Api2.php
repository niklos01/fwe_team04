<?php
namespace App\Controllers;

use AIAccess\Provider;
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

    public function ai_response()
    {
        // Get API key from the environment
        $apiKey = getenv('gemini_key');
        if (! $apiKey) {
            return $this->failServerError('API key not configured');
        }
        // Gemini Client
        $client = new Provider\Gemini\Client($apiKey);
        $model  = 'gemini-2.5-flash';

        $chat     = $client->createChat($model);
        $response = $chat->sendMessage('Write a short haiku about PHP.');

        return $this->respond($response->getText());

    }

}
