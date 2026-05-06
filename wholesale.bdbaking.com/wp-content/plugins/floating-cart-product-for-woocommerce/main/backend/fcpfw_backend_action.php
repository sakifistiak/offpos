<?php
function fcpfw_recursive_sanitize_text_field($array) {
	if(!empty($array)) {
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = fcpfw_recursive_sanitize_text_field($value);
			}else{
				$value = sanitize_text_field( $value );
			}
		}
	}
	return $array;
}

add_action( 'init', 'fcpfw_save_options');
function fcpfw_save_options() {
	if( current_user_can('administrator') ) {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'fcpfw_save_option') {
			if(!isset( $_POST['fcpfw_nonce_field'] ) || !wp_verify_nonce( $_POST['fcpfw_nonce_field'], 'fcpfw_nonce_action' ) ){
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				if(!empty($_REQUEST['fcpfw_comman'])){
					$isecheckbox = array(
						'fcpfw_header_cart_icon',
						'fcpfw_header_close_icon',
						'fcpfw_freeshiping_herder',
						'fcpfw_loop_img',
						'fcpfw_loop_product_name',
						'fcpfw_loop_product_price',
						'fcpfw_loop_total',
						'fcpfw_loop_variation',
						'fcpfw_loop_link',
						'fcpfw_loop_delete',
						'fcpfw_auto_open',
						'fcpfw_auto_close',
						'fcpfw_trigger_class',
						'fcpfw_ajax_cart',
						'fcpfw_qty_box',
						'fcpfw_cart_option',
						'fcpfw_checkout_option',
						'fcpfw_conshipping_option',
						'fcpfw_coupon_field_mobile',
						'fcpfw_mobile',
						'fcpfw_product_cnt',
						'fcpfw_product_out_of_stock',
					);

					foreach ($isecheckbox as $key_isecheckbox => $value_isecheckbox) {
						if(!isset($_REQUEST['fcpfw_comman'][$value_isecheckbox])){
							$_REQUEST['fcpfw_comman'][$value_isecheckbox] ='no';
						}
					}
					
					foreach ($_REQUEST['fcpfw_comman'] as $key_fcpfw_comman => $value_fcpfw_comman) {
						update_option($key_fcpfw_comman, sanitize_text_field($value_fcpfw_comman), 'yes');
					}
				}

				/*if(!empty($_REQUEST['fcpfw_select2'])) {
					$fcpfw_select2 = fcpfw_recursive_sanitize_text_field($_REQUEST['fcpfw_select2'] );
					update_option('fcpfw_select2', $fcpfw_select2, 'yes');
				}else{
					update_option('fcpfw_select2','');
				}*/

				wp_redirect( admin_url( '/admin.php?page=floating-cart' ) );
				exit;
			}
		}
	}
}

add_action( 'wp_ajax_FCPFW_product_ajax','FCPFW_product_ajax');
add_action( 'wp_ajax_nopriv_FCPFW_product_ajax','FCPFW_product_ajax');
function FCPFW_product_ajax() {
	if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'fcpfw_ajax_nonce' ) ) {
		wp_die( 'Security check failed. Nonce is invalid.' );
	}
	
	$return = array();
	$post_types = array( 'product','product_variation');
	$search_results = new WP_Query( array( 
		's'=> sanitize_text_field($_GET['q']),
		'post_status' => 'publish',
		'post_type' => $post_types,
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_stock_status',
				'value' => 'instock',
				'compare' => '=',
			)
		)
	) );

	if( $search_results->have_posts() ) :
	   while( $search_results->have_posts() ) : $search_results->the_post();   
		  	$productc = wc_get_product( $search_results->post->ID );
		  	if ( $productc && $productc->is_in_stock() && $productc->is_purchasable() ) {
			 	$title = $search_results->post->post_title;
			 	$price = $productc->get_price_html();
			 	$return[] = array( $search_results->post->ID, $title, $price);   
		  	}
	   endwhile;
	endif;
		echo json_encode( $return );
	die;
}

?>