<?php


namespace Shibby\Mesnot;

use App\Model\User;
use GuzzleHttp\Client;
use Shibby\Mesnot\Jobs\SendRequest;

class MessageNotify
{
    const API_URL = 'http://mesnot.fusionistanbul.com/api/v1/';
    //const API_URL = 'http://127.0.0.1:8000/api/v1/';

    public function updateClient($user, array $customFields = [])
    {
        $userClass = $this->getUserClass();
        $userFields = $this->getUserFields();
        if (!$user instanceof $userClass) {
            return;
        }
        $this->sendRequest('PUT', 'client/'.$user->id, [
            'name' => !empty($userFields['name']) ? $user->{$userFields['name']} : null,
            'email' => !empty($userFields['email']) ? $user->{$userFields['email']} : null,
            'username' => !empty($userFields['username']) ? $user->{$userFields['username']} : null,
            'phoneNumber' => !empty($userFields['phone']) ? $user->{$userFields['phone']} : null,
        ]);
    }

    public function sendEvent($user, $eventKey, $parameters = [])
    {
        $userClass = $this->getUserClass();
        if (!$user instanceof $userClass) {
            $anonKey = $user;
        }
        $result = $this->sendRequest('POST', 'events/request/'.$eventKey, [
            'parameters' => $parameters,
            'clientReferenceId' => $user->id ?? null,
            'anonReferenceId' => $anonKey ?? null,
        ]);
    }

    private function sendRequest($method, $uri, $data)
    {
        $uri = self::API_URL.$uri;
        dispatch(new SendRequest($method, $uri, $data));
    }

    private function getUserClass()
    {
        return config('mesnot.user.class');
    }

    private function getUserFields()
    {
        return config('mesnot.user.fields');
    }
}
