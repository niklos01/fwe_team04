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
        $model = new PersonModel();
        $personen = $model->getPersonen();
        return $this->respond($personen);
    }

    public function crud($id = null)
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (empty($authHeader) || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->response->setStatusCode(401)->setJSON(["error" => 'Sie sind nicht autorisiert.']);
        }

        $token = trim(substr($authHeader, 7));

        if ($token !== "Team#04") {
            return $this->response->setStatusCode(403)->setJSON(["error" => 'Ungültiger Bearer-Token.']);
        }

        $this->model = new PersonModel();
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

    public function weather()
    {
        $apiKey = getenv('OPEN_WEATHER_MAP_KEY');

        if (!$apiKey) {
            return $this->response->setJSON([
                'error' => 'API key missing'
            ])->setStatusCode(500);
        }

        $city = $this->request->getGet('city') ?? 'Trier,de';
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

    private function getWebsiteContext()
    {
        $context = [];

        try {
            $weatherData = json_decode($this->weather()->getBody(), true);
            $context['weather'] = [
                'temperatur' => $weatherData['temperatur'] ?? null,
                'beschreibung' => $weatherData['beschreibung'] ?? null,
                'stadt' => $weatherData['stadt'] ?? null
            ];
        } catch (\Exception $e) {
            $context['weather'] = null;
        }

        try {
            $personModel = new PersonModel();
            $context['persons'] = [
                'total_count' => $personModel->getTotalPersonenCount(),
                'fist_10' => $personModel->getPersonenChunk(10, 0)
            ];
        } catch (\Exception $e) {
            $context['persons'] = null;
        }

        try {
            $umsatzModel = new \App\Models\UmsatzModel();
            $currentMonth = $umsatzModel->getCurrentMonthComparison();
            $last12Month = $umsatzModel->getLast12Months();
            $context['revenue'] = [
                'current_month' => [
                    'current' => $currentMonth['current_revenue'],
                    'previous_year' => $currentMonth['previous_year_revenue'],
                    'month' => $currentMonth['month'],
                    'year' => $currentMonth['year']
                ],
                'last_12_month'=> $last12Month,
                'waehrung' => 'Alle Angaben sind in Euro'
            ];
        } catch (\Exception $e) {
            $context['revenue'] = null;
        }

        $context['location'] = [
            'name' => 'Universität Trier',
            'coordinates' => [
                'lat' => 49.745148290607496,
                'lng' => 6.6878155391441085
            ]
        ];

        return $context;
    }

    public function chat()
    {
        $message = $this->request->getJSON()->message ?? '';

        if (empty($message)) {
            return $this->failValidationError('Message is required');
        }

        $context = $this->getWebsiteContext();

        $apiKey = getenv('GEMINI_API_KEY');
        $this->gemini = new GeminiClient($apiKey);

        try {
            $chat = $this->gemini->createChat('gemini-2.5-flash');

            $contextMessage = "Kontext:\n" . json_encode($context, JSON_PRETTY_PRINT) . "\n\nBenutzerfrage: " . $message;

            $response = $chat->sendMessage($contextMessage);

            $text = $response->getText();

            return $this->respond([
                'message' => $text
            ]);

        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
