<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Door Soft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is ECommerce_setting Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use Stripe\Charge;
use Stripe\Stripe;
class ECommerce_frontend extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('ECommerce_model');
        $this->load->library('cart');
        $this->load->library('form_validation');
        $this->load->helper('order');
        $this->Common_model->setDefaultTimezone();
        $this->load->helper('my_helper');
    }

    /**
     * newsLetterSubmit
     * @access public
     * @param string
     * @return void
     */
    public function newsLetterSubmit(){
        $newsletter_email = $this->input->post('newsletter_email');
        $this->db->select("newsletter_email");
        $this->db->from('tbl_newsletters');
        $this->db->where("newsletter_email", $newsletter_email);
        $result = $this->db->get()->row(); 
        if(!$result){
            $data = array();
            $data['newsletter_email'] = $newsletter_email;
            $data['company_id'] = 1;
            $id = $this->Common_model->insertInformation($data, "tbl_newsletters");
            if($id){
                $response = [
                    'status' => 'success',
                    'message' => 'Email Added to Newsletter',
                ];	
            }else{
                $response = [
                    'status' => 'error',
                    'message' => 'Email added failed',
                ];	
            }
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Already added this email',
            ];	
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    /**
     * setlanguage
     * @access public
     * @param string
     * @return void
     */
    public function setlanguage(){
        $lan_name = $this->input->post('lan_name');
        $this->session->set_userdata('language', strtolower($lan_name));
        $response = [
            'status' => 'success',
            'language' => $lan_name,
        ];	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * setOutlet
     * @access public
     * @param string
     * @return void
     */
    public function setOutlet(){
        $outlet_id = $this->input->post('frontend_outlet_id');
        if(!$outlet_id) {
            redirect('e-home');
            return;
        }
        $this->session->set_userdata('frontend_outlet_id', $outlet_id);
        redirect('e-home');
    }

    /**
     * homePage
     * @access public
     * @param int
     * @return void
     */
    public function homePage(){
        $this->db->select("e_commerce_checker");
        $this->db->from("tbl_companies");
        $this->db->where("id", 1);
        $result = $this->db->get()->row();
        if($result->e_commerce_checker == 'No') {
            redirect('authentication/index');
        } 
        $language = $this->session->userdata('language');
        if(!$language){
            $ecommerce_setting  = getECommerceSetting();
            $this->session->set_userdata('language', strtolower($ecommerce_setting->default_language));
        }
        $data = array();
        $data['banners'] = $this->ECommerce_model->getAllActiveBanner();
        $data['service_time'] = $this->ECommerce_model->getAllActiveServiceTime();
        $data['top_sale_category'] = $this->ECommerce_model->getMostSoldCategories();
        $data['flash_sales'] = $this->ECommerce_model->fetchFlashSale1();
        $data['top_sale'] = $this->ECommerce_model->getMostSoldProducts1(10);
        $data['top_rated'] = $this->ECommerce_model->getTopRatedProducts1(3);
        $data['latest_sale'] = $this->ECommerce_model->getLatestSaleProducts1(3);
        $data['customer_ratting'] = $this->ECommerce_model->customerRatting(3);
        $data['main_content'] = $this->load->view('eCommerce/frontend/home', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }

    /**
     * faq
     * @access public
     * @param int
     * @return void
     */
    public function faq(){
        $data = array();
        $data['faq'] = $this->ECommerce_model->getAllFaq();
        $data['main_content'] = $this->load->view('eCommerce/frontend/faq', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * contactUs
     * @access public
     * @param int
     * @return void
     */
    public function contactUs(){
        $data = array();
        $contact_info = $this->Common_model->getDataById(1, "tbl_ecommerce");
        $data['contact_data'] = json_decode(isset($contact_info->contact_information) && $contact_info->contact_information ? $contact_info->contact_information : '');
        $data['main_content'] = $this->load->view('eCommerce/frontend/contact', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }


    /**
     * trackOrder
     * @access public
     * @param int
     * @return void
     */
    public function trackOrder(){
        $data = array();
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('order_number', lang('order_number'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $order_number = htmlspecialcharscustom($this->input->post($this->security->xss_clean('order_number')));
                $data['order_result'] = $this->ECommerce_model->getOrderByOrderNumber($order_number);
                $data['main_content'] = $this->load->view('eCommerce/frontend/track_order_result', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            } else {
                $data['main_content'] = $this->load->view('eCommerce/frontend/track_order', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        } else {
            $data['main_content'] = $this->load->view('eCommerce/frontend/track_order', $data, TRUE);
            $this->load->view('eCommerce/frontend/main_layout', $data);
        }

        
    }

    /**
     * account
     * @access public
     * @param int
     * @return void
     */
    public function account(){
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $customer_id = $this->session->userdata('customer_id');
        $data = array();
        $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
        $data['get_customer_order'] = $this->ECommerce_model->getCustomerOrder($customer_id);
        $data['main_content'] = $this->load->view('eCommerce/frontend/account', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * accountOrderHistory
     * @access public
     * @param int
     * @return void
     */
    public function accountOrderHistory(){
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $customer_id = $this->session->userdata('customer_id');
        $data = array();
        $data['get_customer_order'] = $this->ECommerce_model->getCustomerOrder($customer_id);
        $data['main_content'] = $this->load->view('eCommerce/frontend/account_order_history', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * orderDetails
     * @access public
     * @param int
     * @return void
     */
    public function orderDetails($order_id=''){
        $id = $this->custom->encrypt_decrypt($order_id, 'decrypt');
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $customer_id = $this->session->userdata('customer_id');
        $data = array();
        $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
        $data['get_customer_order'] = $this->ECommerce_model->getCustomerOrderDetails($id);
        $data['main_content'] = $this->load->view('eCommerce/frontend/order_details', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    
    /**
     * wishList
     * @access public
     * @param int
     * @return void
     */
    public function wishList(){
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $data = array();
        $data['wishlist'] = $this->ECommerce_model->getWishlist();
        $data['main_content'] = $this->load->view('eCommerce/frontend/wish_list', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * shoppingCart
     * @access public
     * @param int
     * @return void
     */
    public function shoppingCart(){
        if(!$this->session->has_userdata('customer_id')){
            if ($this->cart->total_items() > 0) {
                redirect('e-register?next='.urlencode(current_url()));
            }
            redirect('e-login?next='.urlencode(current_url()));
        }
        $data = array();
        $data['main_content'] = $this->load->view('eCommerce/frontend/shopping_cart', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * checkout
     * @access public
     * @param int
     * @return void
     */
    public function checkout(){
        if(!$this->session->has_userdata('customer_id')){
            if ($this->cart->total_items() > 0) {
                redirect('e-register?next='.urlencode(current_url()));
            }
            redirect('e-login?next='.urlencode(current_url()));
        }
        $customer_id = $this->session->userdata('customer_id');
        $data = array();
        $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
        $data['areas'] = $this->ECommerce_model->getAllAreas();
        $data['delivary_partner'] = $this->ECommerce_model->getAllDelivaryPartner();
        $gateway_settings = getCompanyPaymentMethod();
        if(!$gateway_settings){
            $gateway_settings = getMainCompanyPaymentMethod();
        }
        $data['payment_gateways'] = $gateway_settings;
        $data['main_content'] = $this->load->view('eCommerce/frontend/checkout', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * placeOrder
     * @access public
     * @param int
     * @return void
     */
    public function placeOrder(){
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $area_select = $this->input->post('area_select');
        $delivary_partner = $this->input->post('delivary_partner');
        $account_type = $this->input->post('account_type');
        $payment_process = $this->input->post('payment_process');

        if ($account_type == 'bkash') {
            $response = [
                'status' => 'error',
                'message' => 'Please use the bKash payment button to continue.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        if(( $account_type == 'stripe' || $account_type == 'paypal') && $payment_process == '400'){
            $response = [
                'status' => 'error',
                'message' => 'Complete your payment'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        if($delivary_partner == ''){
            $response = [
                'status' => 'error',
                'message' => 'Delivary Partner field is required'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        if(!$area_select){
            $response = [
                'status' => 'error',
                'message' => 'Area selection is required'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $context = build_checkout_context($area_select);
        if(!$context){
            $response = [
                'status' => 'error',
                'message' => 'Unable to build checkout data'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        if($context['total_payable'] <= 0){
            $response = [
                'status' => 'error',
                'message' => 'Grand total is Zero'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        $result = commit_checkout_sale($context, $delivary_partner, $account_type);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function getProductInformation(){
        $product_id = $this->input->post('product_id');
        $org_pro_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        $product_stock = $this->ECommerce_model->getProductStockCheckByOutlet($org_pro_id);
        $product_info = $this->ECommerce_model->getProductInformationById($org_pro_id);
        if($product_info->type == 'Variation_Product'){
            $product_info->variations = $this->ECommerce_model->getProductVariations($org_pro_id);
        }else{
            $product_info->variations = '';
        }
        $product_image = $this->ECommerce_model->getAllProductImages($org_pro_id);
        if($product_info){
            $response = [
                'status' => 'success',
                'data' => $product_info,
                'stock' => $product_stock,
                'product_image' => $product_image,
            ];	
        }else{
            $response = [
                'status' => 'error',
                'data' => '',
                'stock' => '',
                'product_image' => '',
            ];	
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        
    }

    /**
     * productDetails
     * @access public
     * @param no
     * @return void
     */
    public function productDetails($product_id = '') {
        $data = array();
        if(!ctype_digit($product_id)){
            $product_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        }
        if(!$product_id){
            show_404();
            return;
        }
        $data['stock'] = $this->ECommerce_model->getProductStockCheckByOutlet($product_id);
        $data['product_info'] = $this->ECommerce_model->getProductInformationById($product_id);
        if(!$data['product_info']){
            show_404();
            return;
        }
        if($data['product_info']->type == 'Variation_Product'){
            $data['product_variation'] = $this->ECommerce_model->getProductVariations($product_id);
        }else{
            $data['product_variation'] = '';
        }
        $data['product_image'] = $this->ECommerce_model->getAllProductImages($product_id);
        $data['products'] = $this->ECommerce_model->getAllProductsByCategoryId($data['product_info']->category_id);
        $data['main_content'] = $this->load->view('eCommerce/frontend/product_details', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }


    /**
     * addToCart
     * @access public
     * @param no
     * @return json
     */
    public function addToCart() {
        $frontend_outlet_id  = $this->session->userdata('frontend_outlet_id');
        $product_id = $this->input->post('product_id');
        $sale_price = $this->input->post('productSP');
        $increase_decrease = $this->input->post('increase_decrease'); 
        $quantity = $this->input->post('quantity') ? $this->input->post('quantity') : 1;
        // Validate and sanitize product_id
        if(ctype_digit($product_id)){
            $product_id = $product_id;
        }else{
            $product_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        }
        // Validate and sanitize sale_price
        if(is_numeric($sale_price)){
            $sale_price = floatval($sale_price);
        }else{
            $sale_price = $this->custom->encrypt_decrypt($sale_price, 'decrypt');
        }
        $product = $this->ECommerce_model->getProduct($product_id);
        $product_stock = $this->ECommerce_model->getProductStockCheckByOutlet($product_id);

        if (!$product) {
            $response = [
                'status' => 'error',
                'message'=> 'Product not found',
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // Calculate tax
        $tax_info = '';
        if($product->tax_information){
            $tax_info = json_decode($product->tax_information);
        }
        
        $taxObject = [];
        $total_tax = 0;
        if($tax_info){
            foreach ($tax_info as $tax) {
                $total_tax += (float) $tax->tax_field_percentage * $sale_price / 100;
                $taxObject[$tax->tax_field_name] = (float) $tax->tax_field_percentage * $sale_price / 100;
            }
        }

        // Check cart and handle updates
        $cart = $this->cart->contents();
        $rowid = null;
        $existing_qty = 0;

        foreach ($cart as $item) {
            if ($item['id'] == $product->id) {
                $rowid = $item['rowid'];
                $existing_qty = $item['qty'];
                break;
            }
        }

        if ($rowid) {
            // Update existing cart item
            if($increase_decrease == 'Increase') {
                $new_qty = floatval($existing_qty) + floatval($quantity);
                if(floatval($product_stock) < $new_qty){
                    $response = [
                        'status' => 'error',
                        'message' => 'Product stock is not enough',
                    ];
                } else {
                    $data = array(
                        'rowid' => $rowid,
                        'qty'   => $new_qty,
                    );
                    $this->cart->update($data);
                    $response = [
                        'status' => 'success',
                        'message'=> 'Cart updated successfully',
                    ];
                }
            } else {
                $data = array(
                    'rowid' => $rowid,
                    'qty'   => $existing_qty - $quantity,
                );
                $this->cart->update($data);
                $response = [
                    'status' => 'success', 
                    'message'=> 'Cart updated successfully',
                ];
            }
        } else {
            // Add new cart item
            if(floatval($product_stock) < floatval($quantity)) {
                $response = [
                    'status' => 'error',
                    'message' => 'Product stock is not enough',
                ];
            } else {
                // Validate and sanitize item name
                if($product->parent_name){
                    $item_name = strip_tags($product->parent_name . ' - ' . $product->name); 
                }else{
                    $item_name = strip_tags($product->name);
                }
                $item_name = html_entity_decode($item_name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $item_name = preg_replace('/[^A-Za-z0-9\s\-]/', '', $item_name);
                $item_name = trim($item_name);
                if(empty($item_name) || empty($product->id) || empty($quantity) || empty($sale_price)) {
                    $response = [
                        'status' => 'error',
                        'message'=> 'Required product data is missing'
                    ];
                } else {
                    $data = array(
                        'id'      => $product->id,
                        'name'    => $item_name,
                        'qty'     => (int)$quantity,
                        'price'   => floatval($sale_price),
                        'options' => array(
                            'cart_photo' => !empty($product->photo) ? $product->photo : '',
                            'total_object' => $taxObject,
                            'single_item_total_tax' => $total_tax,
                            'item_type' => $product->type,
                        ),
                    );
                    if($this->cart->insert($data)) {
                        $response = [
                            'status' => 'success',
                            'message'=> 'Product added to cart successfully'
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message'=> 'Failed to add product to cart'
                        ];
                    }
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
    /**
     * cartDataShow
     * @access public
     * @param no
     * @return json
     */
    public function cartDataShow() {
        $cart_html = '';
        $subtotal = isset($subtotal) ? $subtotal : 0.0;
        if ($this->cart->total_items() > 0){
            foreach ($this->cart->contents() as $item){
                $image_html = '';
                if($item['options']['cart_photo']){
                    $image_html = '<img loading="lazy" src="'.base_url('uploads/items/'.$item['options']['cart_photo']).'" alt="'.$item['name'].'">';
                }else{
                    $image_html = '<img loading="lazy" src="'.base_url('uploads/site_settings/default-picture.png').'" alt="'.$item['name'].'">';
                }
                $qty = isset($item['qty']) ? floatval($item['qty']) : 0.0;
                $price = isset($item['price']) ? floatval($item['price']) : 0.0;
                $subtotal += $qty * $price;
                $cart_html .= '<a href="javascript:void(0)" class="single_cartdrop mb-3">
                    <span class="remove_cart" data-product-id="'.$this->custom->encrypt_decrypt($item['id'], 'encrypt').'"><i class="las la-times"></i></span>
                    <div class="cartdrop_img">
                        '.$image_html.'
                    </div>
                    <div class="cartdrop_cont">
                        <h5 class="text_lg mb-0 default_link">
                            '.$item['name'].'
                        </h5>
                        <p class="mb-0 text_xs text_p">'. $item['qty'] .' X <span class="ms-2">'. getAmt($item['price']) .'</span></p>
                    </div>
                </a>';
            }
        }
        $response = [
            'data' => $cart_html,
            'subtotal'=> getAmt($subtotal),
            'total_item'=> count($this->cart->contents()),
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * removeFromCart
     * @access public
     * @param no
     * @return json
     */
    public function removeFromCart() {
        $product_id = $this->input->post('product_id');
        $product_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        $cart = $this->cart->contents();
        $rowid = null;
        foreach ($cart as $item) {
            if ($item['id'] == $product_id) {
                $rowid = $item['rowid'];
                break;
            }
        }
        if ($rowid) {
            $data = array(
                'rowid' => $rowid,
                'qty'   => 0,
            );
            $this->cart->update($data);
            $response = [
                'status' => 'success',
                'message' => 'Product remove successfully'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Item Not Found'
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }



    /**
     * addToWishlist
     * @access public
     * @param no
     * @return json
     */
    public function addToWishlist() {
        $product_id = $this->input->post('product_id');
        if(ctype_digit($product_id)){
            $product_id = $product_id;
        }else{
            $product_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        }
        $customer_id = $this->session->userdata('customer_id');
        $wishlist = 0;
        if (!$customer_id) {
            $response = [
                'status' => 'login',
                'message' => 'e-login'
            ];
        } else {
            $this->db->where('customer_id', $customer_id);
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('tbl_wishlist');
            
            if ($query->num_rows() > 0) {
                $this->db->where('customer_id', $customer_id);
                $wishlist = $this->db->count_all_results('tbl_wishlist');
                $response = [
                    'status' => 'error',
                    'message' => 'Item already in Wishlist',
                    'wishlist_count' => $wishlist
                ];
            } else {
                $data = [
                    'customer_id' => $customer_id,
                    'product_id' => $product_id,
                    'added_date' => date('Y-m-d H:i:s'),
                    'company_id' => 1
                ];
                $inserted = $this->db->insert('tbl_wishlist', $data);
                if ($inserted) {
                    $this->db->where('customer_id', $customer_id);
                    $wishlist = $this->db->count_all_results('tbl_wishlist');
                    $response = [
                        'status' => 'success',
                        'message' => 'Item added to Wishlist',
                        'wishlist_count' => $wishlist
                    ];
                } else {
                    $this->db->where('customer_id', $customer_id);
                    $wishlist = $this->db->count_all_results('tbl_wishlist');
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to add item to Wishlist',
                        'wishlist_count' => $wishlist
                    ];
                }
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    /**
     * getProductStockCheck
     * @access public
     * @param no
     * @return json
     */
    public function getProductStockCheck(){
        $item_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('variation_id')));
        $product = $this->ECommerce_model->getProduct($item_id);
        $result = $this->ECommerce_model->getProductStockCheckByOutlet($item_id);
        $product_image = $this->ECommerce_model->getAllProductImages($item_id);
        $response = [
            'status' => 'success',
            'data' => $result,
            'p_info' => $product,
            'product_image' => $product_image,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    /**
     * getProductSearch
     * @access public
     * @param no
     * @return json
     */
    public function getProductSearch(){
        if($this->input->get('search')){
            $search_value = urldecode($this->input->get('search'));
        }else{
            $search_value = '';
        }
        if(!$search_value) {
            $response = [
                'status' => 'error',
                'message' => 'Search value is required'
            ];
            $this->output->set_content_type('application/json')
                        ->set_output(json_encode($response));
            return;
        }
        $search_results = $this->ECommerce_model->searchProducts($search_value);
        $response = [
            'status' => 'success',
            'data' => $search_results
        ];
        $this->output->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }

    /**
     * contactUsStore
     * @access public
     * @param int
     * @return void
     */
    public function contactUsStore() {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('email_phone', lang('email_phone'), 'required|max_length[50]');
            $this->form_validation->set_rules('subject', lang('subject'), 'required|max_length[250]');
            $this->form_validation->set_rules('message', lang('message'), 'required|max_length[300]');
            if ($this->form_validation->run() == TRUE) {
                $contact_us = array();
                $contact_us['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $contact_us['email_phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_phone')));
                $contact_us['subject'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('subject')));
                $contact_us['message'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('message')));
                $contact_us['company_id'] = 1;
                $this->Common_model->insertInformation($contact_us, "tbl_contacts");
                $this->session->set_flashdata('exception',lang('insertion_success'));
                redirect('e-contact');
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/frontend/contact', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('eCommerce/frontend/contact', $data, TRUE);
            $this->load->view('eCommerce/frontend/main_layout', $data);
        }
    }


    /**
     * removeFromWishlist
     * @access public
     * @param no
     * @return json
     */
    public function removeFromWishlist() {
        $product_id = $this->input->post('product_id');
        $product_id = $this->custom->encrypt_decrypt($product_id, 'decrypt');
        $customer_id = $this->session->userdata('customer_id');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('product_id', $product_id);
        $deleted = $this->db->delete('tbl_wishlist');
        if ($deleted) {
            $response = [
                'status' => 'success',
                'message' => 'Item removed from Wishlist'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to remove item from Wishlist'
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * submitRating
     * @access public
     * @param no
     * @return json
     */
    public function submitRating() {
        $customer_id = $this->session->userdata('customer_id');
        $item_id = $this->input->post('item_id');
        $rating = $this->input->post('rating');
        if (!$customer_id || !$item_id || !$rating) {
            $response = [
                'status' => 'error',
                'message' => 'Invalid request'
            ];
        } else {
            if (!$this->ECommerce_model->hasPurchased($customer_id, $item_id)) {
                $response = [
                    'status' => 'error',
                    'message' => "You can't ratting this product without purchase",
                ];
            } else {
                $success = $this->ECommerce_model->addRating($customer_id, $item_id, $rating);
                if ($success) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Rating submitted successfully'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to submit rating'
                    ];
                }
            }
        }
        echo json_encode($response);
    }

    /**
     * getProductRating
     * @access public
     * @param no
     * @return json
     */
    public function getProductRating($item_id) {
        $this->load->model('Product_model');
        $ratingData = $this->Product_model->getProductRating($item_id);
        echo json_encode($ratingData);
    }

    /**
     * getProductReviews
     * @access public
     * @param no
     * @return json
     */
    public function getProductReviews($item_id) {
        $this->load->model('Product_model');
        $reviews = $this->Product_model->getProductReviews($item_id);
        echo json_encode($reviews);
    }

    /**
     * getFlashSaleDate
     * @access public
     * @param no
     * @return json
     */
    public function getFlashSaleDate() {
        $data = $this->ECommerce_model->getFlashSaleDate();
        if($data){
            $response = [
                'status' => 'success',
                'data' => $data,
            ];	
        }else{
            $response = [
                'status' => 'error',
                'data' => 'No Record Found',
            ];	
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /** ======================= Payment Functionalities Start =======================*/
    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripePayment(){
        $payment_credentials = getFrontendPaymentMethod();
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $this->input->post('amount');
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    /**
     * stripePayment
     * @access public
     * @param no
     * @return json
     */
    public function stripeMainPayment(){
        $payment_credentials = getMainCompanyPaymentMethod();
        $secret = $payment_credentials->stripe_api_key;
        try {
            $amount = $this->input->post('amount');
            if ($amount == 0 || $amount < 0) {
                echo json_encode(['status' => 'error', 'message' => 'Amount is required']);
                return;
            }
            Stripe::setApiKey($secret);
            $response = Charge::create([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $this->input->post('token'),
                "description" => "Sale Payment",
            ]);
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    /** ======================= Account Functionalities Start =======================*/
    /**
     * accountInfo
     * @access public
     * @param no
     * @return void
     */
    public function accountInfo() {
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $customer_id = $this->session->userdata('customer_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name',lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('email', lang('email'), 'required|max_length[50]|min_length[6]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[25]|min_length[6]');
            $this->form_validation->set_rules('address', lang('$customer_id'), 'required|max_length[255]|min_length[3]');
            if ($this->form_validation->run() == TRUE) {
                $data_arr = array();
                $data_arr['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));;
                $data_arr['email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));;
                $data_arr['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));;
                $data_arr['address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));;
                $this->Common_model->updateInformation($data_arr, $customer_id, "tbl_customers");
                $this->session->set_flashdata('exception', "Information updated successfully");
                redirect('e-account-info');
            } else {
                $data = array();
                $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
                $data['main_content'] = $this->load->view('eCommerce/frontend/account_info', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        } else {
            $data = array();
            $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
            $data['main_content'] = $this->load->view('eCommerce/frontend/account_info', $data, TRUE);
            $this->load->view('eCommerce/frontend/main_layout', $data);
        }
    }

        /**
     * register
     * @access public
     * @param int
     * @return void
     */
    public function register(){
        $customer_id = $this->session->userdata('customer_id');
        $customer_email = $this->session->userdata('customer_email');
        $company_id = $this->session->userdata('company_id') ?: 1;
        if($customer_id && $customer_email){
            redirect('e-account');
        } else{
            $data = array();
            if (htmlspecialcharscustom($this->input->post('submit'))) {
                $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
                $this->form_validation->set_rules('phone', lang('phone'), "required|max_length[55]|is_unique[tbl_customers.phone]");
                $this->form_validation->set_rules('address', lang('address'), 'required|max_length[255]');
                $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
                if ($this->form_validation->run() == TRUE) {
                    $name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                    $phone = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                    $address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));
                    $password = $this->input->post($this->security->xss_clean('password'));
                    $confirm_password = $this->input->post($this->security->xss_clean('confirm_password'));

                    $customer_info = $this->ECommerce_model->getCustomerLoginCheck($phone, $password);
                    $customer_phone = $this->ECommerce_model->getCustomerPhone($phone);

                    if(!$customer_phone){
                        if($password == $confirm_password){
                            $data = array();
                            $data['name'] = $name;
                            $data['phone'] = $phone;
                            $data['address'] = $address;
                            $data['password'] = md5($password);
                            $data['opening_balance'] = 0;
                            $data['opening_balance_type'] = 'Debit';
                            $data['credit_limit'] = 0;
                            $data['customer_type'] = 'default';
                            $data['price_type'] = 1;
                            $data['discount'] = 0;
                            $data['user_id'] = 1;
                            $data['company_id'] = $company_id;
                            $data['del_status'] = 'Live';
                            $data['added_date'] = date('Y-m-d H:i:s');
                            $customer_id = $this->Common_model->insertInformation($data, 'tbl_customers');
                            $cust_login_arr = [];
                            $cust_login_arr['customer_id'] = $customer_id;
                            $cust_login_arr['customer_name'] = $name;
                            $cust_login_arr['customer_phone'] = $phone;
                            $cust_login_arr['customer_email'] = '';
                            $this->session->set_userdata($cust_login_arr);
                            $this->session->set_flashdata('exception', "Signup Successfully");
                            if ($this->cart->total_items() > 0) {
                                redirect('e-checkout');
                            }
                            redirect('e-account');
                        }else{
                            $this->session->set_flashdata('exception_error', "Password and Confirm Password doesn't match");
                            $data['main_content'] = $this->load->view('eCommerce/frontend/register', $data, TRUE);
                            $this->load->view('eCommerce/frontend/main_layout', $data);
                        }
                    }else{
                        if($customer_phone && $customer_phone->password == ''){
                            if($password == $confirm_password){
                                $data = array();
                                $data['name'] = $name;
                                $data['address'] = $address;
                                $data['password'] = md5($password);
                                $data['customer_type'] = 'default';
                                $data['price_type'] = 1;
                                $data['discount'] = 0;
                                $data['company_id'] = $company_id;
                                $data['del_status'] = 'Live';
                                $this->Common_model->updateInformation($data, $customer_phone->id, 'tbl_customers');
                                $cust_login_arr = [];
                                $cust_login_arr['customer_id'] = $customer_phone->id;
                                $cust_login_arr['customer_name'] = $name;
                                $cust_login_arr['customer_phone'] = $phone;
                                $cust_login_arr['customer_email'] = isset($customer_phone->email) ? $customer_phone->email : '';
                                $this->session->set_userdata($cust_login_arr);
                                $this->session->set_flashdata('exception', "Signup Successfully");
                                if ($this->cart->total_items() > 0) {
                                    redirect('e-checkout');
                                }
                                redirect('e-account');
                            }else{
                                $this->session->set_flashdata('exception_error', "Password and Confirm Password doesn't match");
                                $data['main_content'] = $this->load->view('eCommerce/frontend/register', $data, TRUE);
                                $this->load->view('eCommerce/frontend/main_layout', $data);
                            }
                        }else{
                            $this->session->set_flashdata('exception_error', "This phone has already an account, please login");
                            redirect('e-login');
                        }
                    }
                }else{
                    $data['main_content'] = $this->load->view('eCommerce/frontend/register', $data, TRUE);
                    $this->load->view('eCommerce/frontend/main_layout', $data);
                }
            } else {
                $data['main_content'] = $this->load->view('eCommerce/frontend/register', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        }
        
    }

    /**
     * login
     * @access public
     * @param int
     * @return void
     */
    public function login(){
        $customer_id = $this->session->userdata('customer_id');
        $customer_phone = $this->session->userdata('customer_phone');
        if($customer_id && $customer_phone){
            redirect('e-account');
        }else{
            $data = array();
            if (htmlspecialcharscustom($this->input->post('submit'))) {
                $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
                $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
                if ($this->form_validation->run() == TRUE) {
                    $phone = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                    $password = md5($this->input->post($this->security->xss_clean('password')));
                    $customer_info = $this->ECommerce_model->getCustomerLoginCheck($phone, $password);
                    $customer_phone = $this->ECommerce_model->getCustomerPhone($phone);
                    if($customer_phone){
                        if($customer_info){
                            $cust_login_arr = [];
                            $cust_login_arr['customer_id'] = $customer_info->id;
                            $cust_login_arr['customer_name'] = $customer_info->name;
                            $cust_login_arr['customer_phone'] = $customer_info->phone;
                            $cust_login_arr['customer_email'] = isset($customer_info->email) ? $customer_info->email : '';
                            $this->session->set_userdata($cust_login_arr);

                            if ($this->cart->total_items() > 0) {
                                redirect('e-checkout');
                            }

                            $next = $this->input->get('next');
                            if (!$next) {
                                $next = $this->input->post('next');
                            }
                            if ($next) {
                                $next_url = urldecode($next);
                                if (strpos($next_url, 'e-checkout') !== false || strpos($next_url, 'e-shopping-cart') !== false) {
                                    redirect($next_url);
                                }
                            }

                            redirect('e-account');
                        }else{
                            $this->session->set_flashdata('exception_error', "Phone or Password doesn't match");
                            redirect('e-login');
                        }
                    }else{
                        $this->session->set_flashdata('exception_error', "This Phone Not Exist");
                        redirect('e-login');
                    }
                }else{
                    $this->session->set_flashdata('exception_error', "Required Data is missing");
                    redirect('e-login');
                }
            } else {
                $data['main_content'] = $this->load->view('eCommerce/frontend/login', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        }
    }

    /**
     * loginCheck
     * @access public
     * @param no
     * @return void
     */
    public function signupCheck() {
        $company_id = $this->session->userdata('company_id') ?: 1;
        $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
        $this->form_validation->set_rules('email', lang('email'), 'required|max_length[50]');
        $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
        if ($this->form_validation->run() == TRUE) {
            $name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
            $email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
            $password = $this->input->post($this->security->xss_clean('password'));
            $confirm_password = $this->input->post($this->security->xss_clean('confirm_password'));
            $customer_info = $this->Authentication_model->getCustomerLoginCheck($email, $password);
            $customer_email = $this->Authentication_model->getCustomerEmail($email);
            if(!$customer_email){
                if($password == $confirm_password){
                    $customer_info['name'] = $name;
                    $customer_info['email'] = $email;
                    $customer_info['password'] = md5($password);
                    $customer_info['opening_balance'] = 0;
                    $customer_info['opening_balance_type'] = 'Debit';
                    $customer_info['credit_limit'] = 0;
                    $customer_info['customer_type'] = 'default';
                    $customer_info['price_type'] = 1;
                    $customer_info['discount'] = 0;
                    $customer_info['user_id'] = 1;
                    $customer_info['company_id'] = $company_id;
                    $customer_info['del_status'] = 'Live';
                    $customer_info['added_date'] = date('Y-m-d H:i:s');
                    $customer_id = $this->Common_model->insertInformation($customer_info, 'tbl_customers');
                    $cust_login_arr = [];
                    $cust_login_arr['customer_id'] = $customer_id;
                    $cust_login_arr['customer_name'] = $name;
                    $cust_login_arr['customer_email'] = $email;
                    $this->session->set_userdata($cust_login_arr);
                    $response = [
                        'status' => 'success',
                        'message' => 'Signup Successfully',
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => 'Password and Confirm Password doesn\'t match',
                    ];
                }
            }else{
                if($customer_email && $customer_email->password ==''){
                    if($password == $confirm_password){
                        $data = array();
                        $data['name'] = $name;
                        $data['password'] = md5($password);
                        $data['customer_type'] = 'default';
                        $data['price_type'] = 1;
                        $data['discount'] = 0;
                        $data['company_id'] = $company_id;
                        $data['del_status'] = 'Live';
                        $this->Common_model->updateInformation($data, $customer_email->id, 'tbl_customers');
                        $cust_login_arr = [];
                        $cust_login_arr['customer_id'] = $customer_email->id;
                        $cust_login_arr['customer_name'] = $name;
                        $cust_login_arr['customer_email'] = $email;
                        $this->session->set_userdata($cust_login_arr);
                        $response = [
                            'status' => 'success',
                            'message' => 'Signup Successfully',
                        ];
                    }else{
                        $response = [
                            'status' => 'error',
                            'message' => 'Password and Confirm Password doesn\'t match',
                        ];
                    }
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => 'This email has already an account, please login',
                    ];
                }
            }
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Required Data is missing',
            ];
        }	
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        
    }

    /**
     * forgotPassword
     * @access public
     * @param no
     * @return void
     */
    public function forgotPassword() {
        $data = array();
        $data['main_content'] = $this->load->view('eCommerce/frontend/forgot_password', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
   
    /**
     * forgotPassword
     * @access public
     * @param no
     * @return void
     */
    public function forgotPasswordSubmit() {
        $this->form_validation->set_rules('email', lang('email'), 'required|max_length[50]');
        if ($this->form_validation->run() == TRUE) {
            $email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
            $customer_email = $this->ECommerce_model->getCustomerEmail($email);
            if ($customer_email) {
                if ($customer_email->email) {
                    $six_digit_password = mt_rand(100000, 999999);
                    $company = getMainCompany();
                    $mail_data = [];
                    $mail_data['to'] = ["$customer_email->email"];
                    $mail_data['subject'] = 'Reset Password';
                    $mail_data['customer_name'] = $customer_email->name; 
                    $mail_data['company_id'] = 1;
                    $mail_data['file_name'] = '';
                    $mail_data['password'] = $six_digit_password;
                    $file_v_path2 = '';
                    $mail_data['file_path'] = '';
                    $mail_data['template'] = $this->load->view('mail-template/password-reset-link', $mail_data, TRUE);
                    if ($company->smtp_enable_status == 1) {
                        $data = array();
                        $data['password'] = md5($six_digit_password);
                        $this->Common_model->updateInformation($data, $customer_email->id, 'tbl_customers');
                        $emailSent = false; // Flag to track email status
                        if ($company->smtp_type == "Sendinblue") {
                            $emailSent = sendInBlue($mail_data); // Ensure `sendInBlue` returns true on success
                        } else {
                            $emailSent = sendEmailOnly(
                                $mail_data['subject'],
                                $mail_data['template'],
                                $customer_email->email,
                                $file_v_path2,
                                $mail_data['file_name'],
                                $company->id
                            ); // Ensure `sendEmailOnly` returns true on success
                        }
                        if ($emailSent) {
                            $this->session->set_flashdata('exception', "Check your email, we've sent a temporary password");
                            redirect('e-login');
                        } else {
                            $this->session->set_flashdata('exception_error', "Failed to send the email. Please check your SMTP configuration.");
                            redirect('e-forgot-password');
                        }
                    } else {
                        $this->session->set_flashdata('exception_error', "SMTP is not configured");
                        redirect('e-forgot-password');
                    }
                }
            } else {
                $this->session->set_flashdata('exception_error', "This Email Not Exist");
                redirect('e-forgot-password');
            }
        } else {
            $this->session->set_flashdata('exception_error', "Required Data is missing");
            redirect('e-forgot-password');
        }
    }
    /**
     * changePassword
     * @access public
     * @param no
     * @return void
     */
    public function changePassword() {
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('old_password',lang('old_password'), 'required|max_length[50]');
            $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
            if ($this->form_validation->run() == TRUE) {
                $old_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_password')));
                $customer_id = $this->session->userdata('customer_id');
                $password_check = $this->ECommerce_model->passwordCheckForCustomer(md5($old_password), $customer_id);
                if ($password_check) {
                    $new_password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_password')));
                    $this->ECommerce_model->updateCustomerPassword(md5($new_password), $customer_id);
                    $this->session->set_flashdata('exception', "Password Changed Successfully");
                    redirect('e-change-password');
                } else {
                    $this->session->set_flashdata('exception_error', "Current Password and given password doesn't match");
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/frontend/change_password', $data, TRUE);
                    $this->load->view('eCommerce/frontend/main_layout', $data);
                }
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/frontend/change_password', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('eCommerce/frontend/change_password', $data, TRUE);
            $this->load->view('eCommerce/frontend/main_layout', $data);
        }
    }
    /**
     * manageAddress
     * @access public
     * @param no
     * @return void
     */
    public function manageAddress() {
        if(!$this->session->has_userdata('customer_id')){
            redirect('e-login');
        }
        $customer_id = $this->session->userdata('customer_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('shipping_address',lang('shipping_address'), 'required|max_length[250]');
            $this->form_validation->set_rules('billing_address',lang('billing_address'), 'required|max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $data_arr = array();
                $data_arr['shipping_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('shipping_address')));;
                $data_arr['billing_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('billing_address')));;
                $this->Common_model->updateInformation($data_arr, $customer_id, "tbl_customers");
                $this->session->set_flashdata('exception', "Information updated successfully");
                redirect('e-account');
            } else {
                $this->session->set_flashdata('exception_error', "Required data is missing");
                $data = array();
                $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
                $data['main_content'] = $this->load->view('eCommerce/frontend/manage_address', $data, TRUE);
                $this->load->view('eCommerce/frontend/main_layout', $data);
            }
        } else {
            $data = array();
            $data['customer_info'] = $this->ECommerce_model->getDataById($customer_id, "tbl_customers");
            $data['main_content'] = $this->load->view('eCommerce/frontend/manage_address', $data, TRUE);
            $this->load->view('eCommerce/frontend/main_layout', $data);
        }
    }

    /**
     * logout
     * @access public
     * @param no
     * @return void
     */
    public function logout() {
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('customer_name');
        $this->session->unset_userdata('customer_email');
        $this->session->set_flashdata('exception', "Logout Success");
        redirect('e-login');
    }
        /** ======================= Account Functionalities End =======================*/

    /** ======================= Seperated This Function from Other Function =======================*/

    /**
     * getByBrand
     * @access public
     * @param int
     * @return void
     */
    public function getByBrand($encrypt_brand_id = ''){
        $brand_id = $this->custom->encrypt_decrypt($encrypt_brand_id, 'decrypt');
        $data = array();
        $data['url_name'] = $this->uri->segment(1);
        $data['brand_id'] = $brand_id;
        $data['brand_name'] = getBrand($brand_id);
        $data['brands'] = $this->ECommerce_model->getAllBrands();
        $data['categories'] = $this->ECommerce_model->getAllCategories();
        $data['main_content'] = $this->load->view('eCommerce/frontend/product_by_brand', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * getByCategory
     * @access public
     * @param int
     * @return void
     */
    public function getByCategory($category_id = ''){
        $category_id = $this->custom->encrypt_decrypt($category_id, 'decrypt');
        $data = array();
        $data['url_name'] = $this->uri->segment(1);
        $data['category_id'] = $category_id;
        $data['category_name'] = getCategoryName($category_id);
        $data['brands'] = $this->ECommerce_model->getAllBrands();
        $data['categories'] = $this->ECommerce_model->getAllCategories();
        $data['main_content'] = $this->load->view('eCommerce/frontend/product_by_category', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }
    /**
     * filterProducts
     * @access public
     * @param no
     * @return json
     */
    public function filterProducts() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $per_page = 9;
        $offset = ($page - 1) * $per_page;
        $category_ids = $this->input->get('categories');
        $brand_ids = $this->input->get('brands');
        $price_range = $this->input->get('price_range');
        $sorting = $this->input->get('sorting');
        $type = $this->input->get('type'); // 'brand' or 'category'
        $main_id = $this->input->get('main_id');

        $products = $this->ECommerce_model->filterProducts($type, $main_id, $category_ids, $brand_ids, $price_range, $sorting, $per_page, $offset);
        $total_rows = $this->ECommerce_model->filterProductsCount($type, $main_id, $category_ids, $brand_ids, $price_range);
        
        $data['products'] = $products;
        $products_html = $this->load->view('eCommerce/frontend/products_grid', $data, true);
        // Generate pagination
        $pagination = $this->_renderPagination($page, ceil($total_rows / $per_page));
        $response = [
            'products_html' => $products_html,
            'pagination' => $pagination,
            'total_products' => $total_rows
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }





        /**
     * getProductByType
     * @access public
     * @param int
     * @return void
     */
    // public function getProductByType($type = '') {
    //     $data = array();
    //     $page = $this->input->get('page') ? $this->input->get('page') : 1;
    //     $per_page = 3; 
    //     $category_ids = $this->input->get('categories');
    //     $brand_ids = $this->input->get('brands');
    //     $price_range = $this->input->get('price_range');
    //     $offset = ($page - 1) * $per_page;
    //     if($type == 'top-rated'){
    //         $data['products'] = $this->ECommerce_model->getTopRatedProducts('All', $per_page, $offset, $category_ids, $brand_ids, $price_range);
    //         $total_rows = $this->ECommerce_model->getTopRatedProductsCount($category_ids, $brand_ids, $price_range);
    //     }else if($type == 'best-selling'){
    //         $data['products'] = $this->ECommerce_model->getMostSoldProducts('All', $per_page, $offset, $category_ids, $brand_ids, $price_range);
    //         $total_rows = $this->ECommerce_model->getMostSoldProductsCount($category_ids, $brand_ids, $price_range);
    //     }else if($type == 'latest-selling'){
    //         $data['products'] = $this->ECommerce_model->getLatestSaleProducts('All', $per_page, $offset, $category_ids, $brand_ids, $price_range);
    //         $total_rows = $this->ECommerce_model->getLatestSaleProductsCount($category_ids, $brand_ids, $price_range);
    //     }
    //     $data['brands'] = $this->ECommerce_model->getAllBrands();
    //     $data['categories'] = $this->ECommerce_model->getAllCategories();
    //     if($this->input->is_ajax_request()) {
    //         $products_html = $this->load->view('eCommerce/frontend/products_grid', $data, true);
    //         $links = $this->_generate_pagination($total_rows, $per_page, $page);
    //         $response = [
    //             'products_html' => $products_html,
    //             'links' => $links,
    //             'total_products' => $total_rows
    //         ];
    //         $this->output->set_content_type('application/json')->set_output(json_encode($response));
    //         return;
    //     }
    //     $data['item_html'] = $this->load->view('eCommerce/frontend/products_grid', $data, true);
    //     $data['links'] = $this->_generate_pagination($total_rows, $per_page, $page);
    //     $data['main_content'] = $this->load->view('eCommerce/frontend/type_by_product', $data, TRUE);
    //     $this->load->view('eCommerce/frontend/main_layout', $data);
    // }

    // private function _generate_pagination($total_rows, $per_page, $current_page) {
    //     $total_pages = ceil($total_rows / $per_page);
    //     $pagination = '';
    //     if($total_pages > 1) {
    //         $pagination .= '<div class="pagination_wrp d-flex align-items-center justify-content-center mt-4">';
    //         if($current_page > 1) {
    //             $pagination .= '<div class="single_paginat" data-page="'.($current_page-1).'"><i class="las la-long-arrow-alt-left"></i></div>';
    //         }
    //         for($i = 1; $i <= $total_pages; $i++) {
    //             if($i == $current_page) {
    //                 $pagination .= '<div class="single_paginat active">'.$i.'</div>';
    //             } else {
    //                 $pagination .= '<div class="single_paginat" data-page="'.$i.'">'.$i.'</div>';
    //             }
    //         }
    //         if($current_page < $total_pages) {
    //             $pagination .= '<div class="single_paginat" data-page="'.($current_page+1).'"><i class="las la-long-arrow-alt-right"></i></div>';
    //         }
    //         $pagination .= '</div>';
    //     }
    //     return $pagination;
    // }

    public function getProductByType($type = '') {
        $data = array();
        $data['url_name'] = $this->uri->segment(2);
        $data['brands'] = $this->ECommerce_model->getAllBrands();
        $data['categories'] = $this->ECommerce_model->getAllCategories();
        $data['main_content'] = $this->load->view('eCommerce/frontend/type_by_product', $data, TRUE);
        $this->load->view('eCommerce/frontend/main_layout', $data);
    }

    public function filterProductsByType() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $per_page = 9;
        $offset = ($page - 1) * $per_page;
        $category_ids = $this->input->get('categories');
        $brand_ids = $this->input->get('brands');
        $price_range = $this->input->get('price_range');
        $sorting = $this->input->get('sorting');
        $type = $this->input->get('type'); // 'latest-selling' or 'best-selling' or 'top-rated'

        $products = $this->ECommerce_model->filterProductsByType($type, $category_ids, $brand_ids, $price_range, $sorting, $per_page, $offset);
        $total_rows = $this->ECommerce_model->filterProductsCountByType($type, $category_ids, $brand_ids, $price_range);
        
        $data['products'] = $products;
        $products_html = $this->load->view('eCommerce/frontend/products_grid', $data, true);
        // Generate pagination
        $pagination = $this->_renderPagination($page, ceil($total_rows / $per_page));
        $response = [
            'products_html' => $products_html,
            'pagination' => $pagination,
            'total_products' => $total_rows
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Render pagination HTML with ellipsis for large page sets.
     */
    private function _renderPagination($current_page, $total_pages) {
        if($total_pages <= 1) {
            return '';
        }
        $prev_disabled = $current_page <= 1;
        $next_disabled = $current_page >= $total_pages;
        $prev_page = max(1, $current_page - 1);
        $next_page = min($total_pages, $current_page + 1);

        $html = '<div class="pagination_wrp pagination_new mt-4">';
        $html .= '<button type="button" class="pagination_arrow prev'.($prev_disabled ? ' disabled' : '').'"'.($prev_disabled ? '' : ' data-page="'.$prev_page.'"').' aria-label="Previous page"><i class="las la-chevron-left"></i></button>';
        $html .= '<div class="pagination_numbers">';
        $pages = $this->_getPaginationRange($current_page, $total_pages);
        foreach($pages as $page) {
            if($page === '...') {
                $html .= '<span class="pagination_dots">...</span>';
                continue;
            }
            if((int)$page === (int)$current_page) {
                $html .= '<span class="single_paginat active">'.$page.'</span>';
            } else {
                $html .= '<span class="single_paginat" data-page="'.$page.'">'.$page.'</span>';
            }
        }
        $html .= '</div>';
        $html .= '<button type="button" class="pagination_arrow next'.($next_disabled ? ' disabled' : '').'"'.($next_disabled ? '' : ' data-page="'.$next_page.'"').' aria-label="Next page"><i class="las la-chevron-right"></i></button>';
        $html .= '<div class="pagination_goto">';
        $html .= '<label>'.lang('go_to_page').'</label>';
        $html .= '<div class="pagination_goto_input">';
        $html .= '<input type="number" min="1" max="'.$total_pages.'" value="'.$current_page.'">';
        $html .= '<button type="button" class="goto_button" data-total="'.$total_pages.'">'.lang('go').'</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Determine pagination ranges with ellipsis.
     */
    private function _getPaginationRange($current_page, $total_pages) {
        $pages = [];
        $pages[] = 1;
        $start = max(2, $current_page - 2);
        $end = min($total_pages - 1, $current_page + 2);
        if($start > 2) {
            $pages[] = '...';
        }
        if($start <= $end) {
            for($i = $start; $i <= $end; $i++) {
                $pages[] = $i;
            }
        }
        if($end < $total_pages - 1) {
            $pages[] = '...';
        }
        if($total_pages > 1) {
            $pages[] = $total_pages;
        }
        return $pages;
    }
}
