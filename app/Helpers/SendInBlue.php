<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class SendInBlue {
    private $credentials;
    private $apiInstance;

    function __construct()
    {
        $this->credentials = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', env('SEND_IN_BLUE_API_KEY'));
        $this->apiInstance = new \SendinBlue\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $this->credentials
        );
    }

    // Subscribe a user to one or more mailing lists.
    public function subscribe(Array $subscriberDetails, Array $mailingList) : bool
    {
        // create contact model
        $contact = new \SendinBlue\Client\Model\CreateContact([
            'email' => $subscriberDetails['email'],
            'updateEnabled' => true,
            'listIds' => $mailingList
        ]);
        // attempt API request
        try {
            $this->apiInstance->createContact($contact);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    // Send Email to Admin Account
    public function sendReportEmail($user, $content) {
        $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(new \GuzzleHttp\Client(),$this->credentials);
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => 'An Error Has Been Reported From Affirm',
            'sender' => ['name' => $user->name, 'email' => $user->email],
            'to' => [[ 'name' => 'admin', 'email' => 'adam@adamtothsoftware.ca']],
            'textContent' => $content,
        ]);

        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);

        return $result;
    }
}
