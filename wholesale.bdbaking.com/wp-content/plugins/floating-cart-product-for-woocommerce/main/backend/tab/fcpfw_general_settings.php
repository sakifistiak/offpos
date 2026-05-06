<?php
global $fcpfw_comman , $ocwqv_qfcpfw_icon;
?>
<div id="fcpfw-tab-general" class="tab-content current">
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Show Cart Basket</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Display All Pages</th>
                    <td>
                        <input type="checkbox" class="fcpfw_all_pages" name="fcpfw_comman[fcpfw_all_pages]" value="yes" <?php if($fcpfw_comman['fcpfw_all_pages'] == 'yes'){echo "checked";}?> disabled>
                        <label>All Page</label><br>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr class="fcpfw_single_pages">
                    <th>Selected Pages</th>
                    <td class="scpfw_visibility_on_pages">
                        <input type="checkbox" name="fcpfw_comman[fcpfw_display_home_page]" value="yes" <?php if($fcpfw_comman['fcpfw_display_home_page'] == 'yes'){ echo "checked";}?> disabled>
                        <label>Display On Home Page</label></br>

                        <input type="checkbox" class="fcpfw_display_shop_page" name="fcpfw_comman[fcpfw_display_shop_page]" value="yes" <?php if($fcpfw_comman['fcpfw_display_shop_page'] == 'yes'){ echo "checked";}?> disabled>
                        <label>Display On Shop Page</label></br>

                        <input type="checkbox" class="fcpfw_display_product_page" name="fcpfw_comman[fcpfw_display_product_page]" value="yes" <?php if($fcpfw_comman['fcpfw_display_product_page'] == 'yes'){ echo "checked";}?> disabled>
                        <label>Display On Single Product Page</label></br>

                        <input type="checkbox" name="fcpfw_comman[fcpfw_display_cart_page]" value="yes" <?php if($fcpfw_comman['fcpfw_display_cart_page'] == 'yes'){ echo "checked";}?> disabled>
                        <label>Display On Cart Page</label></br>

                        <input type="checkbox" name="fcpfw_comman[fcpfw_display_checkout_page]" value="yes" <?php if($fcpfw_comman['fcpfw_display_checkout_page'] == 'yes'){ echo "checked";}?> disabled>
                        <label>Display On Checkout Page</label></br>

                        <input type="checkbox" name="fcpfw_comman[product_cat_page]" value="yes" <?php if($fcpfw_comman['product_cat_page'] == 'yes'){echo "checked";}?> disabled>
                        <label>Product Category Page</label><br>

                        <input type="checkbox" name="fcpfw_comman[product_tag_page]" value="yes" <?php if($fcpfw_comman['product_tag_page'] == 'yes'){echo "checked";}?> disabled>
                        <label>Product Tag Page</label>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Side cart</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Auto Open Cart</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_auto_open]" value="yes" <?php if ($fcpfw_comman['fcpfw_auto_open'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>After Add to Cart Immeditaliy Open</strong>
                    </td>
                </tr>
                <tr>
                    <th>Auto Close Cart</th>
                    <td>
                        <input type="checkbox" class= "fcpfw_close_cart" name="fcpfw_comman[fcpfw_auto_close]" value="yes" <?php if ($fcpfw_comman['fcpfw_auto_close'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>After Add to Cart Close After 3 Secound</strong>
                    </td>
                </tr>
                <tr>
                    <th>Trigger to class open cart </th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_trigger_class]" value="yes" <?php if ($fcpfw_comman['fcpfw_trigger_class'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>After Enable trigger then side cart open automatically</strong>
                        <p class="fcpfw-tips">Note:If Enable then You need to add this class<strong>fcpfw_trigger</strong>where you want to add triggers. </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Cart Header</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Show in Header</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_header_cart_icon]" value="yes" <?php if ($fcpfw_comman['fcpfw_header_cart_icon'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Basket Icon</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_header_close_icon]" value="yes" <?php if ($fcpfw_comman['fcpfw_header_close_icon'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Close Icon</strong><br/>
                    </td>   
                </tr>
                <tr>
                    <th>Show Freeshipping in Header</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_freeshiping_herder]" value="yes" <?php if ($fcpfw_comman['fcpfw_freeshiping_herder'] == "yes" ) { echo 'checked="checked"'; } ?>>
                    </td>
                </tr>
                <tr>
                    <th>Show after Freeshipping Text in Header</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_freeshiping_herder_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_freeshiping_herder_txt']); ?>" >
                        <span class="ocwg_desc">Use tag {shipping_total} for Shipping rate</span>
                    </td>
                </tr>
                <tr>
                    <th>Show Freeshipping Text in Header</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_freeshiping_then_herder_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_freeshiping_then_herder_txt']); ?>" >
                        <span class="ocwg_desc">get Freeshipping text</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Cart Loop</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Show in Loop</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_img]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_img'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Product Image</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_product_name]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_product_name'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Product Name</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_product_price]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_product_price'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Product Price</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_total]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_total'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Product Total</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_variation]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_variation'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Product Variations</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_link]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_link'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Link to Product Page</strong><br/>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_loop_delete]" value="yes" <?php if ($fcpfw_comman['fcpfw_loop_delete'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Delete Product</strong><br/>
                    </td>
                </tr>
                <tr>
                    <th>Display Qty Box</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_qty_box]" value="yes" <?php if ($fcpfw_comman['fcpfw_qty_box'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Display Product Qty box.</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Footer Settings</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Show Shipping Total</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_total_shipping_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_total_shipping_option'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show Shipping Total.</strong>
                        <label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show Discount </th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_discount_show_cart]" value="yes" <?php if ($fcpfw_comman['fcpfw_discount_show_cart'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show Discount in cart</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show Tax Total </th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_total_tax_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_total_tax_option'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show Tax Total.</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show All Total </th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_total_all_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_total_all_option'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show All Total.</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show ViewCart Button</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_cart_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_cart_option'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Show Viewcart Button.</strong>
                    </td>
                </tr>
                <tr>
                    <th>Show Checkout Button</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_checkout_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_checkout_option'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Show Checkout Button.</strong>
                    </td>
                </tr>
                <tr>
                    <th>Show Continue Shopping Button</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_conshipping_option]" value="yes" <?php if ($fcpfw_comman['fcpfw_conshipping_option'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Show Continue Shopping Button.</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Coupon Field</h2>
        </div>
         <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Coupon Field on Mobile</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_coupon_field_mobile]" value="yes" <?php if ($fcpfw_comman['fcpfw_coupon_field_mobile'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Enable Coupon Field on Mobile</strong>
                    </td>
                </tr> 
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Cart Product Slider</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                 <tr>
                    <th>Product Slider on Desktop</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_prodslider_desktop]" value="yes" <?php if ($fcpfw_comman['fcpfw_prodslider_desktop'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Enable Product Slider on Desktop</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Product Slider on Mobile</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_prodslider_mobile]" value="yes" <?php if ($fcpfw_comman['fcpfw_prodslider_mobile'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Enable Product Slider on Mobile</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show Type </th>
                    <td>
                        <label>
                            <input type="radio" name="fcpfw_comman[fcpfw_prodslider_enable_disable]" value="slider" <?php checked($fcpfw_comman['fcpfw_prodslider_enable_disable'], 'slider'); ?> disabled>
                            Slider
                        </label>
                        <label>
                            <input type="radio" name="fcpfw_comman[fcpfw_prodslider_enable_disable]" value="side_cart" <?php checked($fcpfw_comman['fcpfw_prodslider_enable_disable'], 'side_cart'); ?> disabled>
                           Side Cart
                        </label>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Show Product</th>
                    <td>
                        <select name="fcpfw_comman[fcpfw_select_recent_related]">
                            <option value="related" <?php if ($fcpfw_comman['fcpfw_select_recent_related'] == "related" ) { echo 'selected'; } ?>>Display Related Product</option>
                            <option value="recent" <?php if ($fcpfw_comman['fcpfw_select_recent_related'] == "recent" ) { echo 'selected'; } ?>>Display Selected Product</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <th>Select Product</th>
                    <td>
                        <?php $productsa = get_option('fcpfw_select2'); ?>
                        <select id="fcpfw_select_product" name="fcpfw_select2[]" multiple="multiple" style="width:100%;max-width:15em;" disabled>
                            <?php 
                                if(!empty($productsa)){
                                    foreach ($productsa as $value) {
                                        $productc = wc_get_product( $value );
                                        if ( !empty($productc) && $productc->is_in_stock() && $productc->is_purchasable() ) {
                                            $title = $productc->get_name();
                                            ?>
                                            <option value="<?php echo esc_attr($value); ?>" selected="selected"><?php echo esc_attr($title); ?></option>
                                            <?php   
                                        }
                                    }
                                }
                            ?>
                        </select> 
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>   
            </table>
        </div>
    </div>
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>Cart basket</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Enable </th>
                    <td>
                        <select name="fcpfw_comman[fcpfw_cart_show_hide]">
                            <option value="fcpfw_cart_show" <?php if ($fcpfw_comman['fcpfw_cart_show_hide'] == "fcpfw_cart_show" ) { echo 'selected'; } ?>>Always Show</option>
                            <option value="fcpfw_cart_hide" <?php if ($fcpfw_comman['fcpfw_cart_show_hide'] == "fcpfw_cart_hide" ) { echo 'selected'; } ?>>Always Hide</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Cart basket Hide</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_cart_empty]" value="yes" <?php if ($fcpfw_comman['fcpfw_cart_empty'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>If Cart is Empty Then Cart Basket Hide</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Cart Icon</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_show_cart_icn]" value="yes" <?php if ($fcpfw_comman['fcpfw_show_cart_icn'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show Cart Icon</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>   
                <tr>
                    <th>On Cart & Checkout Page</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_cart_check_page]" value="yes" <?php if ($fcpfw_comman['fcpfw_cart_check_page'] == "yes" ) { echo 'checked="checked"'; } ?> disabled>
                        <strong>Show Cart Basket on cart and checkout pages.</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr>
                <tr>
                    <th>Cart on Mobile</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_mobile]" value="yes" <?php if ($fcpfw_comman['fcpfw_mobile'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Show Cart on mobile device.</strong>
                    </td>
                </tr> 
                <tr>
                    <th>Product Count</th>
                    <td>
                        <input type="checkbox" name="fcpfw_comman[fcpfw_product_cnt]" value="yes" <?php if ($fcpfw_comman['fcpfw_product_cnt'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Show Product Count.</strong>
                    </td>
                </tr>
                <tr>
                    <th>Remove Product From Cart If Not In Stock</th>
                    <td>
                    <input type="hidden" name="fcpfw_comman[fcpfw_product_out_of_stock]" value="no">
                        <input type="checkbox" name="fcpfw_comman[fcpfw_product_out_of_stock]" value="yes" <?php if ($fcpfw_comman['fcpfw_product_out_of_stock'] == "yes" ) { echo 'checked="checked"'; } ?>>
                        <strong>Remove Product From Cart If Not In Stock.</strong>
                    </td>
                </tr>
                <tr>
                    <th>Basket Count Type</th>
                    <td>
                        <select name="fcpfw_comman[fcpfw_product_cnt_type]">
                            <option value="sum_qty" <?php if ($fcpfw_comman['fcpfw_product_cnt_type'] == "sum_qty" ) { echo 'selected'; } ?>>Sum of Quantity of all the products</option>
                            <option value="num_qty" <?php if ($fcpfw_comman['fcpfw_product_cnt_type'] == "num_qty" ) { echo 'selected'; } ?>>Number of products</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <th>Basket Product ordering</th>
                    <td>
                        <select name="fcpfw_comman[fcpfw_cart_ordering]">
                            <option value="asc" <?php if ($fcpfw_comman['fcpfw_cart_ordering'] == "asc" ) { echo 'selected'; } ?>>Recently added item at last (Asc)</option>
                            <option value="desc" <?php if ($fcpfw_comman['fcpfw_cart_ordering'] == "desc" ) { echo 'selected'; } ?>>Recently added item on top (Desc)</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <th>Hide Basket Pages</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_on_pages]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_on_pages']); ?>" disabled>
                        <strong>Do not show basket on pages.</strong>
                        <strong>Use page id separated by comma. For eg: 31,41,51</strong>
                        <label class="fcpfw_comman_link">This Option Available in <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
                    </td>
                </tr> 
            </table>
        </div>
    </div> 
    <div class="postbox">
        <div class="postbox-header inside">
            <h2>All Urls Set</h2>
        </div>
        <div class="inside">
            <table class="data_table">
                <tr>
                    <th>Continue Shopping Button Link</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_conshipping_link]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_conshipping_link']); ?>">
                        <strong>Use "#" for the same page</strong>
                    </td>
                </tr>
                <tr>
                    <th>Empty Cart Button Link</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_emptycart_link]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_emptycart_link']); ?>">
                        <strong>Use "#" for the same page</strong>
                    </td>
                </tr>
                <tr>
                    <th>Custom Cart Button Link</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_orgcart_link]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_orgcart_link']); ?>">
                        <strong>if is empty then going cart page</strong>
                    </td>
                </tr>
                <tr>
                    <th>Custom checkout Button Link</th>
                    <td>
                        <input type="text" name="fcpfw_comman[fcpfw_orgcheckout_link]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_orgcheckout_link']); ?>">
                        <strong>if is empty then going checkout page</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>  
</div>