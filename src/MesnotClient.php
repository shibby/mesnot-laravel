<?php

namespace Shibby\Mesnot;

use GuzzleHttp\Client;
use Shibby\Mesnot\Jobs\SendRequest;

class MesnotClient
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
        $clientKey = $user->id;
        if(config('mesnot.isSandbox')){
            $clientKey .= '_sandbox';
        }
        $this->sendRequest('PUT', 'client/'.$clientKey, [
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
        $parameters = $this->mergeDefaultParameters($parameters);

        $clientKey = null;
        if($user){
            $clientKey = $user->id;
            if(config('mesnot.isSandbox')){
                $clientKey .= '_sandbox';
            }
        }
        $this->sendRequest('POST', 'events/request/'.$eventKey, [
            'parameters' => $parameters,
            'clientReferenceId' => $clientKey,
            'anonReferenceId' => $anonKey ?? null,
            'isSandbox' => config('mesnot.isSandbox')
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

    private function mergeDefaultParameters($parameters)
    {
        if (!is_array($parameters)) {
            $parameters = [];
        }

        return array_merge([
            'app_url' => config('app.url'),
            'app_env' => config('app.env'),
        ], $parameters);
    }
}
