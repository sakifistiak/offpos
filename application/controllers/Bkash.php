<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bkash extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Bkash_lib');
        $this->load->model('Payment_model');
        $this->load->model('ECommerce_model');
        $this->load->library('cart');
        $this->load->helper(['invoice','url','order']);
    }

    /**
     * Build a user-friendly message when credentials are missing.
     */
    private function formatMissingConfigMessage(array $fields) {
        return 'Configure bKash credentials first: ' . implode(', ', $fields);
    }

    /**
     * Initiate payment and redirect to bKash page
     */
    public function initiate() {
        if (!$this->session->has_userdata('customer_email')) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Please login to continue.']));
            return;
        }
        $missingConfig = $this->bkash_lib->getMissingConfig();
        if ($missingConfig) {
            log_message('error', 'bKash gateway not configured: ' . implode(', ', $missingConfig));
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => $this->formatMissingConfigMessage($missingConfig)]));
            return;
        }
        $area_select = $this->input->post('area_select');
        $delivary_partner = $this->input->post('delivary_partner');
        $context = build_checkout_context($area_select);
        if (!$context || $context['total_payable'] <= 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => 'Unable to build order.']));
            return;
        }

        $invoice = generate_invoice();
        $this->session->set_userdata('bkash_order_data', [
            'invoice' => $invoice,
            'area_select' => $area_select,
            'delivary_partner' => $delivary_partner,
            'total_payable' => $context['total_payable']
        ]);

        $this->Payment_model->create_payment([
            'invoice' => $invoice,
            'amount' => $context['total_payable'],
            'status' => 'pending'
        ]);

        $createResponse = $this->bkash_lib->createPayment($context['total_payable'], $invoice);
        if (empty($createResponse['paymentID']) || empty($createResponse['bkashURL'])) {
            $this->Payment_model->update_payment($invoice, ['status' => 'failed']);
            $fallbackMessage = 'Unable to create payment';
            if (is_array($createResponse)) {
                $fallbackMessage = $createResponse['statusMessage'] ?? $createResponse['errorMessage'] ?? $createResponse['status'] ?? $fallbackMessage;
                if (!empty($createResponse['detail'])) {
                    $fallbackMessage .= ' - ' . (is_string($createResponse['detail']) ? $createResponse['detail'] : json_encode($createResponse['detail']));
                }
            }
            log_message('error', 'bKash create payment failure: ' . json_encode($createResponse));
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'error', 'message' => $fallbackMessage]));
            return;
        }
        $this->Payment_model->update_payment($invoice, ['paymentID' => $createResponse['paymentID']]);
        $this->output->set_content_type('application/json')->set_output(json_encode([
            'status' => 'success',
            'redirect_url' => $createResponse['bkashURL']
        ]));
    }

    /**
     * Initiate a payment (entry point)
     */
    public function pay() {
        $missingConfig = $this->bkash_lib->getMissingConfig();
        if ($missingConfig) {
            show_error($this->formatMissingConfigMessage($missingConfig), 400);
            return;
        }
        $amount = $this->input->post_get('amount', true);
        $amount = is_numeric($amount) ? floatval($amount) : 0;
        if ($amount <= 0) {
            show_error('Invalid amount', 400);
        }
        $invoice = generate_invoice();
        $paymentId = null;

        $this->Payment_model->create_payment([
            'invoice' => $invoice,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        $createResponse = $this->bkash_lib->createPayment($amount, $invoice);
        if (empty($createResponse['paymentID']) || empty($createResponse['bkashURL'])) {
            $fallbackMessage = 'Unable to create payment';
            if (is_array($createResponse)) {
                $fallbackMessage = $createResponse['statusMessage'] ?? $createResponse['errorMessage'] ?? $createResponse['status'] ?? $fallbackMessage;
                if (!empty($createResponse['detail'])) {
                    $fallbackMessage .= ' - ' . (is_string($createResponse['detail']) ? $createResponse['detail'] : json_encode($createResponse['detail']));
                }
            }
            log_message('error', 'Invalid create payment response: ' . json_encode($createResponse));
            show_error($fallbackMessage, 500);
        }

        $paymentId = $createResponse['paymentID'];
        $this->Payment_model->update_payment($invoice, [
            'paymentID' => $paymentId
        ]);

        redirect($createResponse['bkashURL']);
    }

    /**
     * Callback handler
     */
    public function callback() {
        $paymentID = $this->input->get('paymentID', true);
        $status = $this->input->get('status', true);
        if (!$paymentID || !$status) {
            log_message('error', 'Callback missing paymentID or status: ' . json_encode($this->input->get()));
            show_error('Invalid callback parameters', 400);
        }
        $payment = $this->Payment_model->get_payment_by_paymentID($paymentID);
        if (!$payment) {
            log_message('error', 'Payment not found: ' . $paymentID);
            show_error('Payment record missing', 404);
        }
        if ($payment->status === 'success') {
            $this->session->set_flashdata('exception', 'Payment already completed.');
            redirect('e-account');
            return;
        }
        if ($status === 'success') {
            $execute = $this->bkash_lib->executePayment($paymentID);
            $isCompleted = !empty($execute['paymentID']) && (strcasecmp($execute['status'], 'completed') === 0 || strcasecmp($execute['transactionStatus'] ?? '', 'completed') === 0);
            $isDuplicate = isset($execute['statusCode']) && in_array($execute['statusCode'], ['2029']);
            if ($isCompleted || $isDuplicate) {
                $this->Payment_model->update_payment($payment->invoice, ['status' => 'success']);
                $order_data = $this->session->userdata('bkash_order_data');
                if (!$order_data) {
                    show_error('Order context missing for finalization', 400);
                }
                $context = build_checkout_context($order_data['area_select']);
                if (!$context) {
                    show_error('Unable to recompute order details', 400);
                }
                $result = commit_checkout_sale($context, $order_data['delivary_partner'], 'bkash');
                $this->session->unset_userdata('bkash_order_data');
                if ($result['status'] === 'success') {
                    $this->session->set_flashdata('exception', 'Payment completed successfully.');
                    redirect('e-account');
                    return;
                }
                show_error('Order creation failed: ' . $result['message'], 500);
                return;
            }
            log_message('error', 'Execute failed: ' . json_encode($execute));
            $this->Payment_model->update_payment($payment->invoice, ['status' => 'failed']);
            $this->session->unset_userdata('bkash_order_data');
            $this->session->set_flashdata('error', 'Unable to complete payment. Please try again.');
            redirect('e-home');
            return;
        }
        $this->Payment_model->update_payment($payment->invoice, ['status' => 'failed']);
        $this->session->unset_userdata('bkash_order_data');
        $this->session->set_flashdata('error', 'bKash payment was not completed.');
        redirect('e-home');
    }
}
