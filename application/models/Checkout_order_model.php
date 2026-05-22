<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_order_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->helper('order');
        ensure_checkout_order_tables();
    }

    public function getOrders($outlet_id, $status = '') {
        $this->db->select('o.*, c.name as customer_name, c.phone as customer_phone');
        $this->db->from('tbl_checkout_orders o');
        $this->db->join('tbl_customers c', 'c.id = o.customer_id', 'left');
        $this->db->where('o.outlet_id', $outlet_id);
        $this->db->where('o.del_status', 'Live');
        if ($status !== '') {
            $this->db->where('o.order_status', $status);
        }
        $this->db->order_by('o.id', 'DESC');
        return $this->db->get()->result();
    }

    public function getOrderById($id, $outlet_id) {
        $this->db->select('o.*, c.name as customer_name, c.phone as customer_phone, c.address as customer_address, dp.partner_name');
        $this->db->from('tbl_checkout_orders o');
        $this->db->join('tbl_customers c', 'c.id = o.customer_id', 'left');
        $this->db->join('tbl_delivery_partners dp', 'dp.id = o.delivery_partner_id', 'left');
        $this->db->where('o.id', $id);
        $this->db->where('o.outlet_id', $outlet_id);
        $this->db->where('o.del_status', 'Live');
        $order = $this->db->get()->row();
        if (!$order) {
            return false;
        }

        $this->db->select('i.*, m.name as item_name, m.code as item_code, m.photo');
        $this->db->from('tbl_checkout_order_items i');
        $this->db->join('tbl_items m', 'm.id = i.food_menu_id', 'left');
        $this->db->where('i.checkout_order_id', $id);
        $this->db->where('i.del_status', 'Live');
        $order->items = $this->db->get()->result();

        $this->db->select('*');
        $this->db->from('tbl_checkout_order_payments');
        $this->db->where('checkout_order_id', $id);
        $this->db->where('del_status', 'Live');
        $order->payments = $this->db->get()->result();

        return $order;
    }

    public function confirmOrder($id, $outlet_id, $user_id, $company_id) {
        $order = $this->getOrderById($id, $outlet_id);
        if (!$order) {
            return ['status' => false, 'message' => 'Checkout order not found'];
        }
        if ($order->order_status === 'Confirmed') {
            return ['status' => false, 'message' => 'This order is already confirmed'];
        }

        $sale_data = [
            'sale_no' => $order->sale_no,
            'customer_id' => $order->customer_id,
            'total_items' => $order->total_items,
            'sub_total' => $order->sub_total,
            'employee_id' => $order->employee_id,
            'total_item_discount_amount' => $order->total_item_discount_amount,
            'sub_total_discount_amount' => $order->sub_total_discount_amount,
            'total_discount_amount' => $order->total_discount_amount,
            'charge_type' => $order->charge_type,
            'online_yes_no' => $order->online_yes_no,
            'account_type' => $order->account_type,
            'random_code' => $order->random_code,
            'paid_amount' => $order->paid_amount,
            'given_amount' => $order->given_amount,
            'change_amount' => $order->change_amount,
            'due_amount' => $order->due_amount,
            'sub_total_with_discount' => $order->sub_total_with_discount,
            'vat' => $order->vat,
            'total_payable' => $order->total_payable,
            'delivery_charge' => $order->delivery_charge,
            'sale_vat_objects' => $order->sale_vat_objects,
            'grand_total' => $order->grand_total,
            'delivery_partner_id' => $order->delivery_partner_id,
            'close_time' => $order->close_time,
            'sale_date' => $order->sale_date,
            'date_time' => $order->date_time,
            'order_date_time' => $order->order_date_time,
            'added_date' => $order->added_date,
            'order_time' => $order->order_time,
            'delivery_status' => 'Delivered',
            'user_id' => $user_id,
            'outlet_id' => $order->outlet_id,
            'company_id' => $company_id,
            'del_status' => 'Live',
            'rounding' => $order->rounding ?? 0,
        ];

        $this->db->trans_begin();
        $this->db->insert('tbl_sales', $sale_data);
        $sales_id = $this->db->insert_id();

        foreach ($order->items as $item) {
            $details = [
                'expiry_imei_serial' => $item->expiry_imei_serial,
                'menu_taxes' => $item->menu_taxes,
                'item_type' => $item->item_type,
                'sales_id' => $sales_id,
                'food_menu_id' => $item->food_menu_id,
                'qty' => $item->qty,
                'menu_price_without_discount' => $item->menu_price_without_discount,
                'menu_unit_price' => $item->menu_unit_price,
                'menu_price_with_discount' => $item->menu_price_with_discount,
                'discount_amount' => $item->discount_amount,
                'is_promo_item' => $item->is_promo_item,
                'promo_parent_id' => $item->promo_parent_id,
                'item_seller_id' => $item->item_seller_id,
                'delivery_status' => 'Delivered',
                'created_at' => $item->created_at,
                'user_id' => $user_id,
                'outlet_id' => $item->outlet_id,
                'company_id' => $company_id,
                'del_status' => 'Live',
            ];
            $this->db->insert('tbl_sales_details', $details);
        }

        foreach ($order->payments as $payment) {
            $payment_data = [
                'payment_id' => $payment->payment_id,
                'payment_name' => $payment->payment_name,
                'amount' => $payment->amount,
                'date' => $payment->date,
                'added_date' => $payment->added_date,
                'sale_id' => $sales_id,
                'outlet_id' => $order->outlet_id,
                'user_id' => $user_id,
                'company_id' => $company_id,
            ];
            $this->db->insert('tbl_sale_payments', $payment_data);
        }

        $this->db->where('id', $id);
        $this->db->update('tbl_checkout_orders', [
            'order_status' => 'Delivered',
            'delivery_status' => 'Delivered',
            'confirmed_sale_id' => $sales_id,
            'confirmed_at' => date('Y-m-d H:i:s'),
            'confirmed_by' => $user_id,
        ]);

        $this->db->where('checkout_order_id', $id);
        $this->db->update('tbl_checkout_order_items', ['delivery_status' => 'Delivered']);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Order confirmation failed'];
        }

        $this->db->trans_commit();
        send_order_status_sms_notification(
            $order->customer_id,
            $order->sale_no,
            $order->grand_total,
            $order->account_type,
            'order_delivered',
            $order->customer_phone
        );
        return ['status' => true, 'message' => 'Order delivered and moved to sales successfully', 'sale_id' => $sales_id];
    }

    public function updateOrderStatus($id, $outlet_id, $status) {
        $order = $this->getOrderById($id, $outlet_id);
        if (!$order) {
            return false;
        }

        $this->db->where('id', $id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->update('tbl_checkout_orders', [
            'order_status' => $status
        ]);
        
        $updated = $this->db->affected_rows() > 0;

        if ($updated) {
            $this->load->helper('order');
            $sms_status = null;
            if ($status === 'Pending') {
                $sms_status = 'order_pending';
            } elseif ($status === 'Processing') {
                $sms_status = 'order_processing';
            } elseif ($status === 'Cancelled') {
                $sms_status = 'order_cancelled';
            } elseif ($status === 'Delivered') {
                $sms_status = 'order_delivered';
            } elseif ($status === 'Out for Delivery') {
                $sms_status = 'order_shipped';
            }
            
            if ($sms_status) {
                send_order_status_sms_notification(
                    $order->customer_id,
                    $order->sale_no,
                    $order->grand_total,
                    $order->account_type,
                    $sms_status,
                    $order->customer_phone
                );
            }
        }

        return $updated;
    }

    public function updateCheckoutOrder($id, $data) {
        $this->db->trans_begin();

        // 1. Update Customer info
        $order = $this->getOrderById($id, $data['outlet_id']);
        if ($order && isset($data['customer'])) {
            $this->db->where('id', $order->customer_id);
            $this->db->update('tbl_customers', $data['customer']);
        }

        // 2. Update Items
        $existing_item_ids = [];
        $current_items = $this->db->get_where('tbl_checkout_order_items', ['checkout_order_id' => $id, 'del_status' => 'Live'])->result();
        foreach ($current_items as $ci) {
            $existing_item_ids[] = $ci->id;
        }

        $processed_ids = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $item_id = isset($item['id']) ? $item['id'] : null;
                $qty = $item['qty'];
                $unit_price = $item['unit_price'];
                $food_menu_id = $item['food_menu_id'];

                if ($item_id && in_array($item_id, $existing_item_ids)) {
                    // Update existing
                    if ($qty <= 0) {
                        $this->db->where('id', $item_id);
                        $this->db->update('tbl_checkout_order_items', ['del_status' => 'Deleted']);
                    } else {
                        $this->db->where('id', $item_id);
                        $this->db->update('tbl_checkout_order_items', [
                            'qty' => $qty,
                            'menu_unit_price' => $unit_price,
                            'menu_price_with_discount' => $unit_price * $qty,
                            'menu_price_without_discount' => $unit_price * $qty
                        ]);
                    }
                    $processed_ids[] = $item_id;
                } else if ($qty > 0) {
                    // Insert new
                    $this->db->insert('tbl_checkout_order_items', [
                        'checkout_order_id' => $id,
                        'food_menu_id' => $food_menu_id,
                        'qty' => $qty,
                        'menu_unit_price' => $unit_price,
                        'menu_price_with_discount' => $unit_price * $qty,
                        'menu_price_without_discount' => $unit_price * $qty,
                        'del_status' => 'Live'
                    ]);
                }
            }
        }

        // Delete items that were removed
        $to_delete = array_diff($existing_item_ids, $processed_ids);
        if (!empty($to_delete)) {
            $this->db->where_in('id', $to_delete);
            $this->db->update('tbl_checkout_order_items', ['del_status' => 'Deleted']);
        }

        // 3. Update main order fields
        $main_update = [
            'delivery_charge' => $data['delivery_charge'],
            'total_discount_amount' => $data['total_discount_amount'],
            'notes' => $data['notes'],
            'area_name' => $data['area_name'],
            'sub_total' => $data['sub_total'],
            'vat' => $data['vat'],
            'grand_total' => $data['grand_total'],
            'total_payable' => $data['grand_total'],
            'due_amount' => $data['grand_total'] - $order->paid_amount,
            'total_items' => $data['total_items']
        ];
        $this->db->where('id', $id);
        $this->db->update('tbl_checkout_orders', $main_update);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }
}
