<?php


namespace Shibby\Mesnot\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRequest implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    private $uri;

    /**
     * @var
     */
    private $data;

    /**
     * @var Client
     */
    private $client;

    public function __construct($method, $uri, $data)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->data = $data;
    }

    public function handle()
    {
        try {
            $this->client = new Client(); //todo: di
            $response = $this->client->request($this->method, $this->uri, [
                'headers' => [
                    'app-id' => config('mesnot.appId'),
                    'app-key' => config('mesnot.appKey'),
                ],
                'content-type' => 'application/json',
                'json' => $this->data,
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $exception) {
            \Log::debug('Request failed to mesnot');
            \Sentry::captureException($exception);
            return false;
        }
    }
}
