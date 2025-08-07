<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use AIAccess\Provider\Gemini\Client as GeminiClient;

class ChatController extends ResourceController
{
    protected $format = 'json';
    protected $gemini;

    public function __construct()
    {
        $apiKey = getenv('GEMINI_API_KEY');
        $this->gemini = new GeminiClient($apiKey); // Initialisiere den Gemini-Client
    }

    public function chat()
    {
        $message = $this->request->getJSON()->message ?? '';

        if (empty($message)) {
            return $this->failValidationError('Message is required');
        }

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
