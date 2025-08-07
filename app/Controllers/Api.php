<?php
namespace App\Controllers;

use AIAccess\Provider\Gemini\Client as GeminiClient;
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

    public function crud()
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

        // Get input data from form-data or json
        $input    = $_POST ?? $this->request->getJSON(true);
        $todo     = $input['todo'] ?? null;
        $data     = $input['data'] ?? [];
        $personen = $model->crud($todo, $data);
        return $this->respond($personen);

    }

    public function weather()
    {
        $apiKey = getenv('OPEN_WEATHER_MAP_KEY');

        if (!$apiKey) {
            return $this->response->setJSON([
                'error' => 'API key missing'
            ])->setStatusCode(500);
        }

        // Hole Stadt aus GET-Parameter, Standard: Trier,de
        $city = $this->request->getGet('city') ?? 'Trier,de';

        // URL für OpenWeatherMap-API
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=de";

        $client = \Config\Services::curlrequest();
        $response = $client->get($url);

        if ($response->getStatusCode() !== 200) {
            return $this->response->setJSON([
                'error' => 'Fehler beim Abrufen der Wetterdaten'
            ])->setStatusCode(500);
        }

        $data = json_decode($response->getBody(), true);

        $result = [
            'stadt'        => $data['name'],
            'beschreibung' => $data['weather'][0]['description'],
            'icon'         => $data['weather'][0]['icon'],
            'temperatur'   => $data['main']['temp'],
            'luftfeuchte'  => $data['main']['humidity'],
            'wind'         => $data['wind']['speed'],
        ];

        return $this->response->setJSON($result);
    }

    public function chat()
    {
        $message = $this->request->getJSON()->message ?? '';

        if (empty($message)) {
            return $this->failValidationError('Message is required');
        }

        $apiKey = getenv('GEMINI_API_KEY');
        $this->gemini = new GeminiClient($apiKey);

        try {
            // Erstelle Chat (nicht streamend)
            $chat = $this->gemini->createChat('gemini-2.5-flash');

            // Sende Nachricht
            $response = $chat->sendMessage($message);

            // Hole reinen Text (AI Access extrahiert das automatisch)
            $text = $response->getText();

            return $this->respond([
                'message' => $text
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }


}
