<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <?php
    function payment_setting($payment_getway, $field, $fallback = '') {
        if ($payment_getway && isset($payment_getway->$field)) {
            return $payment_getway->$field;
        }
        return $fallback;
    }
    function form_value($name, $fallback = '') {
        if (function_exists('set_value')) {
            $value = set_value($name);
            if ($value !== '') {
                return $value;
            }
        }
        return $fallback;
    }
    ?>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('payment_getway'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('payment_getway'), 'secondSection'=> lang('payment_getway')])?>
        </div>
    </section>
    <section class="content-header">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'payment_getway');
            echo form_open_multipart(base_url('Payment_getway/paymentGetway'), $attributes); ?>
            <div class="box-body">
                <?php $stripe_status = form_value('action_type_stripe', payment_setting($payment_getway, 'action_type_stripe', 'Disable')); ?>
                <div class="card border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <div class="row align-items-end gy-3">
                            <div class="col-12">
                                <h5 class="mb-0"><?php echo lang('Strip'); ?></h5>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control" name="action_type_stripe" id="action_type_stripe">
                                        <option value="Enable" <?php echo $stripe_status === 'Enable' ? 'selected' : ''; ?>><?php echo lang('Enable'); ?></option>
                                        <option value="Disable" <?php echo $stripe_status === 'Disable' ? 'selected' : ''; ?>><?php echo lang('Disable'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('Stripe_Secret_Key'); ?> <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="stripe_api_key" id="stripe_api_key" placeholder="<?php echo lang('Stripe_Secret_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXXXXXXXXXXXXXXXXXX' : payment_setting($payment_getway, 'stripe_api_key'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('Stripe_Publishable_Key'); ?> <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="stripe_publishable_key" id="stripe_publishable_key" placeholder="<?php echo lang('Stripe_Publishable_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXXXXXXXXXXXXXXXXXX' : payment_setting($payment_getway, 'stripe_publishable_key'));?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $paypal_status = form_value('action_type_paypal', payment_setting($payment_getway, 'action_type_paypal', 'Disable')); ?>
                <div class="card border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <div class="row align-items-end gy-3">
                            <div class="col-12">
                                <h5 class="mb-0"><?php echo lang('Paypal'); ?></h5>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control" name="action_type_paypal" id="action_type_paypal">
                                        <option value="Enable" <?php echo $paypal_status === 'Enable' ? 'selected' : ''; ?>><?php echo lang('Enable'); ?></option>
                                        <option value="Disable" <?php echo $paypal_status === 'Disable' ? 'selected' : ''; ?>><?php echo lang('Disable'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('paypal_user_name'); ?> <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="paypal_user_name" placeholder="<?php echo lang('paypal_user_name'); ?>" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXXXXXXXXXXXXXXXXXX' : payment_setting($payment_getway, 'paypal_user_name'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('paypal_password'); ?> <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="paypal_password" placeholder="<?php echo lang('paypal_password'); ?>" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXXXXXXXXXXXXXXXXXX' : payment_setting($payment_getway, 'paypal_password'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('paypal_signature'); ?> <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="paypal_signature" placeholder="<?php echo lang('paypal_signature'); ?>" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXXXXXXXXXXXXXXXXXX' : payment_setting($payment_getway, 'paypal_signature'));?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $bkash_status = form_value('action_type_bkash', payment_setting($payment_getway, 'action_type_bkash', 'Disable')); ?>
                <div class="card border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <div class="row align-items-end gy-3">
                            <div class="col-12">
                                <h5 class="mb-0">bKash Tokenized</h5>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control" name="action_type_bkash">
                                        <option value="Enable" <?php echo $bkash_status === 'Enable' ? 'selected' : ''; ?>><?php echo lang('Enable'); ?></option>
                                        <option value="Disable" <?php echo $bkash_status === 'Disable' ? 'selected' : ''; ?>><?php echo lang('Disable'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label> bKash App Key <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="bkash_app_key" placeholder="App Key" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXX' : payment_setting($payment_getway, 'bkash_app_key'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label> bKash App Secret <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="bkash_app_secret" placeholder="App Secret" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXX' : payment_setting($payment_getway, 'bkash_app_secret'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label> bKash Username <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="bkash_user_name" placeholder="Username" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXX' : payment_setting($payment_getway, 'bkash_user_name'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label> bKash Password <span class="required_star">*</span></label>
                                    <input type="password" class="form-control" name="bkash_password" placeholder="Password" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'XXXX' : payment_setting($payment_getway, 'bkash_password'));?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label> bKash Base URL <span class="required_star">*</span></label>
                                    <input type="text" class="form-control" name="bkash_base_url" placeholder="https://tokenized.sandbox.bka.sh/v1.2.0-beta" value="<?php echo escape_output(APPLICATION_MODE == 'demo' ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta' : payment_setting($payment_getway, 'bkash_base_url'));?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer pt-0">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>









