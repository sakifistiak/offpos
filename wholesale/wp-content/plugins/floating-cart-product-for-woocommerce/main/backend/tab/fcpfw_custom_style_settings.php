<?php
global $fcpfw_comman , $ocwqv_qfcpfw_icon;
?>
<div id="fcpfw-tab-other" class="tab-content">
	<div class="postbox">
		<div class="postbox-header">
			<h2>Important Setting</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Side Cart Width</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_sidecart_width]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_sidecart_width']); ?>">
						<strong>(in px - eg. 350)</strong>
					</td>
				</tr>
				<tr>
					<th>Side Cart Height</th>
					<td>
						<select name="fcpfw_comman[fcpfw_cart_height]">
							<option value="full" <?php if ($fcpfw_comman['fcpfw_cart_height'] == "full" ) { echo 'selected'; } ?>>Full</option>
							<option value="auto" <?php if ($fcpfw_comman['fcpfw_cart_height'] == "auto" ) { echo 'selected'; } ?>>Auto</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Open Side Cart From</th>
					<td>
						<select name="fcpfw_comman[fcpfw_cart_open_from]">
							<option value="right" <?php if ($fcpfw_comman['fcpfw_cart_open_from'] == "right" ) { echo 'selected'; } ?>>Right</option>
							<option value="left" <?php if ($fcpfw_comman['fcpfw_cart_open_from'] == "left" ) { echo 'selected'; } ?>>Left</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<div class="postbox-header">
			<h2>Header Setting</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Header Font Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_head_ft_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_head_ft_size']); ?>">
					</td>
				</tr>
				<tr>
					<th>Header Font Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_head_ft_clr'])) {
								$fcpfw_head_ft_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_head_ft_clr);?>" name="fcpfw_comman[fcpfw_head_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_head_ft_clr']);?>"/>
					</td>
				</tr>
				<tr>
					<th>Header cart icon</th>
					<td class="ocwqv_icon_choice">
						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_1" <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_1" ) { echo 'checked'; } ?>>
						<label>
						   <?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_1'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_2" <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_2" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_2'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_3"  <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_3" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_3'])); ?>
						</label>
					
						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_4" <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_4" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_4'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_5"  <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_5" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_5'])); ?>
						</label> 

						<input type="radio" name="fcpfw_comman[ofcpfw_shop_icon]" value="shop_icon_6"  <?php if ($fcpfw_comman['ofcpfw_shop_icon'] == "shop_icon_6" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_6'])); ?>
						</label>
					</td>
					
				</tr>
				<tr>
					<th>Header cart icon Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_header_cart_icon_clr'])) {
								$fcpfw_header_cart_icon_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_header_cart_icon_clr); ?>" name="fcpfw_comman[fcpfw_header_cart_icon_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_header_cart_icon_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Header cart close icon</th>
					<td class="ocwqv_icon_choice_close">
						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon" <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon_1" <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_1" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon_1'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon_2"  <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_2" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon_2'])); ?>
						</label>
					
						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon_3" <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_3" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon_3'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon_4"  <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_4" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon_4'])); ?>
						</label> 

						<input type="radio" name="fcpfw_comman[ofcpfw_close_icon]" value="close_icon_5"  <?php if ($fcpfw_comman['ofcpfw_close_icon'] == "close_icon_5" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['close_icon_5'])); ?>
						</label> 
					</td>
				</tr>
				 <tr>
					<th>Header Close icon Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_header_close_icon_clr'])) {
								$fcpfw_header_close_icon_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_header_close_icon_clr); ?>" name="fcpfw_comman[fcpfw_header_close_icon_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_header_close_icon_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Show Freeshipping Text in Header color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_header_shipping_text_color'])) {
								$fcpfw_header_shipping_text_color = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_header_shipping_text_color); ?>" name="fcpfw_comman[fcpfw_header_shipping_text_color]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_header_shipping_text_color']); ?>"/>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">                         
		<div class="postbox-header">
			<h2>Cart Loop Setting</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Product Title Font Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_product_ft_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_product_ft_size']); ?>">
					</td>
				</tr>
				<tr>
					<th>Product Title Font Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_product_ft_clr'])) {
								$fcpfw_product_ft_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_product_ft_clr); ?>" name="fcpfw_comman[fcpfw_product_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_product_ft_clr']); ?>"/>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<div class="postbox-header">
			<h2>Empty Cart</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Cart Empty show/hide all cart detail</th>
					<td>
						<select name="fcpfw_comman[fcpfw_cart_empty_hide_show]" disabled>
							<option value="show" <?php if ($fcpfw_comman['fcpfw_cart_empty_hide_show'] == "show" ) { echo 'selected'; } ?>>Show All Detail</option>
							<option value="hide" <?php if ($fcpfw_comman['fcpfw_cart_empty_hide_show'] == "hide" ) { echo 'selected'; } ?>>Hide All Detail</option>
						</select>
						<label class="fcpfw_comman_link">This Option Available in  <a href="https://www.plugin999.com/plugin/floating-cart-product-for-woocommerce/" target="_blank">Pro Version</a></label>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<div class="postbox-header">
			<h2>Side cart</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<td>
						<h3>Delete Setting</h3>
					</td>
				</tr>
				<tr>
					<th>Delete Icons</th>
					<td class="ocwqv_icon_choice">
						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="ocwqv_trash" <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "ocwqv_trash" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_trash'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_1" <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_1" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_1'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_2" <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_2" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_2'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_3"  <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_3" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_3'])); ?>
						</label>
					
						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_4" <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_4" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_4'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_5"  <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_5" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_5'])); ?>
						</label> 

						<input type="radio" name="fcpfw_comman[ofcpfw_delete_icon]" value="trash_6"  <?php if ($fcpfw_comman['ofcpfw_delete_icon'] == "trash_6" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['trash_6'])); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th>Delete icon Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_delect_icon_clr'])) {
								$fcpfw_delect_icon_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_delect_icon_clr); ?>" name="fcpfw_comman[fcpfw_delect_icon_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_delect_icon_clr']); ?>"/>
					</td>
				</tr>
				 <tr>
					<td>
						<h3>Coupon Field Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Coupon icon</th>
					<td class="ocwqv_icon_choice">
						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon" <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon_1" <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon_1" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon_1'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon_2"  <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon_2" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon_2'])); ?>
						</label>
					
						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon_3" <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon_3" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon_3'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon_4"  <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon_4" ) { echo 'checked'; } ?>>
						<label>
						   	<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon_4'])); ?>
						</label> 

						<input type="radio" name="fcpfw_comman[fcpfw_coupon_icon]" value="coupon_5"  <?php if ($fcpfw_comman['fcpfw_coupon_icon'] == "coupon_5" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['coupon_5'])); ?>
						</label>
					</td>
					
				</tr>
				<tr>
					<th>Apply Coupon icon Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_apply_cpn_icon_clr'])) {
								$fcpfw_apply_cpn_icon_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_apply_cpn_icon_clr); ?>" name="fcpfw_comman[fcpfw_apply_cpn_icon_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_cpn_icon_clr']); ?>"/>
					</td>
				</tr> 
			   
				<tr>
					<th>Apply Coupon Font Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_apply_cpn_ft_clr'])) {
								$fcpfw_apply_cpn_ft_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_apply_cpn_ft_clr); ?>" name="fcpfw_comman[fcpfw_apply_cpn_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_apply_cpn_ft_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Apply Button Text Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_applybtn_cpn_ft_clr'])) {
								$fcpfw_applybtn_cpn_ft_clr = '#ffffff';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_applybtn_cpn_ft_clr); ?>" name="fcpfw_comman[fcpfw_applybtn_cpn_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_applybtn_cpn_ft_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Apply Button Background Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_applybtn_cpn_bg_clr'])) {
								$fcpfw_applybtn_cpn_bg_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_applybtn_cpn_bg_clr); ?>" name="fcpfw_comman[fcpfw_applybtn_cpn_bg_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_applybtn_cpn_bg_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<h3>Slider Product Settings</h3>
					</td>
				</tr>
				<tr>
					<th>Product Font Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_sld_product_ft_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_sld_product_ft_size']); ?>">
					</td>
				</tr>
				<tr>
					<th>Product Font Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_sld_product_ft_clr'])) {
								$fcpfw_sld_product_ft_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_sld_product_ft_clr); ?>" name="fcpfw_comman[fcpfw_sld_product_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_sld_product_ft_clr']); ?>"/>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<div class="postbox-header"> 
			<h2>Shipping Text Customize</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				 <tr>
					<th>Shipping Text</th>
					<td>
						<input type="text" name="fcpfw_comman[fcpfw_ship_txt]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ship_txt']); ?>">
					</td>
				</tr>
				<tr>
					<th>Shipping Text Font Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_ship_ft_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ship_ft_size']); ?>">
					</td>
				</tr>
				<tr>
					<th>Shipping Text Font Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_ship_ft_clr'])) {
								$fcpfw_ship_ft_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_ship_ft_clr); ?>" name="fcpfw_comman[fcpfw_ship_ft_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ship_ft_clr']); ?>"/>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<div class="postbox-header">
			<h2>Footer Button Settings</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Button Row</th>
					<td>
						<select name="fcpfw_comman[fcpfw_footer_button_row]">
							<option value="one" <?php if($fcpfw_comman['fcpfw_footer_button_row'] == "one"){ echo "selected"; } ?>>One in a row ( 1+1+1 )</option>
							<option value="two_one" <?php if($fcpfw_comman['fcpfw_footer_button_row'] == "two_one"){ echo "selected"; } ?>>Two in first row ( 2 + 1 )</option>
							<option value="one_two" <?php if($fcpfw_comman['fcpfw_footer_button_row'] == "one_two"){ echo "selected"; } ?>>Two in last row ( 1 + 2 )</option>
							<option value="three" <?php if($fcpfw_comman['fcpfw_footer_button_row'] == "three"){ echo "selected"; } ?>>Three in one row( 3 )</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Footer Buttons Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_ft_btn_clr'])) {
								$fcpfw_ft_btn_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_ft_btn_clr); ?>" name="fcpfw_comman[fcpfw_ft_btn_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Footer Buttons Text Color</th>
					<td>
						<?php 
							if( !empty($fcpfw_comman['fcpfw_ft_btn_txt_clr'])) {
								$fcpfw_ft_btn_txt_clr = '#ffffff';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_ft_btn_txt_clr); ?>" name="fcpfw_comman[fcpfw_ft_btn_txt_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_txt_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Footer Buttons Margin</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_ft_btn_mrgin]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_ft_btn_mrgin']); ?>">
					</td>
				</tr>
			</table>
		</div>
	</div>              
	<div class="postbox">
		<div class="postbox-header">
			<h2>Cart basket</h2>
		</div>
		<div class="inside">
			<table class="data_table">
				<tr>
					<th>Side cart Basket Icon</th>
					<td class="ocwqv_icon_choice">
						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_qfcpfw_icon" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_qfcpfw_icon" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_qfcpfw_icon'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_1" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_1" ) { echo 'checked'; } ?>>
						<label>
						   <?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_1'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_4" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_4" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_4'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_2" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_2" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_2'])); ?>
						</label>
					
						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_5" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_5" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_5'])); ?>
						</label>

						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_3" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_3" ) { echo 'checked'; } ?>>
						<label>
						   <?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['ocwqv_fcpfw_icon_3'])); ?>
						</label> 

						<input type="radio" name="fcpfw_comman[ocwqv_fcpfw_icon]" value="ocwqv_fcpfw_icon_6" <?php if ($fcpfw_comman['ocwqv_fcpfw_icon'] == "ocwqv_fcpfw_icon_6" ) { echo 'checked'; } ?>>
						<label>
							<?php echo html_entity_decode(esc_attr($ocwqv_qfcpfw_icon['shop_icon_4'])); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th>Side cart Basket Shape</th>
					<td>
						<select name="fcpfw_comman[fcpfw_basket_shape]">
							<option value="square" <?php if($fcpfw_comman['fcpfw_basket_shape'] == "square" || empty($fcpfw_comman['fcpfw_basket_shape'])){ echo "selected"; } ?>>Square</option>
							<option value="round" <?php if($fcpfw_comman['fcpfw_basket_shape'] == "round"){ echo "selected"; } ?>>Round</option>
						</select>
					</td>
				</tr> 
				<tr>
					<th>Basket Position</th>
					<td>
						<select name="fcpfw_comman[fcpfw_basket_position]">
							<option value="top" <?php if($fcpfw_comman['fcpfw_basket_position'] == "top"){ echo "selected"; } ?>>Top</option>
							<option value="bottom" <?php  if($fcpfw_comman['fcpfw_basket_position'] == "bottom" || empty($fcpfw_comman['fcpfw_basket_position'])){ echo "selected"; } ?>>Bottom</option>
						</select>
					</td>
				</tr> 
				<tr>
					<th>Basket Count  Position</th>
					<td>
						<select name="fcpfw_comman[fcpfw_basket_count_position]">
							<option value="top-left" <?php if($fcpfw_comman['fcpfw_basket_count_position'] == "top"){ echo "selected"; } ?>>Top Left</option>
							<option value="bottom-right" <?php  if($fcpfw_comman['fcpfw_basket_count_position'] == "bottom-right" || empty($fcpfw_comman['fcpfw_basket_count_position'])){ echo "selected"; } ?>>Bottom Right</option>
							<option value="bottom-left" <?php if($fcpfw_comman['fcpfw_basket_count_position'] == "bottom-left"){ echo "selected"; } ?>>Bottom Left</option>
							<option value="top-right" <?php  if($fcpfw_comman['fcpfw_basket_count_position'] == "top-right" || empty($fcpfw_comman['fcpfw_basket_count_position'])){ echo "selected"; } ?>>Top-right</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Basket Icon Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_basket_icn_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_basket_icn_size']); ?>">
					</td>
				</tr> 
				<tr>
					<th>Basket Offset ↨</th>
					<td>
					   	<input type="number" name="fcpfw_comman[fcpfw_basket_off_vertical]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_basket_off_vertical']); ?>">
					</td>
				</tr>
				<tr>
					<th>Basket Offset ⟷</th>
					<td>
					   	<input type="number" name="fcpfw_comman[fcpfw_basket_off_horizontal]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_basket_off_horizontal']); ?>">
					</td>
				</tr>
				<tr>
					<th>Basket Background Color</th>
					<td>
						<?php 
							if(!empty($fcpfw_comman['fcpfw_basket_bg_clr'])){
								$fcpfw_basket_bg_clr = '#ffffff';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_basket_bg_clr); ?>" name="fcpfw_comman[fcpfw_basket_bg_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_basket_bg_clr']); ?>"/>
					</td>

				</tr>
				<tr>
					<th>Basket Color</th>
					<td>
						<?php 
							if(!empty($fcpfw_comman['fcpfw_basket_clr'])){
								$fcpfw_basket_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_basket_clr); ?>" name="fcpfw_comman[fcpfw_basket_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_basket_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Count Background Color</th>
					<td>
						<?php 
							if(!empty($fcpfw_comman['fcpfw_cnt_bg_clr'])){
								$fcpfw_cnt_bg_clr = '#000000';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_cnt_bg_clr); ?>" name="fcpfw_comman[fcpfw_cnt_bg_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cnt_bg_clr']); ?>"/>
					</td>
				</tr> 
				<tr>
					<th>Count Text Color</th>
					<td>
						<?php 
							if(!empty($fcpfw_comman['fcpfw_cnt_txt_clr'])){
								$fcpfw_cnt_txt_clr = '#ffffff';
							}
						?>
						<input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo esc_attr($fcpfw_cnt_txt_clr); ?>" name="fcpfw_comman[fcpfw_cnt_txt_clr]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cnt_txt_clr']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>Count Text Size</th>
					<td>
						<input type="number" name="fcpfw_comman[fcpfw_cnt_txt_size]" value="<?php echo esc_attr($fcpfw_comman['fcpfw_cnt_txt_size']); ?>">
					</td>
				</tr> 
			</table>
		</div>
	</div>
</div>