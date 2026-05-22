<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('build_checkout_context')) {
    function build_checkout_context($area_select) {
        $CI = &get_instance();
        $CI->load->helper('my_helper');
        $cart = $CI->cart->contents();
        if (!$cart || count($cart) === 0) {
            return false;
        }
        $area = $CI->ECommerce_model->getArea($area_select);
        if (!$area) {
            return false;
        }

        $sum_sub_total = 0;
        $sum_tax_total = 0;
        $tax_totals = [];
        foreach ($cart as $item) {
            $sum_sub_total += floatval($item['subtotal']);
            $sum_tax_total += floatval($item['options']['single_item_total_tax']);
            foreach ($item['options']['total_object'] as $tax_type => $tax_amount) {
                if (!isset($tax_totals[$tax_type])) {
                    $tax_totals[$tax_type] = 0;
                }
                $tax_totals[$tax_type] += $tax_amount;
            }
        }

        $tax_list = [];
        foreach ($tax_totals as $tax_type => $tax_amount) {
            $tax_list[] = [
                "tax_field_id" => "",
                "tax_field_type" => $tax_type,
                "tax_field_amount" => floatval($tax_amount)
            ];
        }

        $tax_setting = getCompanyTax();
        $tax_list_2 = [];
        foreach ($tax_setting as $tax) {
            $tax_list_2[] = [
                "tax_field_id" => $tax->id,
                "tax_field_company_id" => $tax->id,
                "tax_field_name" => $tax->tax,
                "tax_field_percentage" => $tax->tax_rate,
            ];
        }

        $total_payable = floatval($sum_tax_total) + floatval($sum_sub_total) + floatval($area->delivary_charge);

        return [
            'area' => $area,
            'cart' => $cart,
            'sum_sub_total' => $sum_sub_total,
            'sum_tax_total' => $sum_tax_total,
            'sale_vat_objects' => json_encode($tax_list),
            'sale_vat_objects_2' => json_encode($tax_list_2),
            'total_payable' => $total_payable,
        ];
    }
}

if (!function_exists('ensure_checkout_order_tables')) {
    function ensure_checkout_order_tables() {
        $CI = &get_instance();

        $CI->db->query("CREATE TABLE IF NOT EXISTS `tbl_checkout_orders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `sale_no` varchar(50) NOT NULL,
            `customer_id` int(11) NOT NULL,
            `total_items` int(11) NOT NULL DEFAULT 0,
            `sub_total` decimal(18,2) NOT NULL DEFAULT 0.00,
            `employee_id` int(11) NOT NULL DEFAULT 0,
            `total_item_discount_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `sub_total_discount_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `total_discount_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `charge_type` varchar(50) DEFAULT NULL,
            `online_yes_no` tinyint(1) NOT NULL DEFAULT 2,
            `account_type` varchar(50) DEFAULT NULL,
            `random_code` varchar(50) DEFAULT NULL,
            `paid_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `given_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `change_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `due_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `sub_total_with_discount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `vat` decimal(18,2) NOT NULL DEFAULT 0.00,
            `total_payable` decimal(18,2) NOT NULL DEFAULT 0.00,
            `delivery_charge` decimal(18,2) NOT NULL DEFAULT 0.00,
            `sale_vat_objects` longtext DEFAULT NULL,
            `grand_total` decimal(18,2) NOT NULL DEFAULT 0.00,
            `delivery_partner_id` int(11) DEFAULT NULL,
            `area_id` int(11) DEFAULT NULL,
            `area_name` varchar(191) DEFAULT NULL,
            `close_time` varchar(20) DEFAULT NULL,
            `sale_date` date DEFAULT NULL,
            `date_time` datetime DEFAULT NULL,
            `order_date_time` datetime DEFAULT NULL,
            `added_date` datetime DEFAULT NULL,
            `order_time` varchar(20) DEFAULT NULL,
            `delivery_status` varchar(50) NOT NULL DEFAULT 'Pending',
            `order_status` varchar(50) NOT NULL DEFAULT 'Pending',
            `order_source` varchar(50) NOT NULL DEFAULT 'checkout',
            `confirmed_sale_id` int(11) DEFAULT NULL,
            `confirmed_at` datetime DEFAULT NULL,
            `confirmed_by` int(11) DEFAULT NULL,
            `notes` text DEFAULT NULL,
            `user_id` int(11) NOT NULL DEFAULT 0,
            `outlet_id` int(11) NOT NULL DEFAULT 0,
            `company_id` int(11) NOT NULL DEFAULT 0,
            `del_status` varchar(20) NOT NULL DEFAULT 'Live',
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_checkout_orders_status` (`order_status`),
            KEY `idx_checkout_orders_outlet` (`outlet_id`),
            KEY `idx_checkout_orders_sale_no` (`sale_no`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $CI->db->query("CREATE TABLE IF NOT EXISTS `tbl_checkout_order_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `checkout_order_id` int(11) NOT NULL,
            `expiry_imei_serial` text DEFAULT NULL,
            `menu_taxes` longtext DEFAULT NULL,
            `item_type` varchar(100) DEFAULT NULL,
            `food_menu_id` int(11) NOT NULL,
            `qty` decimal(18,2) NOT NULL DEFAULT 0.00,
            `menu_price_without_discount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `menu_unit_price` decimal(18,2) NOT NULL DEFAULT 0.00,
            `menu_price_with_discount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `discount_amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `is_promo_item` varchar(10) NOT NULL DEFAULT 'No',
            `promo_parent_id` int(11) NOT NULL DEFAULT 0,
            `item_seller_id` int(11) NOT NULL DEFAULT 0,
            `delivery_status` varchar(50) NOT NULL DEFAULT 'Pending',
            `created_at` date DEFAULT NULL,
            `user_id` int(11) NOT NULL DEFAULT 0,
            `outlet_id` int(11) NOT NULL DEFAULT 0,
            `company_id` int(11) NOT NULL DEFAULT 0,
            `del_status` varchar(20) NOT NULL DEFAULT 'Live',
            PRIMARY KEY (`id`),
            KEY `idx_checkout_order_items_order` (`checkout_order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $CI->db->query("CREATE TABLE IF NOT EXISTS `tbl_checkout_order_payments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `checkout_order_id` int(11) NOT NULL,
            `payment_id` int(11) NOT NULL,
            `payment_name` varchar(100) DEFAULT NULL,
            `amount` decimal(18,2) NOT NULL DEFAULT 0.00,
            `date` date DEFAULT NULL,
            `added_date` datetime DEFAULT NULL,
            `user_id` int(11) NOT NULL DEFAULT 0,
            `outlet_id` int(11) NOT NULL DEFAULT 0,
            `company_id` int(11) NOT NULL DEFAULT 0,
            `del_status` varchar(20) NOT NULL DEFAULT 'Live',
            PRIMARY KEY (`id`),
            KEY `idx_checkout_order_payments_order` (`checkout_order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
}

if (!function_exists('commit_checkout_sale')) {
    function commit_checkout_sale($context, $delivary_partner, $account_type) {
        $CI = &get_instance();
        $CI->load->helper('my_helper');
        if (!$context || !isset($context['area']) || !isset($context['cart'])) {
            return [
                'status' => 'error',
                'message' => 'Invalid order context'
            ];
        }
        $CI = &get_instance();
        $customer_id = $CI->session->userdata('customer_id');
        $frontend_outlet_id = $CI->session->userdata('frontend_outlet_id');
        $company_id = $CI->session->userdata('company_id') ?: 1;
        if (!$customer_id) {
            return [
                'status' => 'error',
                'message' => 'Customer not logged in'
            ];
        }

        $sum_sub_total = $context['sum_sub_total'];
        $sum_tax_total = $context['sum_tax_total'];
        $total_payable = $context['total_payable'];
        $area = $context['area'];
        $sale_vat_objects = $context['sale_vat_objects'];
        $sale_vat_objects_2 = $context['sale_vat_objects_2'];

        $order_data = [];
        $order_data['sale_no'] = saleNoGenerator();
        $order_data['customer_id'] = $customer_id;
        $order_data['total_items'] = count($context['cart']);
        $order_data['sub_total'] = $sum_sub_total;
        $order_data['employee_id'] = 0;
        $order_data['total_item_discount_amount'] = 0;
        $order_data['sub_total_discount_amount'] = 0;
        $order_data['total_discount_amount'] = 0;
        $order_data['charge_type'] = 'delivery';
        $order_data['online_yes_no'] = in_array($account_type, ['stripe', 'paypal', 'bkash']) ? 1 : 2;
        $order_data['account_type'] = $account_type == 'cash_on_delivery' ? 'Cash' : ucfirst(str_replace('_', ' ', $account_type));
        $order_data['random_code'] = getRandomCode(15);
        $order_data['paid_amount'] = ($account_type == 'cash_on_delivery') ? 0 : $total_payable;
        $order_data['given_amount'] = ($account_type == 'cash_on_delivery') ? 0 : $total_payable;
        $order_data['change_amount'] = 0;
        $order_data['due_amount'] = ($account_type == 'cash_on_delivery') ? $total_payable : 0;
        $order_data['sub_total_with_discount'] = $sum_sub_total;
        $order_data['vat'] = $sum_tax_total;
        $order_data['total_payable'] = $total_payable;
        $order_data['delivery_charge'] = floatval($area->delivary_charge);
        $order_data['sale_vat_objects'] = $sale_vat_objects;
        $order_data['grand_total'] = $total_payable;
        $order_data['delivery_partner_id'] = $delivary_partner;
        $order_data['area_id'] = $area->id;
        $order_data['area_name'] = $area->area_name ?? '';
        $order_data['close_time'] = date('H:i:s');
        $order_data['sale_date'] = date("Y-m-d");
        $order_data['date_time'] = date('Y-m-d H:i:s');
        $order_data['order_date_time'] = date("Y-m-d H:i:s");
        $order_data['added_date'] = date("Y-m-d H:i:s");
        $order_data['order_time'] = date("H:i:s");
        $order_data['delivery_status'] = 'Pending';
        $order_data['order_status'] = 'Pending';
        $order_data['user_id'] = 1;
        $order_data['outlet_id'] = $frontend_outlet_id;
        $order_data['company_id'] = $company_id;

        ensure_checkout_order_tables();
        $CI->db->trans_begin();
        try {
            $CI->db->insert('tbl_checkout_orders', $order_data);
            $checkout_order_id = $CI->db->insert_id();
            if ($checkout_order_id) {
                $all_items_valid = true;
                foreach ($context['cart'] as $item) {
                    $item_type = $item['options']['item_type'];
                    if ($item_type == 'IMEI_Product' || $item_type == 'Serial_Product') {
                        $imei_serial = $CI->Common_model->getIMEISerialByOutlet($item['id'], $frontend_outlet_id);
                        if ($imei_serial->allimei) {
                            $stockIMEI = explode("||", $imei_serial->allimei);
                        } else {
                            $stockIMEI = 0;
                        }
                        if (!is_array($stockIMEI) || count($stockIMEI) < $item['qty']) {
                            $all_items_valid = false;
                            throw new Exception('Ordered Quantity is not available for IMEI/Serial Product');
                        }
                        for ($i = 0; $i < $item['qty']; $i++) {
                            $details = [];
                            $details['expiry_imei_serial'] = $stockIMEI[$i];
                            $details['menu_taxes'] = $sale_vat_objects_2;
                            $details['item_type'] = $item_type;
                            $details['checkout_order_id'] = $checkout_order_id;
                            $details['food_menu_id'] = $item['id'];
                            $details['qty'] = 1;
                            $details['menu_price_without_discount'] = $item['price'];
                            $details['menu_unit_price'] = $item['price'];
                            $details['menu_price_with_discount'] = $item['price'];
                            $details['discount_amount'] = 0;
                            $details['is_promo_item'] = 'No';
                            $details['promo_parent_id'] = 0;
                            $details['item_seller_id'] = 0;
                            $details['delivery_status'] = 'Pending';
                            $details['created_at'] = date('Y-m-d');
                            $details['user_id'] = 1;
                            $details['outlet_id'] = $frontend_outlet_id;
                            $details['company_id'] = $company_id;
                            $CI->db->insert('tbl_checkout_order_items', $details);
                        }
                    } else if ($item_type == 'Medicine_Product') {
                        $result = $CI->Common_model->getExpiryByOutlet($item['id'], $frontend_outlet_id);
                        $remaining_qty = $item['qty'];
                        foreach ($result as $expiry_item) {
                            if ($remaining_qty <= 0) break;
                            $qty_to_take = min($remaining_qty, $expiry_item->stock_quantity);
                            if ($qty_to_take > 0) {
                                $details = [];
                                $details['expiry_imei_serial'] = $expiry_item->expiry_imei_serial;
                                $details['menu_taxes'] = $sale_vat_objects_2;
                                $details['item_type'] = $item_type;
                                $details['checkout_order_id'] = $checkout_order_id;
                                $details['food_menu_id'] = $item['id'];
                                $details['qty'] = $qty_to_take;
                                $details['menu_price_without_discount'] = $item['price'] * $qty_to_take;
                                $details['menu_unit_price'] = $item['price'];
                                $details['menu_price_with_discount'] = $item['price'] * $qty_to_take;
                                $details['discount_amount'] = 0;
                                $details['is_promo_item'] = 'No';
                                $details['promo_parent_id'] = 0;
                                $details['item_seller_id'] = 0;
                                $details['delivery_status'] = 'Pending';
                                $details['created_at'] = date('Y-m-d');
                                $details['user_id'] = 1;
                                $details['outlet_id'] = $frontend_outlet_id;
                                $details['company_id'] = $company_id;
                                $CI->db->insert('tbl_checkout_order_items', $details);
                                $remaining_qty -= $qty_to_take;
                            }
                        }
                    } else {
                        $details = [];
                        $details['menu_taxes'] = $sale_vat_objects_2;
                        $details['item_type'] = $item_type;
                        $details['checkout_order_id'] = $checkout_order_id;
                        $details['food_menu_id'] = $item['id'];
                        $details['qty'] = $item['qty'];
                        $details['menu_price_without_discount'] = $item['price'] * $item['qty'];
                        $details['menu_unit_price'] = $item['price'];
                        $details['menu_price_with_discount'] = $item['price'] * $item['qty'];
                        $details['discount_amount'] = 0;
                        $details['is_promo_item'] = 'No';
                        $details['promo_parent_id'] = 0;
                        $details['item_seller_id'] = 0;
                        $details['delivery_status'] = 'Pending';
                        $details['created_at'] = date('Y-m-d');
                        $details['user_id'] = 1;
                        $details['outlet_id'] = $frontend_outlet_id;
                        $details['company_id'] = $company_id;
                        $CI->db->insert('tbl_checkout_order_items', $details);
                    }
                }
                if ($account_type == 'paypal' || $account_type == 'stripe' || $account_type == 'bkash' || $account_type == 'cash_on_delivery') {
                    $payment_details = [];
                    $payment_details['date'] = date('Y-m-d');
                    $payment_details['amount'] = $total_payable;
                    $payment_details['checkout_order_id'] = $checkout_order_id;
                    $payment_details['added_date'] = date('Y-m-d H:i:s');
                    if ($account_type == 'paypal') {
                        $payment_details['payment_id'] = 3;
                        $payment_details['payment_name'] = 'Paypal';
                    } else if ($account_type == 'stripe') {
                        $payment_details['payment_id'] = 4;
                        $payment_details['payment_name'] = 'Stripe';
                    } else if ($account_type == 'bkash') {
                        $payment_details['payment_id'] = 5;
                        $payment_details['payment_name'] = 'bKash';
                    } else {
                        $payment_details['payment_id'] = 1;
                        $payment_details['payment_name'] = 'Cash';
                    }
                    $payment_details['outlet_id'] = $frontend_outlet_id;
                    $payment_details['user_id'] = 1;
                    $payment_details['company_id'] = $company_id;
                    $CI->db->insert('tbl_checkout_order_payments', $payment_details);
                }
                if ($CI->db->trans_status() === false) {
                    $CI->db->trans_rollback();
                    return [
                        'status' => 'error',
                        'message' => 'Failed to save order'
                    ];
                }
                $CI->db->trans_commit();
                $CI->cart->destroy();
                send_order_sms_notification($customer_id, $order_data['sale_no'], $total_payable, $order_data['account_type']);
                return [
                    'status' => 'success',
                    'message' => 'Order placed successfully and sent for confirmation',
                    'sale_no' => $order_data['sale_no']
                ];
            }
        } catch (Exception $e) {
            $CI->db->trans_rollback();
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
        return [
            'status' => 'error',
            'message' => 'Unable to complete order'
        ];
    }
}

if (!function_exists('send_order_sms_notification')) {
    function send_order_status_sms_notification($customer_id, $sale_no, $amount, $account_type, $status, $checkout_phone = null, $extra_placeholders = []) {
        $CI = &get_instance();
        $CI->load->model('ECommerce_model');
        $customer = $CI->ECommerce_model->getDataById($customer_id, 'tbl_customers');
        log_message('error', 'Customer object for id ' . $customer_id . ': ' . var_export($customer, true));
        if (!$customer) {
            log_message('error', 'Order SMS failed: customer not found: ' . $customer_id);
            return;
        }
        $phone = isset($customer->phone) ? trim($customer->phone) : '';
        if (empty($phone) && !empty($checkout_phone)) {
            $phone = trim($checkout_phone);
            log_message('error', 'Order SMS using checkout phone fallback for customer: ' . $customer_id . ', phone: ' . $phone);
        }
        if (empty($phone)) {
            log_message('error', 'Order SMS failed: customer phone empty and no checkout phone for customer: ' . $customer_id);
            return;
        }
        $company_id = $CI->session->userdata('company_id') ?: 1;
        $company = companyInformation($company_id);
        if (!$company) {
            log_message('error', 'Order SMS failed: company not found: ' . $company_id);
            return;
        }
        if ($company->sms_enable_status == '2') {
            log_message('error', 'Order SMS skipped because SMS is disabled for company ' . $company_id);
            return;
        }
        log_message('error', "Order SMS debug: loaded customer id={$customer_id}, phone=['{$phone}'], name=['{$customer->name}']");
        $name = trim($customer->name ?: 'Customer');
        $formatted_amount = function_exists('getAmt') ? getAmt($amount) : number_format($amount, 2);
        if (!should_send_sms_for_status($status, $company_id)) {
            log_message('error', "Order SMS skipped: template disabled for status {$status} company {$company_id}");
            return;
        }
        $template = get_sms_message_for_status($status, $company_id);
        if (empty($template)) {
            log_message('error', "Order SMS skipped: template empty for status {$status} company {$company_id}");
            return;
        }
        $placeholders = [
            '{{customer_name}}' => $name,
            '{{sale_no}}' => $sale_no,
            '{{amount}}' => $formatted_amount,
            '{{total_amount}}' => $formatted_amount,
            '{{account_type}}' => strtoupper($account_type),
        ];
        if (!empty($extra_placeholders) && is_array($extra_placeholders)) {
            foreach ($extra_placeholders as $key => $value) {
                $placeholders[$key] = $value;
            }
        }
        $message = strtr($template, $placeholders);
        log_message('error', "Trigger order SMS for status {$status} to {$phone}: {$message}");
        $send_result = smsSendOnly($message, $phone);
        if ($send_result === null) {
            log_message('error', 'Order SMS send result for ' . $phone . ' is NULL (possible provider non-return behavior).');
        }
        log_message('error', 'Order SMS send result for ' . $phone . ': ' . var_export($send_result, true));
    }

    function send_order_sms_notification($customer_id, $sale_no, $amount, $account_type, $checkout_phone = null) {
        send_order_status_sms_notification($customer_id, $sale_no, $amount, $account_type, 'order_created', $checkout_phone);
    }
}
