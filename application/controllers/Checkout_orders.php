<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_orders extends Cl_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Checkout_order_model');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('Please_click_on_green'));
            redirect('Outlet/outlets');
        }
    }

    public function index() {
        $outlet_id = $this->session->userdata('outlet_id');
        $status = trim($this->input->get('status'));
        $data = [];
        $data['status_filter'] = $status;
        $data['orders'] = $this->Checkout_order_model->getOrders($outlet_id, $status);
        $data['main_content'] = $this->load->view('checkout_orders/index', $data, true);
        $this->load->view('userHome', $data);
    }

    public function details($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = [];
        $data['order'] = $this->Checkout_order_model->getOrderById($id, $outlet_id);
        if (!$data['order']) {
            $this->session->set_flashdata('exception_2', 'Checkout order not found');
            redirect('Checkout_orders');
        }
        $data['main_content'] = $this->load->view('checkout_orders/details', $data, true);
        $this->load->view('userHome', $data);
    }

    public function confirm($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id') ?: 1;

        $result = $this->Checkout_order_model->confirmOrder($id, $outlet_id, $user_id, $company_id);
        if ($result['status']) {
            $this->session->set_flashdata('exception', $result['message']);
        } else {
            $this->session->set_flashdata('exception_2', $result['message']);
        }
        redirect('Checkout_orders');
    }

    public function change_status() {
        $id_encrypted = $this->input->post('order_id');
        $status = $this->input->post('order_status');

        $id = $this->custom->encrypt_decrypt($id_encrypted, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        
        if ($status === 'Delivered') {
            $user_id = $this->session->userdata('user_id');
            $company_id = $this->session->userdata('company_id') ?: 1;
            $result = $this->Checkout_order_model->confirmOrder($id, $outlet_id, $user_id, $company_id);
            if ($result['status']) {
                $this->session->set_flashdata('exception', $result['message']);
            } else {
                $this->session->set_flashdata('exception_2', $result['message']);
            }
        } else {
            if ($this->Checkout_order_model->updateOrderStatus($id, $outlet_id, $status)) {
                $this->session->set_flashdata('exception', 'Status updated successfully');
            } else {
                $this->session->set_flashdata('exception_2', 'Failed to update status');
            }
        }

        redirect('Checkout_orders/details/'.$id_encrypted);
    }
    public function print_invoice($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = [];
        $data['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $data['order'] = $this->Checkout_order_model->getOrderById($id, $outlet_id);
        if (!$data['order']) {
            $this->session->set_flashdata('exception_2', 'Checkout order not found');
            redirect('Checkout_orders');
        }

        $sale_object = clone $data['order'];
        $sale_object->id = 0;
        $sale_object->sale_date = isset($sale_object->sale_date) && $sale_object->sale_date ? $sale_object->sale_date : (isset($sale_object->date_time) ? $sale_object->date_time : '');
        $sale_object->note = isset($sale_object->notes) ? $sale_object->notes : '';
        $sale_object->sub_total_discount_amount = isset($sale_object->sub_total_discount_amount) ? $sale_object->sub_total_discount_amount : (isset($sale_object->total_discount_amount) ? $sale_object->total_discount_amount : 0);
        $sale_object->previous_due = isset($sale_object->previous_due) ? $sale_object->previous_due : 0;
        $sale_object->rounding = isset($sale_object->rounding) ? $sale_object->rounding : 0;
        $sale_object->partner_name = isset($sale_object->partner_name) ? $sale_object->partner_name : '';
        $sale_object->due_date = isset($sale_object->due_date) ? $sale_object->due_date : '';
        $sale_object->change_amount = isset($sale_object->change_amount) ? $sale_object->change_amount : 0;
        $sale_object->given_amount = isset($sale_object->given_amount) ? $sale_object->given_amount : 0;
        $sale_object->charge_type = isset($sale_object->charge_type) ? $sale_object->charge_type : 'delivery';

        if (isset($sale_object->items) && is_array($sale_object->items)) {
            foreach ($sale_object->items as $item) {
                if (!isset($item->alternative_name)) $item->alternative_name = '';
                if (!isset($item->menu_note)) $item->menu_note = '';
                if (!isset($item->item_type)) $item->item_type = '';
                if (!isset($item->expiry_imei_serial)) $item->expiry_imei_serial = '';
                if (!isset($item->warranty)) $item->warranty = 0;
                if (!isset($item->warranty_date)) $item->warranty_date = '';
                if (!isset($item->guarantee)) $item->guarantee = 0;
                if (!isset($item->guarantee_date)) $item->guarantee_date = '';
                if (!isset($item->menu_discount_value)) $item->menu_discount_value = 0;
                if (!isset($item->discount_amount)) $item->discount_amount = 0;
                if (!isset($item->sales_details_id)) $item->sales_details_id = 0;
                if (!isset($item->menu_price_without_discount)) $item->menu_price_without_discount = isset($item->menu_unit_price) ? $item->menu_unit_price : 0;
            }
        }

        $data['sale_object'] = $sale_object;
        $data['is_pdf'] = false;
        $data['payment_methods_override'] = isset($data['order']->payments) ? $data['order']->payments : [];
        $customer_id = $data['order']->customer_id;
        $data['customer_info'] = $this->Common_model->getCustomerById($customer_id);

        $this->load->view('sale/print_invoice56mm', $data);
    }

    public function a4InvoicePDF($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');

        $pdfContent = [];
        $pdfContent['outlet_info'] = $this->Common_model->getCurrentOutlet();
        $pdfContent['order'] = $this->Checkout_order_model->getOrderById($id, $outlet_id);
        if (!$pdfContent['order']) {
            $this->session->set_flashdata('exception_2', 'Checkout order not found');
            redirect('Checkout_orders');
        }

        $sale_object = clone $pdfContent['order'];
        $sale_object->id = 0;
        $sale_object->sale_date = isset($sale_object->sale_date) && $sale_object->sale_date ? $sale_object->sale_date : (isset($sale_object->date_time) ? $sale_object->date_time : '');
        $sale_object->customer_name = isset($sale_object->customer_name) ? $sale_object->customer_name : '';
        $sale_object->note = isset($sale_object->notes) ? $sale_object->notes : '';
        $sale_object->sub_total_discount_amount = isset($sale_object->sub_total_discount_amount) ? $sale_object->sub_total_discount_amount : (isset($sale_object->total_discount_amount) ? $sale_object->total_discount_amount : 0);
        $sale_object->previous_due = isset($sale_object->previous_due) ? $sale_object->previous_due : 0;
        $sale_object->rounding = isset($sale_object->rounding) ? (float) $sale_object->rounding : 0;
        $sale_object->partner_name = isset($sale_object->partner_name) ? $sale_object->partner_name : '';
        $sale_object->due_date = isset($sale_object->due_date) ? $sale_object->due_date : '';
        $sale_object->change_amount = isset($sale_object->change_amount) ? $sale_object->change_amount : 0;
        $sale_object->given_amount = isset($sale_object->given_amount) ? $sale_object->given_amount : 0;
        $sale_object->charge_type = isset($sale_object->charge_type) ? $sale_object->charge_type : 'delivery';

        if (isset($sale_object->items) && is_array($sale_object->items)) {
            foreach ($sale_object->items as $item) {
                if (!isset($item->alternative_name)) $item->alternative_name = '';
                if (!isset($item->menu_note)) $item->menu_note = '';
                if (!isset($item->item_type)) $item->item_type = '';
                if (!isset($item->expiry_imei_serial)) $item->expiry_imei_serial = '';
                if (!isset($item->warranty)) $item->warranty = 0;
                if (!isset($item->warranty_date)) $item->warranty_date = '';
                if (!isset($item->guarantee)) $item->guarantee = 0;
                if (!isset($item->guarantee_date)) $item->guarantee_date = '';
                if (!isset($item->menu_discount_value)) $item->menu_discount_value = 0;
                if (!isset($item->discount_amount)) $item->discount_amount = 0;
                if (!isset($item->sales_details_id)) $item->sales_details_id = 0;
                if (!isset($item->menu_price_without_discount)) $item->menu_price_without_discount = isset($item->menu_unit_price) ? $item->menu_unit_price : 0;
            }
        }

        if (isset($pdfContent['order']->payments) && is_array($pdfContent['order']->payments)) {
            foreach ($pdfContent['order']->payments as $payment) {
                if (!isset($payment->payment_details)) $payment->payment_details = '';
                if (!isset($payment->multi_currency)) $payment->multi_currency = '';
                if (!isset($payment->multi_currency_rate)) $payment->multi_currency_rate = '';
                if (!isset($payment->usage_point)) $payment->usage_point = '';
            }
        }

        $pdfContent['sale_object'] = $sale_object;
        $pdfContent['payment_methods_override'] = isset($pdfContent['order']->payments) ? $pdfContent['order']->payments : [];
        $customer_id = $pdfContent['order']->customer_id;
        $pdfContent['customer_info'] = $this->Common_model->getCustomerById($customer_id);
        $sale_no = ($pdfContent['order']->sale_no) . '.pdf';

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 12,
            'margin_right' => 12,
            'margin_top' => 12,
            'margin_bottom' => 12
        ]);
        $html = $this->load->view('checkout_orders/receipt_pdf', $pdfContent, true);
        $html = preg_replace('/^\\xEF\\xBB\\xBF/', '', $html);
        if (function_exists('iconv')) {
            $html = iconv('UTF-8', 'UTF-8//IGNORE', $html);
        }
        if (function_exists('mb_convert_encoding')) {
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        }

        error_reporting(0);
        ini_set('display_errors', 0);
        $mpdf->WriteHTML($html);
        $mpdf->Output($sale_no, 'D');
    }

    public function save_details() {
        $id_encrypted = $this->input->post('order_id');
        $id = $this->custom->encrypt_decrypt($id_encrypted, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');

        $data = [];
        $data['outlet_id'] = $outlet_id;
        $data['customer'] = [
            'name' => $this->input->post('customer_name'),
            'phone' => $this->input->post('customer_phone'),
            'address' => $this->input->post('customer_address')
        ];
        $data['delivery_charge'] = floatval($this->input->post('delivery_charge'));
        $data['total_discount_amount'] = floatval($this->input->post('discount'));
        $data['notes'] = $this->input->post('notes');
        $data['area_name'] = $this->input->post('area_name');
        
        $items_post = $this->input->post('items');
        $data['items'] = [];
        $sub_total = 0;
        $total_items = 0;

        if ($items_post) {
            foreach ($items_post as $item) {
                $qty = isset($item['qty']) ? floatval($item['qty']) : 0;
                $unit_price = isset($item['unit_price']) ? floatval($item['unit_price']) : 0;
                
                $data['items'][] = [
                    'id' => (isset($item['id']) && $item['id'] != '') ? $item['id'] : null,
                    'food_menu_id' => $item['food_menu_id'],
                    'qty' => $qty,
                    'unit_price' => $unit_price
                ];
                if ($qty > 0) {
                    $sub_total += ($qty * $unit_price);
                    $total_items += $qty;
                }
            }
        }

        $data['sub_total'] = $sub_total;
        $data['vat'] = $this->input->post('vat') ? floatval($this->input->post('vat')) : 0;
        $data['grand_total'] = ($sub_total + $data['delivery_charge'] + $data['vat']) - $data['total_discount_amount'];
        $data['total_items'] = $total_items;

        $this->load->model('Checkout_order_model');
        $success = $this->Checkout_order_model->updateCheckoutOrder($id, $data);

        if ($success) {
            $this->session->set_flashdata('exception', 'Order updated successfully');
        } else {
            $this->session->set_flashdata('exception_1', 'Failed to update order');
        }

        redirect('Checkout_orders/details/' . $id_encrypted);
    }

    public function search_items_ajax() {
        $q = $this->input->get('q');
        $company_id = $this->session->userdata('company_id');
        
        $this->db->select('i.id, i.name as item_name, i.code, i.sale_price, i.photo');
        $this->db->from('tbl_items i');
        $this->db->group_start();
        $this->db->like('i.name', $q);
        $this->db->or_like('i.code', $q);
        $this->db->group_end();
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.del_status', 'Live');
        $this->db->where('i.enable_disable_status', 'Enable');
        $this->db->limit(10);
        $items = $this->db->get()->result();

        foreach ($items as $item) {
            if ($item->photo && file_exists('uploads/items/' . $item->photo)) {
                $item->image = base_url('uploads/items/' . $item->photo);
            } else {
                $item->image = base_url('uploads/site_settings/image_thumb.png');
            }
        }

        echo json_encode($items);
    }
}









