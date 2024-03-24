<?php
namespace App\Services;

use Google\Client;
use Google\Service\Forms;

class GoogleFormsService
{
    protected $client;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('vShelf');
        $client->setScopes([Forms::FORMS_RESPONSES_READONLY]);
        $client->setAuthConfig(json_decode(env('GOOGLE_CREDENTIALS_JSON'),true));

        $this->client = $client;
    }

    public function getFormResponses($formId)
    {
        $service = new Forms($this->client);
        $responses = $service->forms_responses->listFormsResponses($formId);
        return  $responses->getResponses();
    }
}
