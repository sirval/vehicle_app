<?php

return [

    /*
     * Mode
     * live or test
     */
    'mode' => 'live',

    /*
     * Live API url
     */
    'baseUrl' => 'https://api.sendchamp.com/api/v1',

    /*
     * Test Api Url
     */
    'sandboxUrl' => 'https://sandbox-api.sendchamp.com/api/v1',

    /*
     * Public Key
     */
    'publicKey' => env('SENDCHAMP_PUBLIC_KEY'),

    /*
     * Webhook
     */
    'webhook' => env('SENDCHAMP_WEBHOOK'),

    'sender' => env('SENDCHAMP_SENDER_ID'),

];
