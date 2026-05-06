<?php
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === 'bangla') ? 'bangla' : '';
$payment_rows = isset($payment_methods_override) ? $payment_methods_override : [];
$logo = $this->session->userdata('invoice_logo');
$money = function ($amount) {
    $amount = is_numeric($amount) ? $amount : 0;
    $company = getCompanyInfo();
    $precision = isset($company->precision) && $company->precision !== '' ? (int) $company->precision : 0;
    $decimal = isset($company->decimals_separator) && $company->decimals_separator ? $company->decimals_separator : '.';
    $thousand = isset($company->thousands_separator) && $company->thousands_separator ? $company->thousands_separator : '';
    return number_format($amount, $precision, $decimal, $thousand);
};
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo escape_output($sale_object->sale_no); ?></title>
<style>
body{font-family:'DejaVu Sans','Segoe UI Symbol','Noto Sans Bengali',Arial,sans-serif;font-size:12px;color:#000;margin:0}
.page{width:520px;margin:0 auto;padding:10px 0}
.center{text-align:center}.right{text-align:right}.bold{font-weight:700}.small{font-size:11px}
.mt10{margin-top:10px}.mt15{margin-top:15px}.mt20{margin-top:20px}
.logo-wrap{text-align:center;margin-bottom:8px}.logo{height:84px;display:inline-block}
table{width:100%;border-collapse:collapse}
.items th,.items td{padding:4px 2px}.items thead th{border-top:1px dotted #777;border-bottom:1px dotted #777}.items tfoot td{border-top:1px dotted #777;font-weight:700;padding-top:6px}
.summary td{padding:1px 0;vertical-align:top}.summary .line td{border-top:1px dotted #777;padding-top:4px}
.note-red{color:#e11d48;font-weight:700}.italic{font-style:italic}
</style>
</head>
<body>
<div class="page">
    <div class="logo-wrap">
        <?php if($logo){ ?><img class="logo" src="<?php echo base_url().'uploads/site_settings/'.escape_output($logo); ?>"><?php } ?>
    </div>

    <div class="center small">
        <div><?php echo escape_output($this->session->userdata('business_name')); ?></div>
        <div><?php echo escape_output($outlet_info->address); ?></div>
        <div>Email: <?php echo escape_output($outlet_info->email); ?></div>
        <div>Phone: <?php echo escape_output($outlet_info->phone); ?></div>
    </div>

    <div class="center mt10 bold" style="font-size:18px;">Invoice</div>
    <div class="center mt10 bold" style="font-size:16px;text-decoration:underline;">
        <?php echo ($sale_object->total_payable == $sale_object->paid_amount) ? 'Paid' : 'Due'; ?>
    </div>

    <table class="mt15">
        <tr>
            <td style="width:58%;" class="small">
                <div><span class="bold">Bill To:</span> <?php echo escape_output($customer_info->name); ?></div>
                <div><span class="bold">Address:</span> <?php echo escape_output($customer_info->address); ?></div>
                <div><span class="bold">Phone:</span> <?php echo escape_output($customer_info->phone); ?></div>
            </td>
            <td style="width:42%;" class="right small">
                <div><span class="bold">SN:</span> <?php echo escape_output($sale_object->sale_no); ?></div>
                <div><span class="bold">Date:</span> <?php echo date('d/m/Y', strtotime($sale_object->sale_date)); ?></div>
            </td>
        </tr>
    </table>

    <table class="items mt15">
        <thead>
            <tr>
                <th style="width:6%;text-align:left;">SN</th>
                <th style="width:44%;text-align:left;">Item</th>
                <th style="width:16%;" class="right">Price</th>
                <th style="width:14%;" class="right">Qty</th>
                <th style="width:20%;" class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; $totalItems=0; $totalQty=0; foreach(($sale_object->items ?? []) as $row): $totalItems++; $totalQty += $row->qty; ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo escape_output(getItemAndParntName($row->food_menu_id)); ?><?php echo !empty($row->alternative_name) ? ' - '.escape_output($row->alternative_name) : ''; ?></td>
                <td class="right"><?php echo $money($row->menu_unit_price); ?></td>
                <td class="right"><?php echo ($ln_text=='bangla'?banglaNumber($row->qty):$row->qty).' '.unitName(getSaleUnitIdByIgId($row->food_menu_id)); ?></td>
                <td class="right"><?php echo $money($row->menu_price_with_discount); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="2" class="right">Total Item</td>
                <td class="right"><?php echo $totalItems.' ('.$totalQty.')'; ?></td>
                <td class="right"><?php echo $money($sale_object->sub_total); ?></td>
            </tr>
        </tfoot>
    </table>

    <table class="summary mt10">
        <tr><td style="width:70%;" class="bold">Previous Balance</td><td class="right"><?php echo $money($sale_object->previous_due ?? 0); ?></td></tr>
        <tr><td class="bold">Subtotal</td><td class="right"><?php echo $money($sale_object->sub_total); ?></td></tr>
        <tr><td class="bold">Charge<br>(Delivery)</td><td class="right"><?php echo $money($sale_object->delivery_charge); ?></td></tr>
        <tr><td class="bold">Total Payable</td><td class="right"><?php echo $money($sale_object->total_payable); ?></td></tr>
        <tr class="line"><td class="bold">Paid Amount</td><td class="right"><?php echo $money($sale_object->paid_amount); ?></td></tr>
        <tr><td class="bold">Due Amount</td><td class="right"><?php echo $money($sale_object->due_amount); ?></td></tr>
        <?php if(!empty($sale_object->partner_name)){ ?><tr><td class="bold">Delivery Partner</td><td class="right"><?php echo escape_output($sale_object->partner_name); ?></td></tr><?php } ?>
        <?php if(!empty($payment_rows)){ ?><tr class="line"><td class="bold">Payment Method</td><td></td></tr><?php foreach($payment_rows as $p){ ?><tr><td class="bold"><?php echo escape_output($p->payment_name); ?></td><td class="right"><?php echo $money($p->amount); ?></td></tr><?php } ?><?php } ?>
        <tr class="line"><td class="center bold" colspan="2">Given Amount<br>: <?php echo $money($sale_object->given_amount ?? 0); ?></td></tr>
        <tr><td class="center bold" colspan="2">Change Amount<br>: <?php echo $money($sale_object->change_amount ?? 0); ?></td></tr>
    </table>

    <div class="center mt15 bold"><?php echo ucwords(numberToWords($sale_object->total_payable)); ?></div>

    <div class="mt20">
        <div class="note-red">Note: <span class="italic" style="color:#000;">Only products that are faulty or incorrectly delivered by BD Baking are eligible for return.</span></div>
        <div class="italic">BD Baking is not responsible for any damage caused during courier transit,this remains the customer's sole responsibility.</div>
    </div>
</div>
</body>
</html>



