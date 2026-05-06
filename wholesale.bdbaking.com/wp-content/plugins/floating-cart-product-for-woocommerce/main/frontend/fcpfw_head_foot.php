<?php

function SCFW_cart_create() {

    WC()->cart->calculate_totals();

    WC()->cart->maybe_set_cart_cookies();

    global $woocommerce,$fcpfw_comman, $ocwqv_qfcpfw_icon;

    $fcpfw_sidecart_width = $fcpfw_comman['fcpfw_sidecart_width'].'px';

    ?>
    <div class="fcpfw_container" >
        <div class="fcpfw_header">
            <div class="top_fcpfw_herder">
              <?php fcpfw_header_cart_icons();?>
            </div>
            <?php if ($fcpfw_comman['fcpfw_freeshiping_herder'] == "yes" ){ ?>
                <div class="top_fcpfw_bottom">
                    <?php 
                        $wg_prodrule_mtvtion_msg = $fcpfw_comman['fcpfw_freeshiping_herder_txt'];
                        $fcpfw_shipping_total = $woocommerce->cart->get_cart_shipping_total();
                        $wg_prodrule_mtvtion_msg_final = str_replace("{shipping_total}", $fcpfw_shipping_total, $wg_prodrule_mtvtion_msg);
                    ?>
                    <p style="color:<?php echo  esc_attr($fcpfw_comman['fcpfw_header_shipping_text_color']); ?>"><?php echo esc_attr($wg_prodrule_mtvtion_msg_final); ?></p>
                </div>
            <?php } ?>
        </div>
        
        <?php
        echo SCFW_comman();
        ?>
        
        <?php
        $showCouponField = 'true';
        if(wp_is_mobile()) {
            if($fcpfw_comman['fcpfw_coupon_field_mobile'] == 'no') {
                $showCouponField = 'false';
            }
        }

        if($showCouponField == 'true') {
            ?>
            <div class="fcpfw_trcpn">
                <div class='fcpfw_total_tr'>
                    <div class='fcpfw_total_label'>
                        <span><?php echo esc_attr($fcpfw_comman['fcpfw_subtotal_txt']); ?></span>
                    </div>

                    <?php
                        $item_taxs = $woocommerce->cart->get_cart();
                        $fcpfw_get_totals = WC()->cart->get_totals();
                        $fcpfw_shipping_total = $woocommerce->cart->get_cart_shipping_total();
                        $fcpfw_cart_total = $fcpfw_get_totals['subtotal'];
                        $fcpfw_cart_discount = $fcpfw_get_totals['discount_total'];
                        $fcpfw_final_subtotal = $fcpfw_cart_total - $fcpfw_cart_discount;
                    ?>

                    <div class='fcpfw_total_amount'>
                        <span class='fcpfw_fragtotal'><?php echo get_woocommerce_currency_symbol().number_format($fcpfw_final_subtotal, 2); ?></span>
                    </div>
                    <?php if ($fcpfw_comman['fcpfw_total_shipping_option']== "yes" ) { ?>
                        <div class='fcpfw_total_label'>
                            <span><?php echo esc_attr($fcpfw_comman['fcpfw_shipping_text_trans']); ?></span>
                        </div>
                        <div class='fcpfw_total_amountt'>
                            <span class='fcpfw_fragtotall'><?php echo esc_attr($fcpfw_shipping_total); ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($fcpfw_comman['fcpfw_total_tax_option'] == "yes" ) { ?>
                        <div class="fcpfw_total_label">
                            <span><?php echo esc_attr($fcpfw_comman['fcpfw_apply_taxt_testx']); ?></span>
                        </div>
                        <div class="fcpfw_total_innwer">
                            <span class='fcpfw_fragtotall'> 
                                <?php $iteeem = WC()->cart->get_tax_totals(); ?>
                                <?php foreach ($iteeem as $iteeem_tac ) {
                                    //print_R($iteeem_tac->amount);
                                    echo get_woocommerce_currency_symbol().number_format($iteeem_tac->amount, 2); 
                                } ?>
                            </span>
                        </div> 
                    <?php } ?>
                    <?php  if ($fcpfw_comman['fcpfw_total_all_option'] == "yes" ) { ?>
                        <div class="fcpfw_oc_total_oc">
                           <?php fcpfw_total_label();?>
                        </div>
                    <?php } ?>
                </div>
                <div class='fcpfw_coupon'>
                   <?php fcpfw_coupon(); ?>
                </div>
            </div>
            <?php
        } ?>

        <?php
        $showSlider = 'true';
        if(wp_is_mobile()) {
            if($fcpfw_comman['fcpfw_prodslider_mobile'] == 'yes') {
                // $showSlider = 'false';
                ?>
                <div class="fcpfw_slider">
                    <?php fcpfw_prodslider_mobile();?>
                </div>
            <?php }
        }

        if ($showSlider == 'true') {
            $productsa = get_option('fcpfw_select2');
            if(!empty($productsa)) {
                if($fcpfw_comman['fcpfw_prodslider_desktop'] == 'yes') { 
                    ?>
                    <div class="fcpfw_slider desktop_oc">
                        <?php fcpfw_prodslider_desktop();?>
                    </div>
                    <?php 
                } 
                // </div>
            }
        }
        ?>

        <div class="fcpfw_footer">
            <?php fcpfw_cart_footer();?>
        </div>
    </div>

    <div class="fcpfw_container_overlay">
    </div>

    <?php if($fcpfw_comman['fcpfw_show_cart_icn'] == "yes") { ?>
        <div class="fcpfw_cart_basket">
            <?php fcpfw_cart_basket_icon(); ?>
        </div>
        <?php
    }
}

add_action('wp_head','FCPFW_craete_cart');
function SCFW_craete_cart(){
    global $fcpfw_comman,$ocwqv_qfcpfw_icon;
    ?>
    
    <?php
    $wcf_page_ids = explode(",", $fcpfw_comman[ 'fcpfw_on_pages']);
    $wcf_crnt_page = get_the_ID();
    if (!in_array($wcf_crnt_page, $wcf_page_ids)) {
        if(wp_is_mobile() ){
            if($fcpfw_comman[ 'fcpfw_mobile'] == "yes") {
                if(is_checkout() || is_cart()){
                    if($fcpfw_comman[ 'fcpfw_cart_check_page'] == "yes") {
                        add_filter( 'wp_footer','SCFW_cart_create');
                    }
                } else {
                    add_filter( 'wp_footer','SCFW_cart_create');
                }
            }
        } else {
            if(is_checkout() || is_cart()){
                if($fcpfw_comman[ 'fcpfw_cart_check_page']== "yes") {
                    add_filter( 'wp_footer','SCFW_cart_create');
                }
            } else {
                add_filter( 'wp_footer','SCFW_cart_create');
            }
        }
    }
}

add_action( 'wp_footer','FCPFW_single_added_to_cart_event');
function SCFW_single_added_to_cart_event(){
    global $fcpfw_comman;
    if( isset($_POST['add-to-cart']) && isset($_POST['quantity']) ) { ?>
        <script>
            jQuery(function($){
                // jQuery('.fcpfw_cart_basket').click();
                fcpfw_opencart();
            });
        </script>
        <?php
    }

    ?>
    <?php $fcpfw_sidecart_width = $fcpfw_comman['fcpfw_sidecart_width'].'px'; ?>
    <div class="fcpfw_coupon_response" style="left: calc(100% - <?php echo esc_attr($fcpfw_sidecart_width) ; ?>);">
        <div class="fcpfw_inner_div" style="width: <?php echo esc_attr($fcpfw_sidecart_width ); ?>;">
            <span id="fcpfw_cpn_resp" style="width: <?php echo esc_attr($fcpfw_sidecart_width) ; ?>;"></span>
        </div>
    </div>
    <?php
}
