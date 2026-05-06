<?php
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === "bangla") ? "bangla" : '';
$tax = '';
if(isset($sale_object->sale_vat_objects) && $sale_object->sale_vat_objects != ''){
    $tax = json_decode($sale_object->sale_vat_objects);
}
$invoice_configuration = $this->session->userdata('invoice_configuration');
$inv_config = json_decode($invoice_configuration);
$invoice_heading = isset($inv_config->invoice_heading) && $inv_config->invoice_heading ? $inv_config->invoice_heading : 'INVOICE';
$invoice_no_label = isset($inv_config->invoice_no_label) && $inv_config->invoice_no_label ? $inv_config->invoice_no_label : 'Invoice No';
$invoice_date_label = isset($inv_config->invoice_date_label) && $inv_config->invoice_date_label ? $inv_config->invoice_date_label : 'Date';
$business_name = $this->session->userdata('business_name');
$footer_text = $this->session->userdata('invoice_footer') ? $this->session->userdata('invoice_footer') : 'Thank you for your business!';
?>
<div style="font-family: Arial, sans-serif; font-size: 12px; color: #333;">
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <h2 style="margin: 0; font-size: 18px;">
                    <?php
                    if($s_status == 'Bangladesh'){
                        echo $business_name;
                    }else{
                        echo (isset($inv_config->show_business_name) && $inv_config->show_business_name == 'Yes') ? $business_name : '';
                    }
                    ?>
                </h2>
                <div style="margin-top: 5px;">
                    <strong><?php echo escape_output($outlet_info->outlet_name); ?></strong><br>
                    <?php echo escape_output($outlet_info->address); ?><br>
                    <?php if(isset($outlet_info->phone) && $outlet_info->phone){ ?>
                        <?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?>
                    <?php } ?>
                </div>
            </td>
            <td style="width: 40%; text-align: right; vertical-align: top;">
                <h1 style="margin: 0; color: #888;"><?php echo $s_status == 'Bangladesh' ? 'INVOICE' : $invoice_heading; ?></h1>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <strong><?php echo lang('bill_to');?>:</strong><br>
                <?php echo escape_output(isset($customer_info->name) ? $customer_info->name : 'Walk-in Customer'); ?><br>
                <?php echo escape_output(isset($customer_info->address) ? $customer_info->address : ''); ?><br>
                <?php echo escape_output(isset($customer_info->phone) ? $customer_info->phone : ''); ?>
            </td>
            <td style="width: 40%; text-align: right; vertical-align: top;">
                <strong><?php echo escape_output($invoice_no_label); ?>:</strong> <?php echo escape_output($sale_object->sale_no);?><br>
                <strong><?php echo escape_output($invoice_date_label); ?>:</strong> <?php echo date($this->session->userdata('date_format'), strtotime($sale_object->sale_date)); ?>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 40px;">SN</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Item Description</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 80px;">Unit Price</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 60px;">Qty</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: right; width: 100px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $qty_sum = 0;
            if(isset($sale_object->items)):
                $i = 1;
                foreach($sale_object->items as $row):
                    $qty_sum += (float)$row->qty;
                    $item_name = function_exists('getItemAndParntName') ? getItemAndParntName($row->food_menu_id) : (isset($row->menu_name) ? $row->menu_name : '');
            ?>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #ddd; padding: 8px;">
                    <?php echo escape_output($item_name); ?>
                    <?php if(isset($row->alternative_name) && $row->alternative_name){ ?>
                        <?php echo ' (' . escape_output($row->alternative_name) . ')'; ?>
                    <?php } ?>
                    <?php if(isset($row->menu_note) && $row->menu_note){ ?>
                        <div style="margin-top:4px; color:#666; font-size:11px;"><?php echo lang('note');?>: <?php echo escape_output($row->menu_note); ?></div>
                    <?php } ?>
                </td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo getAmtCustom($row->menu_unit_price); ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo $ln_text == 'bangla' ? banglaNumber($row->qty) : $row->qty; ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: right;"><?php echo getAmtCustom($row->menu_price_with_discount); ?></td>
            </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: right;">Total Items / Qty:</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo $ln_text == 'bangla' ? banglaNumber($qty_sum) : $qty_sum; ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: right;"><?php echo getAmtCustom($sale_object->sub_total); ?></td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <strong>Note:</strong><br>
                <div style="padding: 10px; border: 1px solid #eee; margin-top: 5px; min-height: 40px;">
                    <?php echo !empty($sale_object->note) ? escape_output($sale_object->note) : 'N/A'; ?>
                </div>
            </td>
            <td style="width: 40%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 5px 0;">Subtotal:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($sale_object->sub_total); ?></td>
                    </tr>
                    <?php if(!empty($tax)){ foreach($tax as $t){ if(isset($t->tax_field_amount) && $t->tax_field_amount > 0){ ?>
                    <tr>
                        <td style="padding: 5px 0;"><?php echo escape_output($t->tax_field_type); ?>:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($t->tax_field_amount); ?></td>
                    </tr>
                    <?php }}} ?>
                    <?php if(isset($sale_object->delivery_charge) && $sale_object->delivery_charge > 0){ ?>
                    <tr>
                        <td style="padding: 5px 0;"><?php echo !empty($sale_object->charge_type) ? ucfirst($sale_object->charge_type) : 'Shipping'; ?>:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($sale_object->delivery_charge); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if(isset($sale_object->sub_total_discount_amount) && $sale_object->sub_total_discount_amount > 0){ ?>
                    <tr>
                        <td style="padding: 5px 0;">Discount:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($sale_object->sub_total_discount_amount); ?></td>
                    </tr>
                    <?php } ?>
                    <tr style="border-top: 2px solid #333; font-weight: bold; font-size: 14px;">
                        <td style="padding: 8px 0;">Grand Total:</td>
                        <td style="text-align: right; padding: 8px 0;"><?php echo getAmtCustom($sale_object->total_payable); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Paid Amount:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($sale_object->paid_amount); ?></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="padding: 5px 0;">Due Amount:</td>
                        <td style="text-align: right; padding: 5px 0;"><?php echo getAmtCustom($sale_object->due_amount); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <div style="border-top: 1px solid #000; width: 150px; display: inline-block; text-align: center; padding-top: 5px;">
            Authorized Signature
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #777; font-size: 10px;">
        <?php echo $footer_text; ?>
    </div>

    <?php if(!isset($is_pdf) || !$is_pdf){ ?>
    <div style="margin-top: 30px; text-align: center;">
        <button onclick="window.print();" style="padding: 8px 20px; background: #00c53c; color: #fff; border: none; cursor: pointer;">Print Invoice</button>
    </div>
    <?php } ?>
</div>
