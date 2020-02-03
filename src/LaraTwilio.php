<?php

namespace Dotunj\LaraTwilio;

use Twilio\Rest\Client;

class LaraTwilio
{
    /** @var Twilio\Rest\Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function notify(string $number, string $message)
    {
        return $this->client->messages->create($number, [
            'from' => config('laratwilio.sms_from'),
            'body' => $message
        ]);
    }
}
