<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use AIAccess\AIAccess;

class ChatController extends ResourceController
{
    protected $format = 'json';
    private $aiAccess;

    public function __construct()
    {
        parent::__construct();
        $this->aiAccess = new AIAccess(getenv('GEMINI_API_KEY'), 'gemini');
    }

    public function chat()
    {
        $message = $this->request->getJSON()->message ?? '';
        
        if (empty($message)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Message is required'
            ]);
        }

        // Set headers for streaming response
        $this->response->setHeader('Content-Type', 'text/event-stream');
        $this->response->setHeader('Cache-Control', 'no-cache');
        $this->response->setHeader('Connection', 'keep-alive');
        
        try {
            // Create a chat completion with streaming
            $stream = $this->aiAccess->completion([
                'messages' => [
                    ['role' => 'user', 'content' => $message]
                ],
                'stream' => true
            ]);
            
            // Stream the response chunks
            foreach ($stream as $response) {
                $chunk = $response->choices[0]->delta->content ?? '';
                if (!empty($chunk)) {
                    echo "data: " . json_encode(['chunk' => $chunk]) . "\n\n";
                    ob_flush();
                    flush();
                }
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }
}
