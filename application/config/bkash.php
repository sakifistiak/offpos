<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * bKash configuration for tokenized checkout
 */
$config['bkash'] = [
    'app_key'    => 'YOUR_APP_KEY',
    'app_secret' => 'YOUR_APP_SECRET',
    'username'   => 'YOUR_USERNAME',
    'password'   => 'YOUR_PASSWORD',
    'base_url'   => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta',
    'callback'   => 'https://bdbaking.com/Bkash/callback' // let the helper determine the callback URL
];
