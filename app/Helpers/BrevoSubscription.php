<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class BrevoSubscription
{
    public $brevo;

    public function __construct()
    {
        $API_KEY = config('app.brevo_api_key');

        if(! $API_KEY) {
          Log::error('Brevo API Key is missing');
          throw new Exception('Brevo API Key is missing');
        }

        $config = \Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $API_KEY);

        $this->brevo = new \Brevo\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $config
        );
    }

    public function subscribe($email, $name, $subIds)
    {
        $createContact = new \Brevo\Client\Model\CreateContact([
          'email' => $email,
          'updateEnabled' => true,
          'attributes' => ['FIRSTNAME' => $name],
          'listIds' => $subIds
        ]); 
        
        try {
            $result = $this->brevo->createContact($createContact);
            return $result;
        } catch (Exception $e) {
           Log::error('Exception when calling ContactsApi->createContact: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public function updateSubIds($email, $unlinkIds, $listIds)
    {
        $updateContact = new \Brevo\Client\Model\UpdateContact([
            'listIds' => $listIds,
            'unlinkListIds' => $unlinkIds
        ]); 
        
        try {
            $result = $this->brevo->updateContact($email, $updateContact);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
           Log::error('Exception when calling ContactsApi->updateContact: ' . $e->getMessage() . PHP_EOL);
        }
    }


}