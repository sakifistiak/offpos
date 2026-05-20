<div class="main-content-wrapper">
    <style>
        .checkout-order-page {
            background: #f7f7fb;
        }
        .checkout-order-shell {
            max-width: 1400px;
            margin: 0 auto;
        }
        .checkout-order-card {
            background: #fff;
            border: 1px solid #ececf3;
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
        }
        .checkout-order-card + .checkout-order-card {
            margin-top: 16px;
        }
        .checkout-order-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid #f0f1f5;
        }
        .checkout-order-card-body {
            padding: 20px;
        }
        .checkout-order-title {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .checkout-order-subtext {
            color: #667085;
            font-size: 13px;
        }
        .checkout-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 8px;
        }
        .checkout-badge-warning {
            background: #fff6dd;
            color: #b97900;
        }
        .checkout-badge-danger {
            background: #ffebee;
            color: #d92d20;
        }
        .checkout-badge-success {
            background: #e8fff3;
            color: #067647;
        }
        .checkout-meta-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
        }
        .checkout-info-grid {
            display: grid;
            gap: 16px;
        }
        .checkout-info-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            font-size: 14px;
        }
        .checkout-info-row strong {
            color: #101828;
        }
        .checkout-muted {
            color: #667085;
        }
        .checkout-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid #f0f1f5;
        }
        .checkout-item-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }
        .checkout-item-main {
            display: flex;
            gap: 16px;
            align-items: center;
            min-width: 0;
        }
        .checkout-item-main img {
            width: 72px;
            height: 72px;
            border-radius: 12px;
            object-fit: cover;
            background: #f4f4f6;
            border: 1px solid #ececf3;
        }
        .checkout-item-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .checkout-item-code {
            font-size: 13px;
            color: #667085;
            margin-bottom: 8px;
        }
        .checkout-item-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .checkout-pill {
            border: 1px solid #eaecf0;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            color: #344054;
            background: #fff;
        }
        .checkout-item-pricing {
            min-width: 240px;
            text-align: right;
        }
        .checkout-item-pricing .qty-box {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #eaecf0;
            background: #fff;
            margin-bottom: 10px;
        }
        .checkout-total-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 9px 0;
            font-size: 14px;
        }
        .checkout-total-row.total {
            padding-top: 14px;
            margin-top: 6px;
            border-top: 1px solid #eaecf0;
            font-size: 16px;
            font-weight: 700;
        }
        .checkout-note-box {
            min-height: 84px;
            color: #475467;
            font-size: 14px;
        }
        .checkout-timeline-box {
            min-height: 120px;
        }
        .checkout-timeline-event {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .checkout-timeline-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f59e0b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .checkout-panel-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 2px;
        }
        /* Edit Mode Styles */
        .edit-mode {
            display: none !important;
        }
        .checkout-order-shell.is-editing .view-mode {
            display: none !important;
        }
        .checkout-order-shell.is-editing .edit-mode {
            display: flex !important;
            gap: 8px;
            align-items: center;
        }
        .checkout-order-shell.is-editing .edit-mode-flex {
            display: flex !important;
        }
        .checkout-order-shell.is-editing .edit-mode-grid {
            display: grid !important;
        }
        .editable-input {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #eaecf0;
            border-radius: 8px;
            font-size: 14px;
        }
        .editable-input:focus {
            border-color: #7f56d9;
            outline: none;
            box-shadow: 0 0 0 4px rgba(127, 86, 217, 0.1);
        }
        .action-btn-group {
            display: flex;
            gap: 6px;
            align-items: center;
        }
        .btn-sm-custom {
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .status-select-wrap {
            display: flex;
            align-items: center;
            background: #f4f4f7;
            border: 1px solid #eaecf0;
            border-radius: 8px;
            padding: 0 12px;
            height: 38px;
            gap: 8px;
        }
        .status-select-label {
            font-size: 12px;
            font-weight: 700;
            color: #667085;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .status-select-wrap select {
            border: none;
            background: transparent;
            font-weight: 700;
            font-size: 14px;
            color: #101828;
            cursor: pointer;
            padding: 0;
            margin: 0;
            min-width: 100px;
            height: auto;
            appearance: none;
            -webkit-appearance: none;
        }
        .status-select-wrap select:focus {
            outline: none;
            box-shadow: none;
        }
        
        @media (max-width: 991px) {
            .checkout-item-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .checkout-item-pricing {
                min-width: 100%;
                text-align: left;
            }
            .checkout-meta-actions {
                justify-content: flex-start;
            }
        }
        /* Search & Qty Styles */
        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #eaecf0;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }
        .search-result-item {
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            border-bottom: 1px solid #f0f1f5;
        }
        .search-result-item:hover {
            background: #f9fafb;
        }
        .search-result-item img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
        }
        .search-result-info div:first-child {
            font-weight: 600;
            font-size: 14px;
        }
        .search-result-info div:last-child {
            font-size: 12px;
            color: #667085;
        }
        .qty-control {
            display: flex;
            align-items: center;
            background: #f9fafb;
            border: 1px solid #eaecf0;
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }
        .qty-btn {
            border: 0;
            background: none;
            padding: 4px 10px;
            cursor: pointer;
            color: #667085;
            font-size: 18px;
            line-height: 1;
        }
        .qty-btn:hover {
            background: #f0f1f5;
            color: #101828;
        }
        .item-qty-input {
            width: 50px !important;
            border: 0 !important;
            text-align: center;
            background: none !important;
            font-weight: 600;
            padding: 0 !important;
        }
        .item-qty-input::-webkit-inner-spin-button,
        .item-qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header">Checkout Order Details</h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> 'Checkout Orders', 'secondSection'=> 'Order Details'])?>
        </div>
    </section>

    <div class="box-wrapper checkout-order-page">
        <div class="table-box p-3">
            <div class="checkout-order-shell" id="orderShell">
                
                <div class="checkout-order-card mb-3">
                    <div class="checkout-order-card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <div class="checkout-order-title">Order ID: <?php echo escape_output($order->sale_no); ?></div>
                                <div class="mb-2">
                                    <?php if ($order->due_amount > 0) { ?>
                                        <span class="checkout-badge checkout-badge-warning">Payment pending</span>
                                    <?php } else { ?>
                                        <span class="checkout-badge checkout-badge-success">Payment complete</span>
                                    <?php } ?>
                                    <?php 
                                    $status_class = 'checkout-badge-warning';
                                    if ($order->order_status === 'Delivered' || $order->order_status === 'Confirmed') {
                                        $status_class = 'checkout-badge-success';
                                    } elseif ($order->order_status === 'Cancelled') {
                                        $status_class = 'checkout-badge-danger';
                                    } elseif ($order->order_status === 'Out for Delivery') {
                                        $status_class = 'bg-info text-white';
                                    }
                                    ?>
                                    <span class="checkout-badge <?php echo $status_class; ?>"><?php echo escape_output($order->order_status); ?></span>
                                </div>
                                <div class="checkout-order-subtext">
                                    <?php echo date('F j, Y \a\t g:i a', strtotime($order->date_time)); ?> from Checkout Orders
                                </div>
                            </div>
                            
                            <div class="checkout-meta-actions">
                                <!-- View Mode Actions -->
                                <div class="view-mode d-flex gap-2 flex-wrap align-items-center">
                                    <button type="button" class="btn btn-primary btn-sm-custom" onclick="toggleEditMode(true)">Edit Order</button>
                                    
                                    <form action="<?php echo base_url('Checkout_orders/change_status'); ?>" method="post" class="m-0">
                                        <div class="status-select-wrap">
                                            <input type="hidden" name="order_id" value="<?php echo $this->custom->encrypt_decrypt($order->id, 'encrypt'); ?>">
                                            <span class="status-select-label">Status:</span>
                                            <select name="order_status" onchange="this.form.submit()">
                                                <option value="Pending" <?php echo $order->order_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Processing" <?php echo $order->order_status == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="Confirmed" <?php echo $order->order_status == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="Out for Delivery" <?php echo $order->order_status == 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                                                <option value="Delivered" <?php echo $order->order_status == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="Cancelled" <?php echo $order->order_status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <i class="fas fa-chevron-down" style="font-size: 10px; color: #667085;"></i>
                                        </div>
                                    </form>

                                    <div class="action-btn-group">
                                        <a class="btn btn-unique border btn-sm-custom" href="<?php echo base_url('Checkout_orders/print_invoice/' . $this->custom->encrypt_decrypt($order->id, 'encrypt')); ?>" target="_blank">Print</a>
                                        <a class="btn btn-cyan border btn-sm-custom" href="<?php echo base_url('Checkout_orders/a4InvoicePDF/' . $this->custom->encrypt_decrypt($order->id, 'encrypt')); ?>">PDF</a>
                                    </div>
                                </div>

                                <!-- Edit Mode Actions -->
                                <div class="edit-mode d-flex gap-2 align-items-center">
                                    <button type="submit" form="saveOrderForm" class="btn btn-success btn-sm-custom">Save Changes</button>
                                    <button type="button" class="btn btn-light border btn-sm-custom" onclick="toggleEditMode(false)">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="saveOrderForm" action="<?php echo base_url('Checkout_orders/save_details'); ?>" method="post">
                <input type="hidden" name="order_id" value="<?php echo $this->custom->encrypt_decrypt($order->id, 'encrypt'); ?>">
                
                <div class="row g-3">
                    <div class="col-xl-8">
                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <div class="checkout-panel-title">Order Item</div>
                                    <small class="checkout-muted"><?php echo escape_output($order->order_status); ?> order items from checkout queue</small>
                                </div>
                                <div class="edit-mode search-container">
                                    <input type="text" id="productSearch" class="editable-input" placeholder="Search product by name or code..." autocomplete="off">
                                    <div id="searchResults" class="search-results"></div>
                                </div>
                                <span class="checkout-muted"><?php echo count($order->items); ?> item(s)</span>
                            </div>
                            <div class="checkout-order-card-body" id="orderItemsList">
                                <?php if (!empty($order->items)) { ?>
                                    <?php foreach ($order->items as $index => $item) { ?>
                                        <div class="checkout-item-row" data-index="<?php echo $index; ?>">
                                            <input type="hidden" name="items[<?php echo $index; ?>][id]" value="<?php echo $item->id; ?>">
                                            <input type="hidden" name="items[<?php echo $index; ?>][food_menu_id]" value="<?php echo $item->food_menu_id; ?>">
                                            <div class="checkout-item-main">
                                                <div class="item-image-wrap">
                                                    <?php if (!empty($item->photo)) { ?>
                                                        <img loading="lazy" src="<?php echo base_url('uploads/items/' . $item->photo); ?>" alt="<?php echo escape_output($item->item_name); ?>">
                                                    <?php } else { ?>
                                                        <img loading="lazy" src="<?php echo base_url('uploads/site_settings/default-picture.png'); ?>" alt="default">
                                                    <?php } ?>
                                                </div>
                                                <div>
                                                    <div class="checkout-item-name"><?php echo escape_output($item->item_name); ?></div>
                                                    <div class="checkout-item-code">Code: <?php echo escape_output($item->item_code); ?></div>
                                                    <div class="checkout-item-tags">
                                                        <span class="checkout-pill"><?php echo escape_output($item->item_type); ?></span>
                                                        <span class="checkout-pill view-mode">Qty <?php echo escape_output($item->qty); ?></span>
                                                        <?php if (!empty($item->expiry_imei_serial)) { ?>
                                                            <span class="checkout-pill"><?php echo escape_output($item->expiry_imei_serial); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkout-item-pricing">
                                                <div class="view-mode">
                                                    <div class="qty-box"><?php echo escape_output($item->qty); ?> x <?php echo getAmtCustom($item->menu_unit_price); ?></div>
                                                    <div><strong><?php echo getAmtCustom($item->menu_price_with_discount); ?></strong></div>
                                                </div>
                                                <div class="edit-mode flex-column align-items-end">
                                                    <div class="qty-control mb-2">
                                                        <button type="button" class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                                        <input type="number" step="any" name="items[<?php echo $index; ?>][qty]" value="<?php echo $item->qty; ?>" class="editable-input item-qty-input" onchange="calculateGrandTotal()">
                                                        <button type="button" class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end mb-2">
                                                        <span style="font-size:12px;">Price:</span>
                                                        <input type="number" step="any" name="items[<?php echo $index; ?>][unit_price]" value="<?php echo $item->menu_unit_price; ?>" class="editable-input item-price" style="width: 80px; text-align:right;" onchange="calculateGrandTotal()">
                                                    </div>
                                                    <div class="text-muted" style="font-size:12px;">Total: <span class="item-total-text"><?php echo getAmtCustom($item->menu_price_with_discount); ?></span></div>
                                                    <button type="button" class="btn btn-link text-danger p-0 mt-1" style="font-size:11px;" onclick="removeItem(this)">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="alert alert-warning mb-0 no-items-msg">No item found for this order.</div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="checkout-panel-title">Order Summary</div>
                                    <small class="checkout-muted">Financial breakdown of this checkout order</small>
                                </div>
                                <?php if ($order->due_amount > 0) { ?>
                                    <span class="checkout-badge checkout-badge-warning">Payment pending</span>
                                <?php } else { ?>
                                    <span class="checkout-badge checkout-badge-success">Paid</span>
                                <?php } ?>
                            </div>
                            <div class="checkout-order-card-body">
                                <div class="checkout-total-row">
                                    <span>Subtotal</span>
                                    <strong class="view-mode"><?php echo getAmtCustom($order->sub_total); ?></strong>
                                    <strong class="edit-mode"><span id="subTotalText"><?php echo getAmtCustom($order->sub_total); ?></span></strong>
                                </div>
                                <div class="checkout-total-row">
                                    <span>Discount</span>
                                    <strong class="view-mode"><?php echo getAmtCustom($order->total_discount_amount); ?></strong>
                                    <div class="edit-mode" style="width: 150px;">
                                        <input type="number" step="any" name="total_discount_amount" id="total_discount_amount" value="<?php echo $order->total_discount_amount; ?>" class="editable-input" style="text-align:right;" onchange="calculateGrandTotal()">
                                    </div>
                                </div>
                                <div class="checkout-total-row">
                                    <span>Shipping</span>
                                    <strong class="view-mode"><?php echo getAmtCustom($order->delivery_charge); ?></strong>
                                    <div class="edit-mode" style="width: 150px;">
                                        <input type="number" step="any" name="delivery_charge" id="delivery_charge" value="<?php echo $order->delivery_charge; ?>" class="editable-input" style="text-align:right;" onchange="calculateGrandTotal()">
                                    </div>
                                </div>
                                <div class="checkout-total-row">
                                    <span>VAT</span>
                                    <strong class="view-mode"><?php echo getAmtCustom($order->vat); ?></strong>
                                    <div class="edit-mode" style="width: 150px;">
                                        <input type="number" step="any" name="vat" id="vat" value="<?php echo $order->vat; ?>" class="editable-input" style="text-align:right;" onchange="calculateGrandTotal()">
                                    </div>
                                </div>
                                <div class="checkout-total-row view-mode">
                                    <span>Paid by customer</span>
                                    <strong><?php echo getAmtCustom($order->paid_amount); ?></strong>
                                </div>
                                <div class="checkout-total-row view-mode">
                                    <span>Payment due</span>
                                    <strong><?php echo getAmtCustom($order->due_amount); ?></strong>
                                </div>
                                <div class="checkout-total-row total">
                                    <span>Total</span>
                                    <strong class="view-mode"><?php echo getAmtCustom($order->grand_total); ?></strong>
                                    <strong class="edit-mode"><span id="grandTotalText"><?php echo getAmtCustom($order->grand_total); ?></span></strong>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="checkout-panel-title">Timeline</div>
                                    <small class="checkout-muted">Recent activity for this order</small>
                                </div>
                            </div>
                            <div class="checkout-order-card-body checkout-timeline-box">
                                <div class="checkout-timeline-event">
                                    <div class="checkout-timeline-avatar">
                                        <?php echo strtoupper(substr(trim($order->customer_name ?: 'C'), 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong><?php echo escape_output($order->customer_name); ?></strong>
                                        <div class="checkout-muted"><?php echo date('F j, Y \a\t g:i a', strtotime($order->date_time)); ?></div>
                                        <div class="mt-2">Order created from checkout and waiting for admin confirmation.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div class="checkout-panel-title">Notes</div>
                            </div>
                            <div class="checkout-order-card-body checkout-note-box">
                                <div class="view-mode">
                                    <?php echo $order->notes ? escape_output($order->notes) : 'First customer and order!'; ?>
                                </div>
                                <div class="edit-mode">
                                    <textarea name="notes" class="editable-input" rows="3"><?php echo $order->notes; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div class="checkout-panel-title">Customer</div>
                            </div>
                            <div class="checkout-order-card-body checkout-info-grid">
                                <div class="view-mode"><?php echo escape_output($order->customer_name); ?></div>
                                <div class="edit-mode">
                                    <input type="text" name="customer_name" value="<?php echo $order->customer_name; ?>" class="editable-input" placeholder="Customer Name">
                                </div>
                                <div class="checkout-muted"><?php echo count($order->items); ?> item(s)</div>
                                <div class="checkout-muted">Customer order is <?php echo $order->due_amount > 0 ? 'payment pending' : 'fully paid'; ?></div>
                            </div>
                        </div>

                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div class="checkout-panel-title">Contact Information</div>
                            </div>
                            <div class="checkout-order-card-body checkout-info-grid">
                                <div class="checkout-info-row">
                                    <span class="checkout-muted">Phone</span>
                                    <strong class="view-mode"><?php echo escape_output($order->customer_phone ?: 'No phone number'); ?></strong>
                                    <div class="edit-mode" style="width: 150px;">
                                        <input type="text" name="customer_phone" value="<?php echo $order->customer_phone; ?>" class="editable-input">
                                    </div>
                                </div>
                                <div class="checkout-info-row">
                                    <span class="checkout-muted">Payment Type</span>
                                    <strong><?php echo escape_output($order->account_type); ?></strong>
                                </div>
                                <div class="checkout-info-row">
                                    <span class="checkout-muted">Delivery Status</span>
                                    <strong><?php echo escape_output($order->delivery_status); ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-order-card">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div class="checkout-panel-title">Shipping Address</div>
                            </div>
                            <div class="checkout-order-card-body checkout-info-grid">
                                <div class="view-mode"><?php echo escape_output($order->customer_name); ?></div>
                                <div class="view-mode"><?php echo escape_output($order->customer_address); ?></div>
                                <div class="edit-mode">
                                    <textarea name="customer_address" class="editable-input" rows="2" placeholder="Address"><?php echo $order->customer_address; ?></textarea>
                                </div>
                                <div class="checkout-muted view-mode"><?php echo escape_output($order->area_name); ?></div>
                                <div class="edit-mode">
                                    <input type="text" name="area_name" value="<?php echo $order->area_name; ?>" class="editable-input" placeholder="Area Name">
                                </div>
                                <div class="checkout-muted view-mode"><?php echo escape_output($order->customer_phone); ?></div>
                            </div>
                        </div>

                        <div class="checkout-order-card view-mode">
                            <div class="checkout-order-card-header d-flex justify-content-between align-items-center">
                                <div class="checkout-panel-title">Payment Entries</div>
                            </div>
                            <div class="checkout-order-card-body">
                                <?php if (!empty($order->payments)) { ?>
                                    <?php foreach ($order->payments as $payment) { ?>
                                        <div class="checkout-total-row">
                                            <span>
                                                <strong><?php echo escape_output($payment->payment_name); ?></strong><br>
                                                <small class="checkout-muted"><?php echo escape_output($payment->date); ?></small>
                                            </span>
                                            <strong><?php echo getAmtCustom($payment->amount); ?></strong>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p class="mb-0 checkout-muted">No payment rows found.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let itemIndex = <?php echo isset($order->items) ? count($order->items) : 0; ?>;
    const currencySymbol = "<?php echo $this->session->userdata('currency'); ?>";

    function toggleEditMode(enable) {
        const shell = document.getElementById('orderShell');
        if (enable) {
            shell.classList.add('is-editing');
        } else {
            shell.classList.remove('is-editing');
            // Reload to reset fields if cancelled
            location.reload();
        }
    }

    // Qty Increment/Decrement
    function updateQty(btn, delta) {
        const input = btn.parentElement.querySelector('.item-qty-input');
        let currentVal = parseFloat(input.value) || 0;
        let newVal = currentVal + delta;
        if (newVal < 0) newVal = 0;
        input.value = newVal;
        calculateGrandTotal();
    }

    // Remove Item
    function removeItem(btn) {
        if (confirm('Are you sure you want to remove this item?')) {
            const row = btn.closest('.checkout-item-row');
            row.style.display = 'none';
            row.querySelector('.item-qty-input').value = 0;
            calculateGrandTotal();
        }
    }

    // Product Search Logic
    const searchInput = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            let q = this.value;
            if (q.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            fetch(`<?php echo base_url('Checkout_orders/search_items_ajax'); ?>?q=${q}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            let div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.innerHTML = `
                                <img src="${item.image}" alt="${item.item_name}">
                                <div class="search-result-info">
                                    <div>${item.item_name}</div>
                                    <div>Code: ${item.code} | Price: ${item.sale_price}</div>
                                </div>
                            `;
                            div.onclick = () => addItemToOrder(item);
                            searchResults.appendChild(div);
                        });
                        searchResults.style.display = 'block';
                    } else {
                        searchResults.style.display = 'none';
                    }
                });
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    }

    function addItemToOrder(item) {
        searchResults.style.display = 'none';
        searchInput.value = '';

        // Check if item already exists in the list
        let existingRow = null;
        document.querySelectorAll('.checkout-item-row').forEach(row => {
            let foodMenuId = row.querySelector('input[name*="[food_menu_id]"]').value;
            if (foodMenuId == item.id && row.style.display !== 'none') {
                existingRow = row;
            }
        });

        if (existingRow) {
            let qtyInput = existingRow.querySelector('.item-qty-input');
            qtyInput.value = (parseFloat(qtyInput.value) || 0) + 1;
            calculateGrandTotal();
            return;
        }

        // Add New Row
        const list = document.getElementById('orderItemsList');
        const noItemsMsg = list.querySelector('.no-items-msg');
        if (noItemsMsg) noItemsMsg.remove();

        const html = `
            <div class="checkout-item-row" data-index="${itemIndex}">
                <input type="hidden" name="items[${itemIndex}][id]" value="">
                <input type="hidden" name="items[${itemIndex}][food_menu_id]" value="${item.id}">
                <div class="checkout-item-main">
                    <div class="item-image-wrap">
                        <img src="${item.image}" alt="${item.item_name}">
                    </div>
                    <div>
                        <div class="checkout-item-name">${item.item_name}</div>
                        <div class="checkout-item-code">Code: ${item.code}</div>
                        <div class="checkout-item-tags">
                            <span class="checkout-pill">New Item</span>
                        </div>
                    </div>
                </div>
                <div class="checkout-item-pricing">
                    <div class="edit-mode flex-column align-items-end" style="display:flex !important;">
                        <div class="qty-control mb-2">
                            <button type="button" class="qty-btn" onclick="updateQty(this, -1)">-</button>
                            <input type="number" step="any" name="items[${itemIndex}][qty]" value="1" class="editable-input item-qty-input" onchange="calculateGrandTotal()">
                            <button type="button" class="qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                        <div class="d-flex align-items-center gap-2 justify-content-end mb-2">
                            <span style="font-size:12px;">Price:</span>
                            <input type="number" step="any" name="items[${itemIndex}][unit_price]" value="${item.sale_price}" class="editable-input item-price" style="width: 80px; text-align:right;" onchange="calculateGrandTotal()">
                        </div>
                        <div class="text-muted" style="font-size:12px;">Total: <span class="item-total-text">${item.sale_price} ${currencySymbol}</span></div>
                        <button type="button" class="btn btn-link text-danger p-0 mt-1" style="font-size:11px;" onclick="removeItem(this)">Remove</button>
                    </div>
                </div>
            </div>
        `;
        list.insertAdjacentHTML('beforeend', html);
        itemIndex++;
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let subTotal = 0;
        
        document.querySelectorAll('.checkout-item-row').forEach(row => {
            if (row.style.display === 'none') return;
            
            const qty = parseFloat(row.querySelector('.item-qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const itemTotal = qty * price;
            subTotal += itemTotal;
            
            // Update item total text
            const itemTotalText = row.querySelector('.item-total-text');
            if (itemTotalText) {
                itemTotalText.innerText = numberFormat(itemTotal) + ' ' + currencySymbol;
            }
        });

        const discount = parseFloat(document.getElementById('total_discount_amount').value) || 0;
        const delivery = parseFloat(document.getElementById('delivery_charge').value) || 0;
        const vat = parseFloat(document.getElementById('vat').value) || 0;

        const grandTotal = subTotal + delivery + vat - discount;

        const subTotalText = document.getElementById('subTotalText');
        const grandTotalText = document.getElementById('grandTotalText');
        
        if (subTotalText) subTotalText.innerText = numberFormat(subTotal) + ' ' + currencySymbol;
        if (grandTotalText) grandTotalText.innerText = numberFormat(grandTotal) + ' ' + currencySymbol;
    }

    function numberFormat(number) {
        return parseFloat(number).toFixed(2);
    }
</script>
</div>
