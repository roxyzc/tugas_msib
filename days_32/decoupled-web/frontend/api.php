<?php

class API
{
    private $baseUrl = 'http://localhost:8000/api';
    private $token;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    private function request($method, $endpoint, $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [];

        if ($this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        if ($data) {
            $headers[] = 'Content-Type: application/json';
        }

        $options = [
            'http' => [
                'header' => $headers,
                'method' => strtoupper($method),
                'content' => $data ? json_encode($data) : null,
                'ignore_errors' => true,
            ],
        ];

        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context), true);
    }

    public function register($data)
    {
        return $this->request('POST', '/register', $data);
    }

    public function login($data)
    {
        return $this->request('POST', '/login', $data);
    }

    public function createSurvey($data)
    {
        return $this->request('POST', '/surveys', $data);
    }

    public function getSurveys()
    {
        return $this->request('GET', '/surveys');
    }

    public function getSurveyById($id)
    {
        return $this->request('GET', '/surveys/' . $id);
    }

    public function deleteSurvey($id)
    {
        return $this->request('DELETE', '/surveys/' . $id);
    }
}
