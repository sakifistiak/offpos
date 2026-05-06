<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bkash tokenized checkout wrapper
 */
class Bkash_lib {

    protected $ci;
    protected $config;

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->config('bkash');
        $this->ci->load->model('Common_model');
        $this->ci->load->helper(['my_helper','url']);
        $this->config = $this->ci->config->item('bkash');
        $this->mergeCompanyConfig();

        // Normalize base_url so endpoints can be built from stable root.
        if (!empty($this->config['base_url'])) {
            $this->config['base_url'] = rtrim($this->config['base_url'], '/');
            // if user configured base_url with /checkout, strip it, because methods append /checkout
            if (str_ends_with($this->config['base_url'], '/checkout')) {
                $this->config['base_url'] = substr($this->config['base_url'], 0, -strlen('/checkout'));
            }
        }

        $this->ensureCallbackUrl();
    }

    /**
     * Override config with saved company credentials if available
     */
    private function mergeCompanyConfig() {
        $settings = [];
        $company_id = $this->ci->session->userdata('company_id');
        if ($company_id) {
            $companySetting = $this->ci->Common_model->getCompanyPaymentGetway();
            if ($companySetting && $companySetting->payment_api_setting) {
                $settings = json_decode($companySetting->payment_api_setting, true);
            }
        }
        if (empty($settings)) {
            $mainSettings = getMainCompanyPaymentMethod();
            if ($mainSettings && is_object($mainSettings)) {
                $settings = (array)$mainSettings;
            }
        }
        if (!is_array($settings) || empty($settings)) {
            return;
        }
        $mappings = [
            'bkash_app_key' => 'app_key',
            'bkash_app_secret' => 'app_secret',
            'bkash_user_name' => 'username',
            'bkash_password' => 'password',
            'bkash_base_url' => 'base_url',
        ];
        foreach ($mappings as $fieldKey => $configKey) {
            if (!empty($settings[$fieldKey])) {
                $value = $settings[$fieldKey];
                if (is_string($value)) {
                    $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
                }
                $this->config[$configKey] = $value;
            }
        }
        if (!empty($settings['bkash_callback_url'])) {
            $this->config['callback'] = html_entity_decode($settings['bkash_callback_url'], ENT_QUOTES, 'UTF-8');
        }
        if (!empty($settings['bkash_payer_reference'])) {
            $this->config['payer_reference'] = html_entity_decode($settings['bkash_payer_reference'], ENT_QUOTES, 'UTF-8');
        }
        if (!empty($settings['bkash_mode'])) {
            $this->config['mode'] = html_entity_decode($settings['bkash_mode'], ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * Build a normalized bKash API endpoint URL
     */
    private function getUrl($path) {
        $base = rtrim($this->config['base_url'], '/');
        $base = preg_replace('#/(tokenized)/(checkout)$#i', '', $base); // remove suffix
        $base = preg_replace('#/(tokenized)$#i', '', $base);
        $base = preg_replace('#/(checkout)$#i', '', $base);
        return $base . '/tokenized/checkout/' . ltrim($path, '/');
    }

    private function ensureCallbackUrl() {
        $callback = trim($this->config['callback'] ?? '');
        if ($callback === '' || stripos($callback, 'YOUR_') === 0 || stripos($callback, 'localhost') !== false) {
            $this->config['callback'] = base_url('Bkash/callback');
        }
    }

    /**
     * Get access token from bKash
     *
     * @return array|false
     */
    public function getToken() {
        $url = $this->getUrl('token/grant');
        $header = [
            'Content-Type: application/json',
            'accept: */*',
            'username: ' . $this->config['username'],
            'password: ' . $this->config['password'],
        ];
        $payload = [
            'app_key' => $this->config['app_key'],
            'app_secret' => $this->config['app_secret'],
        ];

        $response = $this->sendRequest($url, $payload, $header);
        log_message('error', 'bKash token response: ' . json_encode($response));
        return $response;
    }

    /**
     * Create payment in bKash
     *
     * @param float $amount
     * @param string $invoice
     * @return array|false
     */
    public function createPayment($amount, $invoice) {
        $tokenData = $this->getToken();
        if (empty($tokenData['id_token'])) {
            return [
                'status' => 'error',
                'statusMessage' => 'Token grant failed',
                'detail' => $tokenData
            ];
        }
        $url = $this->getUrl('create');
        $payload = [
            'amount' => number_format($amount, 2, '.', ''),
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoice,
            'currency' => 'BDT',
            'callbackURL' => $this->config['callback'],
            'payerReference' => $this->config['payer_reference'] ?? $invoice,
            'mode' => $this->config['mode'] ?? '0011'
        ];
        $header = [
            'Content-Type: application/json',
            'Authorization: ' . $tokenData['id_token'],
            'x-app-key: ' . $this->config['app_key']
        ];
        $response = $this->sendRequest($url, $payload, $header);
        log_message('error', 'bKash create payment response: ' . json_encode($response));
        return $response;
    }

    /**
     * Execute payment once customer authorizes
     *
     * @param string $paymentID
     * @return array|false
     */
    public function executePayment($paymentID) {
        $tokenData = $this->getToken();
        if (empty($tokenData['id_token'])) {
            return [
                'status' => 'error',
                'statusMessage' => 'Token grant failed',
                'detail' => $tokenData
            ];
        }
        $url = $this->getUrl('execute');
        $payload = ['paymentID' => $paymentID];
        $header = [
            'Content-Type: application/json',
            'Authorization: ' . $tokenData['id_token'],
            'x-app-key: ' . $this->config['app_key']
        ];
        $response = $this->sendRequest($url, $payload, $header);
        log_message('error', 'bKash execute payment response: ' . json_encode($response));
        return $response;
    }

    /**
     * Send cURL request
     */
    private function sendRequest($url, $payload = [], $header = []) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        $result = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error) {
            log_message('error', 'bKash cURL error: ' . $error);
            return [
                'status' => 'error',
                'statusMessage' => 'cURL request failed',
                'detail' => $error,
            ];
        }
        $decoded = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status' => 'error',
                'statusMessage' => 'Invalid JSON from bKash',
                'detail' => $result,
            ];
        }
        return $decoded ?: [];
    }

    /**
     * Return list of required config properties that are missing or still placeholders.
     *
     * @return array
     */
    public function getMissingConfig() {
        $required = [
            'app_key' => 'bKash App Key',
            'app_secret' => 'bKash App Secret',
            'username' => 'bKash Username',
            'password' => 'bKash Password',
            'base_url' => 'bKash Base URL',
            'callback' => 'Callback URL',
        ];
        $missing = [];
        foreach ($required as $key => $label) {
            $value = isset($this->config[$key]) ? trim($this->config[$key]) : '';
            if ($value === '' || stripos($value, 'YOUR_') === 0) {
                $missing[] = $label;
            }
        }
        return $missing;
    }
}
