<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_ecare_sms')) {
    function send_ecare_sms($recipient, $message, $params = []) {
        $ci = &get_instance();
        $ci->load->library('Ecare_sms');
        $schedule = isset($params['schedule']) ? $params['schedule'] : null;
        $dlt = isset($params['dlt_template_id']) ? $params['dlt_template_id'] : null;
        $type = isset($params['type']) ? $params['type'] : 'plain';
        $overrides = array_intersect_key($params, array_flip(['api_token','sender_id','base_url']));
        if ($overrides) {
            $ci->ecare_sms->setCredentials($overrides);
        }
        return $ci->ecare_sms->sendSms($recipient, $message, $schedule, $dlt, $type);
    }
}
