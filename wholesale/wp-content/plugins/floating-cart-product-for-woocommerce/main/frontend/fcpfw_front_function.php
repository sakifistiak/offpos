<?php

function fcpfw_slider_button_product() {
    global $fcpfw_comman;

    $display_type = $fcpfw_comman['fcpfw_select_recent_related'];

    if ($display_type === 'recent') {
        $productsa = get_option('fcpfw_select2');

        if (!empty($productsa)) {
            $cart_product_ids = wp_list_pluck(WC()->cart->get_cart(), 'product_id');

            foreach ($productsa as $value) {
                if (!in_array($value, $cart_product_ids)) {
                    $productc = wc_get_product($value);
                    fcpfw_render_product_block($productc, $value, $fcpfw_comman);
                }
            }
        }

    } elseif ($display_type === 'related') {
        $related_ids = [];

        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['product_id'];
            $related = wc_get_related_products($product_id, 4);
            $related_ids = array_merge($related_ids, $related);
        }

        $cart_product_ids = wp_list_pluck(WC()->cart->get_cart(), 'product_id');
        $related_ids = array_unique(array_diff($related_ids, $cart_product_ids));

        foreach ($related_ids as $value) {
            $productc = wc_get_product($value);
            fcpfw_render_product_block($productc, $value, $fcpfw_comman);
        }
    }
}

function fcpfw_render_product_block($productc, $value, $fcpfw_comman) {
    if ( !empty($productc) && $productc->is_in_stock() ) {
        $title = $productc->get_name();
        $price = $productc->get_price();
        ?>
        <div class="item fcpfw_gift_product">
            <div class="inner_mainf">
                <a href="<?php echo get_permalink($productc->get_id()); ?>">
                    <div class="fcpfw_left_div"><?php echo $productc->get_image(); ?></div>
                    <div class="fcpfw_right_div">
                        <h3 style="color: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>; font-size: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_size']); ?>px;">
                            <?php echo esc_html($title); ?>
                        </h3>
                        <span style="color: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>; font-size: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_size']); ?>px;">
                            <?php echo wc_price($price); ?>
                        </span>

                        <?php
                            if ($productc->get_type() === 'simple') {
                                echo "<a href='?add-to-cart=" . esc_html($value) . "' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='" . esc_html($value) . "' style='background-color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_clr']) . "; color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_txt_clr']) . ";'>" . esc_html($fcpfw_comman['fcpfw_slider_atcbtn_txt']) . "</a>";
                            } elseif ($productc->get_type() === 'variable') {
                                echo "<a href='" . esc_url(get_permalink($value)) . "' data-quantity='1' class='fcpfw_pslide_prodpage' data-product_id='" . esc_html($value) . "' style='background-color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_clr']) . "; color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_txt_clr']) . ";'>" . esc_html($fcpfw_comman['fcpfw_slider_vwoptbtn_txt']) . "</a>";
                            } elseif ($productc->get_type() === 'variation') {
                                $prod_id = $productc->get_parent_id();
                                echo "<a href='?add-to-cart=" . esc_html($value) . "' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='" . esc_html($prod_id) . "' variation-id='" . esc_html($value) . "' style='background-color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_clr']) . "; color: " . esc_html($fcpfw_comman['fcpfw_ft_btn_txt_clr']) . ";'>" . esc_html($fcpfw_comman['fcpfw_slider_atcbtn_txt']) . "</a>";
                            }
                        ?>
                    </div>
                </a>
            </div>
        </div>
        <?php
    }
}

 
//removing product when its out of stock.
add_action('woocommerce_cart_loaded_from_session', 'remove_out_of_stock_items_from_cart');
function remove_out_of_stock_items_from_cart($cart) {
    // Get the plugin setting
    $remove_out_of_stock = get_option('fcpfw_product_out_of_stock');

    // Only proceed if the setting is 'yes'
    if ($remove_out_of_stock === 'yes') {
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            if (!$product->is_in_stock()) {
                $cart->remove_cart_item($cart_item_key);
            }
        }
    }
}

//cart header icons
function fcpfw_header_cart_icons(){
    global $fcpfw_comman,$ocwqv_qfcpfw_icon;
  
    if($fcpfw_comman['fcpfw_header_cart_icon']=='yes'){
        ?>
        <span class="fcpfw_cart_icon">
            <?php
                if($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_2"){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_2']));
                }elseif($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_3"){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_3']));
                }elseif($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_4"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_4']));
                }elseif($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_5"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_5']));
                }elseif($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_6"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_6']));
                }else{
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_1']));
                }
                ?>
        </span>
        <?php
    } ?>

    <h3 class="fcpfw_header_title"><?php echo esc_html($fcpfw_comman['fcpfw_head_title']); ?></h3>
    <?php 
    if($fcpfw_comman['fcpfw_header_close_icon']=='yes'){ 
        ?>
        <span class="fcpfw_close_cart">
            <?php
                if($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_1"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon_1']));
                }elseif($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_2"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon_2']));
                }elseif($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_3"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon_3']));
                }elseif($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_4"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon_4']));
                }elseif($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_5"){
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon_5']));
                }else{
                    echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['close_icon']));
                }
                ?>
        </span>
        <?php 
    }

}

//cart Footer 
function fcpfw_cart_footer(){
    global $fcpfw_comman;
    ?>
    <div class="fcpfw_ship_txt" style="color: <?php echo esc_attr($fcpfw_comman['fcpfw_ship_ft_clr']) ?>; font-size: <?php echo esc_attr($fcpfw_comman[ 'fcpfw_ship_ft_size'])."px" ?>;">
        <?php echo esc_attr($fcpfw_comman['fcpfw_ship_txt']); ?>
    </div>
    <?php

    ?>
    <div class="fcpfw_button_fort fcpfw_dyamic_<?php echo esc_attr($fcpfw_comman['fcpfw_footer_button_row']); ?>">
        <?php if($fcpfw_comman['fcpfw_cart_option']== "yes") { ?>
            <a class="fcpfw_bn_1"
                href="<?php if(!empty($fcpfw_comman['fcpfw_orgcart_link'])){echo $fcpfw_comman['fcpfw_orgcart_link']; }else{  echo wc_get_cart_url(); }?>"
                style="background-color: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_clr']) ?>;margin: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_mrgin'])."px" ?>;color: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_txt_clr']) ?>;">
                <?php echo esc_attr($fcpfw_comman['fcpfw_cart_txt']); ?>
            </a>
        <?php } ?>
        <?php  if($fcpfw_comman['fcpfw_checkout_option'] == "yes"){ ?>
            <a class="fcpfw_bn_2"
                href="<?php if(!empty($fcpfw_comman['fcpfw_orgcheckout_link'])){echo $fcpfw_comman['fcpfw_orgcheckout_link'];}else{echo wc_get_checkout_url();} ?>"
                style="background-color: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_clr']); ?>;margin: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_mrgin'])."px" ?>;color: <?php echo esc_attr($fcpfw_comman[ 'fcpfw_ft_btn_txt_clr']) ?>;">
                <?php echo esc_attr($fcpfw_comman['fcpfw_checkout_txt']); ?>
            </a>
        <?php } ?>
        <?php  if($fcpfw_comman['fcpfw_conshipping_option'] == "yes"){ ?>
            <a class="fcpfw_bn_3" href="<?php echo esc_attr($fcpfw_comman['fcpfw_conshipping_link']); ?>"
                style="background-color: <?php echo esc_attr($fcpfw_comman[ 'fcpfw_ft_btn_clr']); ?>;margin: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_mrgin'])."px" ?>;color: <?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_txt_clr']) ?>;">
                <?php echo esc_attr($fcpfw_comman['fcpfw_conshipping_txt']); ?>
            </a>
        <?php } ?>
    </div>
    <?php
}

function fcpfw_coupon(){
    global $fcpfw_comman, $ocwqv_qfcpfw_icon;
    ?>
    <div class='fcpfw_apply_coupon_link' style="color: <?php echo esc_html($fcpfw_comman['fcpfw_apply_cpn_ft_clr']); ?>">
        <a href='#' id='fcpfw_apply_coupon'>
            <?php 
                if($fcpfw_comman['fcpfw_coupon_icon']== 'coupon_1'){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon_1'])); 
                }elseif($fcpfw_comman['fcpfw_coupon_icon']== 'coupon_2'){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon_2'])); 
                }elseif($fcpfw_comman['fcpfw_coupon_icon']== 'coupon_3'){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon_3'])); 
                }elseif($fcpfw_comman['fcpfw_coupon_icon']== 'coupon_4'){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon_4'])); 
                }elseif($fcpfw_comman['fcpfw_coupon_icon']== 'coupon_5'){
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon_5'])); 
                }else{
                    echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['coupon'])); 
                }
                   
                echo esc_html($fcpfw_comman['fcpfw_apply_cpn_txt']); 
            ?>
        </a>
    </div>

    <div class="fcpfw_coupon_field">
        <input type="text" id="fcpfw_coupon_code" placeholder="<?php echo esc_html($fcpfw_comman['fcpfw_apply_cpn_plchldr_txt']); ?>">
        <span class="fcpfw_coupon_submit" style="background-color: <?php echo esc_html($fcpfw_comman[ 'fcpfw_applybtn_cpn_bg_clr']); ?>; color: <?php echo esc_html($fcpfw_comman['fcpfw_applybtn_cpn_ft_clr']); ?>;">
            <?php echo esc_html($fcpfw_comman['fcpfw_apply_cpn_apbtn_txt']); ?>
        </span>
    </div>

    <?php
    $applied_coupons = WC()->cart->get_applied_coupons();
    if(!empty($applied_coupons)) {
        ?>
        <ul class='fcpfw_applied_cpns'>
            <?php foreach($applied_coupons as $cpns ) { ?>
                <li class='fcpfw_remove_cpn' cpcode='<?php echo esc_html($cpns); ?>'>
                    <?php echo esc_html($cpns); ?>
                    <span class='dashicons dashicons-no'></span>
                </li>
            <?php } ?>
        </ul>
        <?php 
    }
}

//show slider on mobile
function fcpfw_prodslider_mobile(){
    global $fcpfw_comman;
    $productsa = get_option('fcpfw_select2');
    ?>
    <div class="fcpfw_slider_inn owl-carousel owl-theme">
        <?php foreach ($productsa as $value) {
            $productc = wc_get_product( $value );
            if ($productc && is_a($productc, 'WC_Product')) {
                $title = $productc->get_name();
                $price = $productc->get_price();
                $cart_product_ids = array();
                foreach( WC()->cart->get_cart() as $cart_item ){
                    // compatibility with WC +3
                    if( version_compare( WC_VERSION, '3.0', '<' ) ) {
                        $cart_product_ids[] = $cart_item['data']->id; // Before version 3.0
                    } else {
                        $cart_product_ids[] = $cart_item['data']->get_id(); // For version 3 or more
                    }
                }

                if (!in_array($value, $cart_product_ids)) {
                    ?>
                    <div class="item fcpfw_gift_product">
                        <a href="<?php echo esc_url(get_permalink( $productc->get_id() )); ?>">
                            <div class="fcpfw_left_div">
                                <?php echo $productc->get_image();// phpcs:ignore WordPress.Security.EscapeOutput ?> 
                            </div>
                            <div class="fcpfw_right_div">
                                <h3 style="color: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>;font-size: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_size']); ?>px;">
                                    <?php echo esc_html($title); ?> 
                                </h3>
                                <span style="color: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>;font-size: <?php echo esc_html($fcpfw_comman[ 'fcpfw_sld_product_ft_size']); ?>px;">
                                    <?php echo wc_price($price); ?>
                                </span>

                                <?php
                                    if ($productc->get_type() == 'simple') {
                                        echo "<a href='?add-to-cart=".esc_html($value)."' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman['fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_txt_clr']).";'>".esc_html($fcpfw_comman[ 'fcpfw_slider_vwoptbtn_txt'])."</a>";
                                    } elseif ($productc->get_type() == 'variable' ) {
                                        echo "<a href='".esc_url(get_permalink($value))."' data-quantity='1' class='fcpfw_pslide_prodpage' data-product_id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_txt_clr']).";'>".esc_html($fcpfw_comman[ 'fcpfw_slider_vwoptbtn_txt'])."</a>";
                                    } elseif ($productc->get_type() == 'variation') {
                                        $prod_id = $productc->get_parent_id();
                                        echo "<a href='?add-to-cart=".esc_html($value)."' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='".esc_html($prod_id)."' variation-id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman['fcpfw_ft_btn_txt_clr' ]).";'>".esc_html($fcpfw_comman['fcpfw_slider_vwoptbtn_txt'])."</a>";
                                    }
                                ?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
        } ?>
    </div>
    <?php
}


function fcpfw_cart_basket_icon(){
    global $fcpfw_comman,$ocwqv_qfcpfw_icon;
    ?>
    <div class="cart_box">
        <?php if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_1'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_1'])); ?>

        <?php }else if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_2'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_2'])); ?>

        <?php }else if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_3'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_3'])); ?>

        <?php }else if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_4'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_4'])); ?>

        <?php }else if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_5'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_5'])); ?>

        <?php }else if($fcpfw_comman['ocwqv_fcpfw_icon'] == 'ocwqv_fcpfw_icon_6'){ ?>

        <?php echo  html_entity_decode(esc_html($ocwqv_qfcpfw_icon['shop_icon_4'])); ?>

        <?php }else{ ?>

        <?php echo html_entity_decode(esc_html($ocwqv_qfcpfw_icon['ocwqv_qfcpfw_icon'])); ?>

        <?php } ?>
    </div>
    <?php if($fcpfw_comman['fcpfw_product_cnt'] == "yes"){ ?>
        <div class="fcpfw_item_count">
            <?php echo FCPFW_counter_value(); ?>
        </div>
    <?php } 
}


function fcpfw_total_label(){
    global $fcpfw_comman;
    ?>
    <div class="fcpfw_total_label">
        <span><?php echo esc_html($fcpfw_comman['fcpfw_apply_total_text']); ?></span>
    </div>
    <div class="fcpfw_total_innwer_full">
        <span class='fcpfw_fragtotall_full'>
            <?php echo get_woocommerce_currency_symbol().number_format(WC()->cart->total, 2); ?>
        </span>
    </div>
    <?php 
}

function fcpfw_prodslider_desktop(){
    global $fcpfw_comman;
    $productsa = get_option('fcpfw_select2');
    ?>
    <div class="fcpfw_slider_inn  owl-carousel owl-theme ">
        <?php 
            foreach ($productsa as $value) {
                $productc = wc_get_product( $value );
                if ($productc && is_a($productc, 'WC_Product')) {
                    $title = $productc->get_name();
                    $price = $productc->get_price();
                    $cart_product_ids = array();
                    if(!empty($productc)){
                       foreach( WC()->cart->get_cart() as $cart_item ){
                            // compatibility with WC +3
                           if( version_compare( WC_VERSION, '3.0', '<' ) ) {
                                $cart_product_ids[] = $cart_item['data']->id; // Before version 3.0
                            } else {
                                $cart_product_ids[] = $cart_item['data']->get_id(); // For version 3 or more
                            }
                        }

                        if (!in_array($value, $cart_product_ids)) { 
                            ?>
                            <div class="item fcpfw_gift_product">
                                <div class="inner_mainf">
                                    <a href="<?php echo esc_url(get_permalink( $productc->get_id() )); ?>">
                                        <div class="fcpfw_left_div">
                                            <?php echo $productc->get_image(); // phpcs:ignore WordPress.Security.EscapeOutput ?> 
                                        </div>
                                        <div class="fcpfw_right_div">
                                            <h3 style="color: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>; font-size: <?php echo esc_html($fcpfw_comman['fcpfw_sld_product_ft_size']); ?>px;">
                                                <?php echo esc_html($title); ?> 
                                            </h3>
                                            <span style="color: <?php echo esc_html($fcpfw_comman[ 'fcpfw_sld_product_ft_clr']); ?>; font-size: <?php echo esc_html($fcpfw_comman[ 'fcpfw_sld_product_ft_size']); ?>px;"><?php echo wc_price($price); ?></span>

                                            <?php
                                                if ($productc->get_type() == 'simple') {
                                                    echo "<a href='?add-to-cart=".esc_html($value)."' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman['fcpfw_ft_btn_txt_clr']).";'>".esc_html($fcpfw_comman[ 'fcpfw_slider_vwoptbtn_txt'])."</a>";
                                                } elseif ($productc->get_type() == 'variable' ) {
                                                    echo "<a href='".esc_url(get_permalink($value))."' data-quantity='1' class='fcpfw_pslide_prodpage' data-product_id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_txt_clr']).";'>".esc_html($fcpfw_comman['fcpfw_slider_vwoptbtn_txt'])."</a>";
                                                } elseif ($productc->get_type() == 'variation') {
                                                    $prod_id = $productc->get_parent_id();
                                                    echo "<a href='?add-to-cart=".esc_html($value)."' data-quantity='1' class='fcpfw_pslide_atc' data-product_id='".esc_html($prod_id)."' variation-id='".esc_html($value)."' style='background-color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_clr'])."; color: ".esc_html($fcpfw_comman[ 'fcpfw_ft_btn_txt_clr']).";'>".esc_html($fcpfw_comman[ 'fcpfw_slider_vwoptbtn_txt'])."</a>";
                                                }
                                            ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            } 
        ?>
    </div>
    <?php
}