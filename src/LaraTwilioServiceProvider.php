<?php

namespace Dotunj\LaraTwilio;

use Exception;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

/**
 * Class LaraTwilioServiceProvider
 *
 * Service provider for LaraTwilio package.
 */
class LaraTwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services and bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laratwilio.php', 'laratwilio');

        $this->app->bind('laratwilio', function () {
            $this->ensureConfigValuesAreSet();
            $client = new Client(config('laratwilio.account_sid'), config('laratwilio.auth_token'));

            return new LaraTwilio($client);
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
        }
    }

    /**
     * Ensure validation.
     *
     * @return void
     */
    protected function ensureConfigValuesAreSet()
    {
        $mandatoryAttributes = config('laratwilio');

        foreach (['account_sid', 'auth_token'] as $key) {
            if (empty($mandatoryAttributes[$key])) {
                throw new Exception("Please provide a value for ${key}");
            }
        }

        if (empty($mandatoryAttributes['sms_from']) || !is_array($mandatoryAttributes['sms_from'])) {
            throw new Exception("Please provide at least one valid Twilio SMS_FROM number.");
        }
    }

    /**
     * Publish configuration file.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/laratwilio.php' => config_path('laratwilio.php'),
        ], 'laratwilio-config');
    }
}
