<?php
global $fcpfw_comman , $ocwqv_qfcpfw_icon;
?>

<div id="fcpfw-tab-translations" class="tab-content">
	<div class="postbox">
		<div class="postbox-header">
			<h2>Translations</h2>                               
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<td>
						<h3>Title Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Head Title</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_head_title]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_head_title']); ?>">
					</td>
				</tr>
				<tr>
					<th>QTY Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_qty_text]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_qty_text']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<h3>Coupon Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Cart is empty Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_cart_is_empty]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cart_is_empty']); ?>">
					</td>
				</tr>
				<tr>
					<th>Apply Coupon Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_apply_cpn_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_cpn_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Apply Coupon Placeholder Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_apply_cpn_plchldr_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_cpn_plchldr_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Apply Coupon Apply Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_apply_cpn_apbtn_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_cpn_apbtn_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Coupon Field Empty Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_cpnfield_empty_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cpnfield_empty_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Coupon Already Applied Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_cpn_alapplied_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cpn_alapplied_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Invalid Coupon Code Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_invalid_coupon_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_invalid_coupon_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Coupon Applied Successfully Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_coupon_applied_suc_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_coupon_applied_suc_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Coupon Removed Successfully Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_coupon_removed_suc_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_coupon_removed_suc_txt']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<h3>Product Slider Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Add to Cart Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_slider_atcbtn_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_slider_atcbtn_txt']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
				<tr>
					<th>View Options Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_slider_vwoptbtn_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_slider_vwoptbtn_txt']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Cart Footer Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Subtotal Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_subtotal_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_subtotal_txt']); ?>">
					</td>
				</tr>
				
				<tr>
					<th>View Cart Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_cart_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cart_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Checkout Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_checkout_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_checkout_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Continue Shopping Button Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_conshipping_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_conshipping_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Shipping</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_shipping_text_trans]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_shipping_text_trans']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
				<tr>
					<th>Tax</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_apply_taxt_testx]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_taxt_testx']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
				 <tr>
					<th>Discount Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_discount_text_trans]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_discount_text_trans']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
				<tr>
					<th>Total</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_apply_total_text]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_total_text']); ?>" disabled>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>