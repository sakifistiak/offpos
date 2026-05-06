<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_invoice')) {
    function generate_invoice() {
        return 'INV' . time() . rand(100, 999);
    }
}
