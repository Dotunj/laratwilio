<?php

namespace Dotunj\LaraTwilio;

use Exception;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class LaraTwilioServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laratwilio.php', 'laratwilio');

        $this->app->bind('laratwilio', function () {
            $this->ensureConfigValuesAreSet();
            $client = new Client(config('laratwilio.account_sid'), config('laratwilio.auth_token'));

            return new LaraTwilio($client);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }
    }

    protected function ensureConfigValuesAreSet()
    {
        $mandatoryAttributes = config('laratwilio');

        foreach ($mandatoryAttributes as $key => $value) {
            if (empty($value)) {
                throw new Exception("Please provide a value for ${key}");
            }
        }
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/laratwilio.php' => config_path('laratwilio.php'),
        ], 'laratwilio-config');
    }
}
