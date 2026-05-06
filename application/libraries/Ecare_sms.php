<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecare_sms {
    protected $ci;
    protected $config;

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->config('ecare_sms');
        $this->config = $this->ci->config->item('ecare_sms');
        if (!empty($this->config['base_url'])) {
            $this->config['base_url'] = rtrim($this->config['base_url'], '/');
        }
    }

    public function sendSms($recipient, $message, $schedule_time = null, $dlt_template_id = null, $type = 'plain') {
        if (empty($recipient) || empty($message)) {
            return ['status' => 'error', 'message' => 'Recipient and message are required.'];
        }
        if (!empty($this->overrides)) {
            foreach ($this->overrides as $key => $value) {
                $this->config[$key] = $value;
            }
        }
        $payload = [
            'api_token' => $this->config['api_token'],
            'recipient' => $recipient,
            'sender_id' => $this->config['sender_id'],
            'type' => $type,
            'message' => $message,
        ];
        if (!empty($schedule_time)) {
            $payload['schedule_time'] = $schedule_time;
        }
        if (!empty($dlt_template_id)) {
            $payload['dlt_template_id'] = $dlt_template_id;
        }
        $response = $this->callApi('sms/send', $payload);
        log_message('info', 'Ecare SMS send: ' . json_encode($response));
        return $response;
    }

    public function getMessage($uid) {
        if (empty($uid)) {
            return ['status' => 'error', 'message' => 'Message UID is required.'];
        }
        $endpoint = "sms/{$uid}";
        $payload = ['api_token' => $this->config['api_token']];
        return $this->callApi($endpoint, $payload, 'GET');
    }

    public function listMessages() {
        $payload = ['api_token' => $this->config['api_token']];
        return $this->callApi('sms', $payload, 'GET');
    }

    protected function callApi($path, $payload, $method = 'POST') {
        $url = $this->config['base_url'] . '/' . ltrim($path, '/');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: ' . $this->config['content_type'],
            'Accept: ' . $this->config['accept']
        ]);
        if (strtoupper($method) === 'GET') {
            $query = http_build_query($payload);
            curl_setopt($curl, CURLOPT_URL, $url . '?' . $query);
        } else {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        }
        $result = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error) {
            log_message('error', 'Ecare SMS cURL error: ' . $error);
            return ['status' => 'error', 'message' => $error];
        }
        $decoded = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Ecare SMS decode failed: ' . $result);
            return ['status' => 'error', 'message' => 'Invalid response'];
        }
        return $decoded;
    }

    protected $overrides = [];

    public function setCredentials(array $overrides = []) {
        $this->overrides = $overrides;
    }
}
