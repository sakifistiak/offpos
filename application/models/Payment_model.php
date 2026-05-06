<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

    protected $table = 'payments';

    public function __construct() {
        parent::__construct();
    }

    public function create_payment($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (isset($data['order_meta']) && is_array($data['order_meta'])) {
            $data['order_meta'] = json_encode($data['order_meta'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_payment($invoice, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (isset($data['order_meta']) && is_array($data['order_meta'])) {
            $data['order_meta'] = json_encode($data['order_meta'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $this->db->where('invoice', $invoice);
        return $this->db->update($this->table, $data);
    }

    public function get_payment_by_invoice($invoice) {
        return $this->db->get_where($this->table, ['invoice' => $invoice])->row();
    }

    public function get_payment_by_paymentID($paymentID) {
        return $this->db->get_where($this->table, ['paymentID' => $paymentID])->row();
    }
}
