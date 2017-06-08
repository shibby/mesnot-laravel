<?php

namespace Shibby\Mesnot\Notifications\Channels;

use Shibby\Mesnot\MesnotClient;
use Shibby\Mesnot\MesnotMessage;

class MesnotChannel
{
    /**
     * @var MesnotClient
     */
    private $mesnotClient;

    public function __construct(MesnotClient $mesnotClient)
    {
        $this->mesnotClient = $mesnotClient;
    }

    /**
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notifiable, 'toMesnot')) {
            return;
        }

        $message = $notification->toMesnot($notifiable);
        if (!$message instanceof MesnotMessage) {
            return;
        }

        $this->mesnotClient->sendEvent(
            $notifiable,
            $message->getEventKey(),
            $message->getParameters() ?? []
        );
    }
}
