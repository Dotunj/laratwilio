<?php

return [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'sms_from' => explode(',', env('TWILIO_SMS_FROM', '')), // Support multiple numbers as a comma-separated string
];
