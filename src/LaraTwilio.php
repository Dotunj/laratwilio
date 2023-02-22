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

      /**
     * Send an SMS notification.
     *
     * @param string $number Recipient phone number.
     * @param string $message Message content.
     * @param string|null $from Optional sender phone number.
     * @return mixed Twilio API response.
     */
    public function notify(string $number, string $message, string $from = null)
    {
        $from = $from ?: $this->getRandomFromNumber();

        return $this->client->messages->create($number, [
            'from' => $from,
            'body' => $message,
        ]);
    }

    /**
     * Get a random Twilio number if multiple are available.
     *
     * @return string
     */
    protected function getRandomFromNumber()
    {
        $fromNumbers = config('laratwilio.sms_from', []);

        if (!is_array($fromNumbers)) {
            $fromNumbers = explode(',', $fromNumbers); // Convert comma-separated string to array if needed
        }

        return !empty($fromNumbers) ? $fromNumbers[array_rand($fromNumbers)] : null;
    }
}
