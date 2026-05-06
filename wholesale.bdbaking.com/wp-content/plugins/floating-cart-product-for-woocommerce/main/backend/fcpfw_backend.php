<?php
add_action( 'admin_menu','fcpfw_submenu_page');
function fcpfw_submenu_page() {
	add_submenu_page( 'woocommerce', 'Floating Cart', 'Floating Cart', 'manage_options', 'floating-cart','fcpfw_callback');
}

function fcpfw_callback() {
	global $fcpfw_comman , $ocwqv_qfcpfw_icon;
	?>
		<div class="wrap">
			<h2>Cart Setting</h2>
			<div class="card fcpfw_notice">
			<h2>Please help us spread the word & keep the plugin up-to-date</h2>
				<p>
					<a class="button-primary button" title="Support Floating Cart Product" target="_blank" href="https://www.plugin999.com/support/">Support</a>
					<a class="button-primary button" title="Rate Floating Cart Product" target="_blank" href="https://wordpress.org/support/plugin/floating-cart-product-for-woocommerce/reviews/?filter=5">Rate the plugin ★★★★★</a>
				</p>
			</div>
			<?php if(isset($_REQUEST['message'])  && $_REQUEST['message'] == 'success'){ ?>
				<div class="notice notice-success is-dismissible"> 
					<p><strong>Record updated successfully.</strong></p>
				</div>
			<?php } ?>
		</div>
		<div class="fcpfw_container">
			<form method="post" >
				<?php wp_nonce_field( 'fcpfw_nonce_action', 'fcpfw_nonce_field' ); ?>
				<ul class="nav-tab-wrapper woo-nav-tab-wrapper">
					<li class="nav-tab" data-tab="fcpfw-tab-general">General Settings</li>
					<li class="nav-tab" data-tab="fcpfw-tab-other">Custom Style</li>
					<li class="nav-tab" data-tab="fcpfw-tab-translations">Translations</li>
				</ul>
			   
				<?php 
				include_once('tab/fcpfw_general_settings.php');
				include_once('tab/fcpfw_custom_style_settings.php');
				include_once('tab/fcpfw_translation_settings.php');
				?>
				
				<input type="hidden" name="action" value="fcpfw_save_option">
				<input type="submit" value="Save changes" name="submit" class="button-primary" id="fcpfw-btn-space">
			</form>  
		</div>
	<?php
}

