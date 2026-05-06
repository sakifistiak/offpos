<div class="main-content-wrapper">
    <style>
        .checkout-action-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 0;
        }
        .checkout-action-btn iconify-icon {
            font-size: 18px;
        }
    </style>
    <?php if ($this->session->flashdata('exception')) { ?>
        <section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
            <div class="alert-body"><i class="icon fa fa-check me-2"></i><?php echo escape_output($this->session->flashdata('exception')); unset($_SESSION['exception']); ?></div>
        </div></section>
    <?php } ?>

    <?php if ($this->session->flashdata('exception_2')) { ?>
        <section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
            <div class="alert-body"><i class="icon fa fa-ban me-2"></i><?php echo escape_output($this->session->flashdata('exception_2')); unset($_SESSION['exception_2']); ?></div>
        </div></section>
    <?php } ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header">Checkout Orders</h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> 'Checkout Orders', 'secondSection'=> 'Manage Orders'])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box p-3">
            <?php echo form_open(base_url('Checkout_orders'), ['method' => 'get', 'class' => 'row g-2 mb-3']); ?>
                <div class="col-md-3">
                    <select name="status" class="form-control select2">
                        <option value="">All Status</option>
                        <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Processing" <?php echo $status_filter === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="Confirmed" <?php echo $status_filter === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="Delivered" <?php echo $status_filter === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                        <option value="Cancelled" <?php echo $status_filter === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="new-btn">Filter</button>
                </div>
            <?php echo form_close(); ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)) { ?>
                            <?php foreach ($orders as $index => $order) { ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo escape_output($order->sale_no); ?></td>
                                    <td><?php echo dateFormat($order->date_time); ?></td>
                                    <td><?php echo escape_output($order->customer_name); ?></td>
                                    <td><?php echo escape_output($order->customer_phone); ?></td>
                                    <td><?php echo getAmtCustom($order->total_payable); ?></td>
                                    <td><?php echo escape_output($order->account_type); ?></td>
                                    <td>
                                        <?php 
                                        $badge_class = 'bg-warning';
                                        if ($order->order_status === 'Confirmed' || $order->order_status === 'Delivered') {
                                            $badge_class = 'bg-success';
                                        } elseif ($order->order_status === 'Cancelled') {
                                            $badge_class = 'bg-danger';
                                        } elseif ($order->order_status === 'Out for Delivery') {
                                            $badge_class = 'bg-info';
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo escape_output($order->order_status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-cyan checkout-action-btn" href="<?php echo base_url('Checkout_orders/details/' . $this->custom->encrypt_decrypt($order->id, 'encrypt')); ?>" title="View Details">
                                                <iconify-icon icon="solar:eye-broken"></iconify-icon>
                                            </a>
                                            <?php if ($order->order_status === 'Pending') { ?>
                                                <a class="btn btn-success checkout-action-btn" href="<?php echo base_url('Checkout_orders/confirm/' . $this->custom->encrypt_decrypt($order->id, 'encrypt')); ?>" onclick="return confirm('Confirm this order and move it to sales?');" title="Confirm Order">
                                                    <iconify-icon icon="solar:check-circle-broken"></iconify-icon>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="text-center">No checkout orders found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
