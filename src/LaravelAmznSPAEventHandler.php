<?php

namespace Jasara\LaravelAmznSPA;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Response;
use Jasara\AmznSPA\HttpEventHandler;

class LaravelAmznSPAEventHandler
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen([
            ResponseReceived::class,
        ], function ($event) {
            /** @var Response $response */
            $response = $event->response;
            if ($response->header('x-amzn-RequestId')) {
                $notifiable = new HttpEventHandler;
                $notifiable->dispatch($event);
            }
        });
    }
}
