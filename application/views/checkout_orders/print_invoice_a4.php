<?php
if (!isset($order)) {
    show_error('Checkout invoice data not found');
}

$sale_object = clone $order;
$sale_object->id = 0;
$sale_object->sale_date = isset($order->sale_date) && $order->sale_date ? $order->sale_date : (isset($order->date_time) ? $order->date_time : '');
$sale_object->note = isset($order->notes) ? $order->notes : '';
$sale_object->sub_total_discount_amount = isset($order->sub_total_discount_amount) ? $order->sub_total_discount_amount : (isset($order->total_discount_amount) ? $order->total_discount_amount : 0);
$sale_object->previous_due = isset($order->previous_due) ? $order->previous_due : 0;
$sale_object->rounding = isset($order->rounding) ? $order->rounding : 0;
$sale_object->partner_name = isset($order->partner_name) ? $order->partner_name : '';
$sale_object->due_date = isset($order->due_date) ? $order->due_date : '';
$sale_object->change_amount = isset($order->change_amount) ? $order->change_amount : 0;
$sale_object->given_amount = isset($order->given_amount) ? $order->given_amount : 0;
$sale_object->charge_type = isset($order->charge_type) ? $order->charge_type : 'delivery';

if (isset($sale_object->items) && is_array($sale_object->items)) {
    foreach ($sale_object->items as $item) {
        if (!isset($item->alternative_name)) {
            $item->alternative_name = '';
        }
        if (!isset($item->menu_note)) {
            $item->menu_note = '';
        }
        if (!isset($item->item_type)) {
            $item->item_type = '';
        }
        if (!isset($item->expiry_imei_serial)) {
            $item->expiry_imei_serial = '';
        }
        if (!isset($item->warranty)) {
            $item->warranty = 0;
        }
        if (!isset($item->warranty_date)) {
            $item->warranty_date = '';
        }
        if (!isset($item->guarantee)) {
            $item->guarantee = 0;
        }
        if (!isset($item->guarantee_date)) {
            $item->guarantee_date = '';
        }
        if (!isset($item->menu_discount_value)) {
            $item->menu_discount_value = 0;
        }
        if (!isset($item->discount_amount)) {
            $item->discount_amount = 0;
        }
        if (!isset($item->sales_details_id)) {
            $item->sales_details_id = 0;
        }
        if (!isset($item->menu_price_without_discount)) {
            $item->menu_price_without_discount = isset($item->menu_unit_price) ? $item->menu_unit_price : 0;
        }
    }
}

include APPPATH . 'views/sale/print_invoice_a4.php';
